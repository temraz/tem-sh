<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->load->view('civou/admin_log');
	}
	public function panel()
	{
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		$data['unconfirmed_users'] = $this->admin_model->get_unconfirmed_user();
		$this->load->view('civou/panel',$data);
	}else {
		 redirect('admin');
		}
	}
	public function users()
	{
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		$data['users'] = $this->admin_model->get_confirmed_user();
		$this->load->view('civou/users',$data);
		}else {
		 redirect('admin');
		}
	}
	public function events()
	{
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		$this->load->view('civou/events');
		}else {
		 redirect('admin');
		}
	}
	public function allevents()
	{
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		$data['events'] = $this->admin_model->get_all_events();
		$this->load->view('civou/all_events',$data);
		}else {
		 redirect('admin');
		}
	}
	public function unconfirmed()
	{
		if ($this->session->userdata('logged_in_admin')) {
		if($id= $this->uri->segment(3) != ''){	
		$event_data = array("event_id" => $this->uri->segment(3));
                $this->session->set_userdata($event_data);
		$this->load->model('civou/admin_model');
		$id= $this->uri->segment(3);
		$data['unconfirmed_attends'] = $this->admin_model->get_unconfirmed($id);
		$this->load->view('civou/unconfirmed_attends',$data);}
		else {
			redirect('admin/allevents');
			}
		}else {
		 redirect('admin');
		}
	}
	public function attends()
	{
		if ($this->session->userdata('logged_in_admin')) {
		if($id= $this->uri->segment(3) != ''){	
		$event_data = array("event_id" => $this->uri->segment(3));
                $this->session->set_userdata($event_data);
		$this->load->model('civou/admin_model');
		$id= $this->uri->segment(3);
		$data['attends'] = $this->admin_model->get_attends($id);
		$this->load->view('civou/attends',$data);}
		else {
			redirect('admin/allevents');
			}
		}else {
		 redirect('admin');
		}
	}
	
	
////////////////////////////////////////////insert event //////////////
	public function insert_event(){
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		  $flag['inserted']=0;
		$this->load->library('form_validation');
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|max_length[25]|trim|xss_clean|alpha');
		
       if ($this->form_validation->run()) {
		   
		      $gallery_path = realpath(APPPATH . '../images/events/');
        $config['upload_path'] = $gallery_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
        $config['max_size'] = '20000';
        $this->load->library('upload', $config);
        if($this->upload->do_upload('photo')){
            $phot_data = $this->upload->data();
            $photo_name = $phot_data['file_name'];
		   } else {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('civou/events', $error);
	   }
	   $event_name = $this->input->post('event_name');
	   $event_date = $this->input->post('event_date');
	   $about_event = $this->input->post('about_event');
	   $facebook_url = $this->input->post('facebook');
	   $twitter_url = $this->input->post('twitter');
	   $data = array (
	   'event_name' => $event_name,
	   'event_date' => $event_date ,
	   'about_event' => $about_event,
	   'event_logo' => $photo_name,
	   'facebook_url' => $facebook_url,
	   'twitter_url' => $twitter_url
	   );
	  if($this->db->insert('events',$data)){
		  $flag['inserted']=1;
		  $this->load->view('civou/events' , $flag);
		  }
	   }else {
		    $this->load->view('civou/events');
		   }
		   }else {
		 redirect('admin');
		}
		}
 ///////////////////////////////////////////////////////////////////////////////////// validate user
   
 ///////////////////////////////
    public function login_validation() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('admin', 'Admin Name', 'required|trim|xss_clean|callback_validate_credentials');
        $this->form_validation->set_rules('password', 'Password', 'required|md5|xss_clean|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['login']=1;
            $this->load->view('civou/admin_log',$data);
        } else {

            $this->load->model('civou/admin_model');

            $admin_name = $this->input->post('admin');
            $password = $this->input->post('password');
            if ($this->admin_model->check_can_log_in($admin_name, $password)) {
                $username = $this->input->post('admin');
                $password = $this->input->post('password');

                $user = $this->admin_model->check_can_log_in($admin_name, $password);

                $login_data = array("logged_in_admin" => true, "user_id" => $user['id']);
                $this->session->set_userdata($login_data);
                redirect('admin/panel');
            } else {

                redirect('admin/error');
            }
        }
    }
	///////////////////////////////
	
	function logout() {
        $this->session->sess_destroy();
        redirect('admin/');
    }
	
    /////////////////////////////
    public function validate_credentials() {
        $this->load->model('civou/admin_model');

        if ($this->admin_model->can_log_in()) {
            return true;
        } else {
            $this->form_validation->set_message('validate_credentials', 'Email or Password is incorrect');
            return false;
        }
    }	
	
	
	
	
///////////////////////////////////////////	
 public function confirm(){
	 if ($this->session->userdata('logged_in_admin')) {
	 $id=$this->uri->segment(3);
	 $this->load->model('civou/admin_model');
	 $data = array('confirm' => 1);
	$this->db->where('id',$id);
			if( $this->db->update('users',$data)){
				
		redirect('admin/panel');
		}	
		}else {
		 redirect('admin');
		} 
	 }
	 
	////////////////////////////////////////
	public function attending(){
	 if ($this->session->userdata('logged_in_admin')) {
	 $id=$this->uri->segment(3);
	 $event_id=$this->uri->segment(4);
	 $this->load->model('civou/admin_model');
	 $data = array('confirm' => 1 , 
	 'wait' => 0);
	$this->db->where('id',$id);
			if( $this->db->update('user_events',$data)){
		redirect('admin/unconfirmed/'.$event_id);
		}	
		}else {
		 redirect('admin');
		} 
	 }
	//////////////////////////////////////////////
	function add_category(){
	if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		$this->load->view('civou/add_category');
		}else {
		 redirect('admin');
		} 
		} 
		//////////////////////////////////////////////
	function add_sub_category(){
	if ($this->session->userdata('logged_in_admin')) {
		
		$this->load->model('civou/admin_model');
		if($this->admin_model->get_category()){
			$data['cats']=$this->admin_model->get_category();
			$this->load->view('civou/add_sub_category',$data);
			}
		
		}else {
		 redirect('admin');
		} 
		} 
	//////////////////////////////////////////////////
	function insert_category(){
		$this->load->model('civou/admin_model');
		  $flag['inserted']=0;
		$this->load->library('form_validation');
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required|max_length[100]|trim|xss_clean|alpha');
		
       if ($this->form_validation->run()) {
		    $data = array (
	   'name' => $this->input->post('cat_name'),
	   
	   );
		    if($this->db->insert('pic_dept',$data)){
		  $flag['inserted']=1;
		  $this->load->view('civou/add_category' , $flag);
		  }
	   else {
		    $this->load->view('civou/add_category');
		   }
		   
		  
		   }else{
        $this->load->model('civou/admin_model');
		$this->load->view('civou/add_category');
			   }
		}
		//////////////////////////////////////////////////
	function insert_sub_category(){
		$this->load->model('civou/admin_model');
		  $flag['inserted']=0;
		$this->load->library('form_validation');
        $this->form_validation->set_rules('sub_cat_name', 'Sub Category Name', 'required|max_length[100]|trim|xss_clean|numirc');
		 $this->form_validation->set_rules('cat_name', 'Sub Category Name', 'required|max_length[100]|trim|xss_clean');
		
       if ($this->form_validation->run()) {
		    $data = array (
		'dept_id' => $this->input->post('cat_name'),	
	   'name' => $this->input->post('sub_cat_name'),
	   
	   );
		    if($this->db->insert('pic_sub_dept',$data)){
		  $flag['inserted']=1;
		  $this->load->view('civou/add_sub_category' , $flag);
		  }
	   else {
		    $this->load->view('civou/add_sub_category');
		   }
		   
		  
		   }else{
        $this->load->model('civou/admin_model');
		$this->load->view('civou/add_sub_category');
			   }
		}	
	//////////////////////////////////////////////////////////
	function photo_gallery(){
		
	if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		if($this->admin_model->get_category()){
			$data['cats']=$this->admin_model->get_category();
			$data['users']=$this->admin_model->get_all_user();
			$this->load->view('civou/add_photo_gallery',$data);
			}
		
		}else {
		 redirect('admin');
		} 
		} 
	//////////////////////////////////////////////////////////
	function show_delete_category(){
		if ($this->session->userdata('logged_in_admin')) {
		$this->load->model('civou/admin_model');
		if($this->admin_model->get_category()){
			$data['cats']=$this->admin_model->get_category();
		
			$this->load->view('civou/add_sub_category',$data);
			}else{
				$this->load->view('civou/add_sub_category');
				}
		
		}else {
		 redirect('admin');
		} 
		}
	function delete_category(){
		
	if ($this->session->userdata('logged_in_admin')) {
		if($this->uri->segment(3) != ''){
		$id= $this->uri->segment(3);
		$this->load->model('civou/admin_model');
		if($this->admin_model->delete_category($id)){
			$data['inserted']=1;
			$data['cats']=$this->admin_model->get_category();
			
			$this->load->view('civou/add_sub_category',$data);
			}else{
				$data['inserted']=0;
			$data['cats']=$this->admin_model->get_category();
			
			$this->load->view('civou/add_sub_category',$data);
				}
		
		}else {
		 redirect('admin');
		} }else {
		 redirect('admin');
		} 
		} 	
		
		
}


