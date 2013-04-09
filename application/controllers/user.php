<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    function index(){
        
        $this->profile();
        
    }
    ///////////////////
    function profile(){
         if ($this->session->userdata('logged_in')) {
             
			$id=$this->session->userdata('user_id');
			$this->load->model('site_model');
			if($this->site_model->select_user($id)){				
				$user_data=$this->site_model->select_user($id);
				$data['user_id']=$user_data['id']; 
				$data['username']=$user_data['username'];
				$data['email']=$user_data['email'];
				$data['city']=$user_data['city'];
				$data['job']=$user_data['job'];
				$data['prof']=$user_data['prof'];
				$data['pic']=$user_data['pic'];
				$data['hobbit']=$user_data['hobbit'];

				$id=$user_data['id'];
				if ($this->session->userdata('user_id')==$id) {
					 $data['owner']='yes';
					 }else{
						 $data['owner']='no';
						 }
				}
				
						 
            $this->load->view('profile',$data);
            
        }else{
            redirect('home');
        }
        
        
    }
	
	//////////////////////////////////////// upload profile pic
	
	function upload_pic(){
		 if ($this->session->userdata('logged_in')) {
			 $this->load->model('user_model');
		if($this->input->post('post_upload2')){
			 $id=$this->session->userdata('user_id');
			$upload=$this->user_model->do_upload($id);			
			$data['error']="svsdf";
			redirect('user/profile',$data);
			}
			
			 
			 }else{  redirect('site/index');}
		
		}
		
/////////////////////////////////////////////////////		
 ///////////////////
    function edit_profile(){
         if ($this->session->userdata('logged_in')) {
             
			// print_r($this->session->userdata); 
			$id=$this->session->userdata('user_id');
			$this->load->model('site_model');
			if($this->site_model->select_user($id)){
				$user_data=$this->site_model->select_user($id);
				$data['id']=$user_data['id'];
				$data['username']=$user_data['username'];
				$data['email']=$user_data['email'];
				$data['city']=$user_data['city'];
				$data['address']=$user_data['address'];
				$data['phone']=$user_data['phone'];
				$data['country']=$user_data['country'];
				$data['zip_code']=$user_data['zip_code'];
				$data['pic']=$user_data['pic'];
				$id=$user_data['id'];
				}
				
				 if ($this->session->userdata('user_id')==$id) {
					 $data['owner']='yes';
					 }else{
						 $data['owner']='no';
						 }
						 
            $this->load->view('user_edit',$data);
            
        }else{
            redirect('site/index');
        }
        
    }
	/////////////////////////////////////////////////////////////
	public function edit_user_validation(){
		if ($this->session->userdata('logged_in')) {
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('email', 'Email', 
			                                 'required|trim|xss_clean|valid_email|max_length[100]|
											 ');
			$this->form_validation->set_rules('country', 'Country', 'required|trim|xss_clean');
			$this->form_validation->set_rules('city', 'city', 'required|max_length[30]|trim|xss_clean');
			$this->form_validation->set_rules('zip_code', 'Zip code', 'required|max_length[30]|trim|xss_clean|numeric');
			
											 
			$this->form_validation->set_rules('address', 'Address', 'required|max_length[100]|trim|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[20]|trim|xss_clean|numeric');
			
			
			
			

           
			 $this->form_validation->set_message('valid_email',"البريد الالكتروني الذي تم ادخاله غير صحيح ");
			
			  

			
			if($this->form_validation->run()){
			 
             
			// print_r($this->session->userdata); 
			$id=$this->session->userdata('user_id');
			$this->load->model('user_model');
			if($this->user_model->update_user($id)){
			$data['updated']='تم تعديل بياناتك بنجاح';
			
			
			$id=$this->session->userdata('user_id');
			$this->load->model('site_model');
			if($this->site_model->select_user($id)){
				$user_data=$this->site_model->select_user($id);
				$data['id']=$user_data['id'];
				$data['username']=$user_data['username'];
				$data['email']=$user_data['email'];
				$data['city']=$user_data['city'];
				$data['address']=$user_data['address'];
				$data['phone']=$user_data['phone'];
				$data['country']=$user_data['country'];
				$data['zip_code']=$user_data['zip_code'];
				$data['pic']=$user_data['pic'];
				}
            $this->load->view('user_edit',$data);
			
			
			
			}
				
				}else{
					
					$id=$this->session->userdata('user_id');
			$this->load->model('site_model');
			if($this->site_model->select_user($id)){
				$user_data=$this->site_model->select_user($id);
				$data['id']=$user_data['id'];
				$data['username']=$user_data['username'];
				$data['email']=$user_data['email'];
				$data['city']=$user_data['city'];
				$data['address']=$user_data['address'];
				$data['phone']=$user_data['phone'];
				$data['country']=$user_data['country'];
				$data['zip_code']=$user_data['zip_code'];
				$data['pic']=$user_data['pic'];
				}
				
			$data['not_updated']='عفوا لا يمكن تعديل بيناتك حاليا حاول مره اخري من فضلك';
            $this->load->view('user_edit',$data);
			
			
					
			
						}		
			}else{
				 redirect('site/index');
				}
			}				
		
	function visit_profile(){
		if($this->session->userdata('logged_in')){
		if($this->uri->segment(3) != ''){
			$user_id=$this->uri->segment(3);
			$this->load->model('user_model');
			if($this->user_model->can_visit_user($user_id)){
				
				
				$this->load->model('site_model');
			if($this->site_model->select_user($user_id)){
				$user_data=$this->site_model->select_user($user_id);
				$data['recev_id']=$user_data['id'];
				$data['username']=$user_data['username'];
				$data['email']=$user_data['email'];
				$data['city']=$user_data['city'];
				$data['country']=$user_data['country'];
				$data['pic']=$user_data['pic'];
				$data['user_id']=$user_data['id'];
		
				
				$id=$user_data['id'];
				if ($this->session->userdata('user_id')==$id) {
					 $data['owner']='yes';
					 }else{
						 $data['owner']='no';
						 }
				}
				
				 
						 
            $this->load->view('user_profile',$data);
            
				
				}else{
				redirect('site/error');
				}
			}else{
				redirect('site/error');
				}
			}else{
			     redirect('site/index');
				}
		
		
		}
		
	
	
}

?>