<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}
	
////////////////////////////////////////////
public function profile()
	{
		$this->load->view('profile');
	}
	//////////////////////////
	public function events()
	{
		$this->load->model('site_model');
		$data['all_events']=$this->site_model->get_event();
		$this->load->view('events',$data);
	}
        //////////////////////////
        function portfolio(){
            $this->load->view('photo_gallery');    
        }
        
        //////////////////////////
        function contact_us(){
            $this->load->view('contact_us');
            
        } 
        
 ///////////////////////////////////////////////////////////////////////////////////// validate user
    public function sign_user_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'required|max_length[25]|trim|xss_clean|is_unique[users.name]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email|max_length[150]|is_unique[users.email]
											 ');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|max_length[250]|trim'); 								 
		$this->form_validation->set_rules('r_password', 'Confirm Password', 'required|matches[password]|md5|max_length[250]|trim');
		 $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[11]|trim|xss_clean|numeric');
		  $this->form_validation->set_rules('mobile', 'Mobile', 'required|max_length[11]|trim|xss_clean|numeric');
		 $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|max_length[10]|');
		 $this->form_validation->set_rules('Profession', 'profession', 'required|trim|xss_clean|max_length[30]');  
		 $this->form_validation->set_rules('field', 'Jop field', 'required|trim|xss_clean|max_length[25]|');  
		
       
        $this->form_validation->set_rules('city', 'city', 'required|max_length[30]|trim|xss_clean');
       
         $this->form_validation->set_rules('hobbies', 'hobbies', 'required|trim|xss_clean|max_length[300]|min_length[60]');
       
       

        if ($this->form_validation->run()) {
            //generate a rundom key
            $key = md5(uniqid());
//			$this->load->library('email', array('mailtype'=>'html'));
//			$this->email->from('me@website.com',"temraz");
//			$this->email->to($this->input->post('email'));
//			$this->email->subject("www.banktime.com");
//	        $message="<p> Thank you for your registration and you can activate your acount from here </p>";
//			$message.="<p><a href='".base_url()."home/register_user/$key' >click here</a>Activate your acout</p>";
//			$this->email->message($message);
//			if($this->email->send()){
//				echo " تم ارسال الرساله بنجاح";
//				}else{
//					echo "غير قادر علي ارسال الرساله حاليا حاول مره اخري من فضلك";
//					}
//			
            //send email to the user			
            //add them ti the temp_users db
            $this->load->model('site_model');

            if ($this->site_model->add_temp_user($key)) {
                //$data['regist']='تم التسجيل بنجاح, من فضلك اذهب الي بريدك الالكتروني لتفعيل حسابك ,شكرا لك';
                //$this->load->view('user_register',$data);
                $data['key'] = $key;
                $this->load->view("activation", $data);
            }else{
				
				}
			
        } else {
             $data['regist']=1;
            $this->load->view('home',$data);
        }
		
		
		
		
    }

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

        $this->form_validation->set_rules('email', 'email', 'required|trim|xss_clean|callback_validate_credentials');
        $this->form_validation->set_rules('password', 'Password', 'required|md5|xss_clean|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['login']=1;
            $this->load->view('home',$data);
        } else {

            $this->load->model('site_model');

            if ($this->site_model->check_can_log_in()) {
               

                $user = $this->site_model->check_can_log_in();

                $login_data = array("logged_in" => true, "user_id" => $user['id'], "user_email" => $user['email']);
                $this->session->set_userdata($login_data);
                redirect('user/profile');
            } else {

                redirect('home/error');
            }
        }
    }

    /////////////////////////////
    public function validate_credentials() {
        $this->load->model('site_model');

        if ($this->site_model->can_log_in()) {
            return true;
        } else {
            $this->form_validation->set_message('validate_credentials', 'Email or Password is incorrect');
            return false;
        }
    }	
/////////////////////////////////////////
function logout() {
        $this->session->sess_destroy();
        redirect('home/');
    }
	
	
	
///////////////////////////////////////////	

public function event()
	{
		/*if ($this->session->userdata('logged_in')) {*/
			$this->load->model('event_model');
			$user_id = $this->session->userdata('user_id');
			$id= $this->uri->segment(3);
			if($this->event_model->is_event_valid($id) && $this->uri->segment(3) != ''){
				$data['user_event'] = $this->event_model->user_event($user_id , $id);
				$data['event_details']=$this->event_model->get_event($id);
				$this->load->view('event',$data);
				}else{
					redirect('home/events');
					}
	/*}
	else{
            redirect('home');
        }*/
	}
	
	/////////////////////////////////////////
	public function attend()
	{
		if ($this->session->userdata('logged_in')) {
			$this->load->model('event_model');
			$user_id = $this->session->userdata('user_id');
			$event_id= $this->uri->segment(3);
			$data = array( 'user_id'=>$user_id , 
			'event_id'=>$event_id,
			'wait'=>1);
			if($this->db->insert('user_events',$data)){
				redirect('home/event/'.$event_id);
				}
	}
	else{
            redirect('home');
        }
	}
	
}

