<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->load->view('civou/admin_log');
	}
	public function panel()
	{
		$this->load->model('civou/admin_model');
		$data['unconfirmed_users'] = $this->admin_model->get_unconfirmed_user();
		$this->load->view('civou/panel',$data);
	}
	public function users()
	{
		$this->load->model('civou/admin_model');
		$data['users'] = $this->admin_model->get_confirmed_user();
		$this->load->view('civou/users',$data);
	}
	public function events()
	{
		$this->load->model('civou/admin_model');
		$this->load->view('civou/events');
	}
////////////////////////////////////////////insert event //////////////
	public function insert_event(){
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
		}
 ///////////////////////////////////////////////////////////////////////////////////// validate user
   

    ///////////////////////////   email activation ////////////////////////////////// 
    public function register_user() {
		 if ($this->uri->segment(3) != '') {
			 $key2=$this->uri->segment(3);
        $this->load->model('site_model');

        if ($this->site_model->is_key_valid_user($key2)) {
            if ($newmail = $this->site_model->add_user($key2)) {

                //$data=array(
                //'email'=>$newmail,
                //'is_logged_in'=>1
                //);
                //$this->session->set_userdata($data);
                redirect('home/');
            } else {

                echo"فشل في تفعيل الحساب ,من فضلك حاول مره اخري";
            }
        } else {
            echo "رابط التفعيل غير صحيح";
        }
		 }else{
			redirect('home/error');
			 }
    }
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

                $login_data = array("logged_in" => true, "user_id" => $user['id']);
                $this->session->set_userdata($login_data);
                redirect('admin/panel');
            } else {

                redirect('admin/error');
            }
        }
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
	 $id=$this->uri->segment(3);
	 $this->load->model('civou/admin_model');
	 $data = array('confirm' => 1);
	$this->db->where('id',$id);
			if( $this->db->update('users',$data)){
				
		redirect('admin/panel');
		}	 
	 }
}


