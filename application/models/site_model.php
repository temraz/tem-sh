<?php

class Site_model extends CI_Model {
public function add_temp_user($key){
					
					 
						$data=array(
						'name'=>$this->input->post('username'),
						'email'=>$this->input->post('email'),
						'password'=>$this->input->post('password'),
						'phone'=>$this->input->post('phone'),
						'mobile'=>$this->input->post('mobile'),
						'birthdate'=>$this->input->post('birthdate'),
						'prof'=>$this->input->post('prof'),
						'job'=>$this->input->post('field'),
						'city'=>$this->input->post('city'),
						'hobbit'=>$this->input->post('hobbies'),						
						'key'=>$key
						);
					
					$query=$this->db->insert('temp_users',$data);
					if($query){
						return true;
						}else {
							return false;
							}
					}
  
/////////////////////////////////////add the user to it's orgin table //////////////////////////////////////////
 
		 public function is_key_valid_user($key){
				$this->db->where('key',$key);
				$query=$this->db->get('temp_users');
				if($query->num_rows()==1){
					return true;
					}else{
						return false;
						}
				}
         //////////////////////////////////////////
		 	public function add_user($key){
					$this->db->where('key',$key);
					$temp_user=$this->db->get('temp_users');
					
					if($temp_user){
						$row=$temp_user->row();
						$data=array(
						
						'name'=>$row->name,
						'email'=>$row->email,
						'password'=>$row->password,
						'phone'=>$row->phone,
						'mobile'=>$row->mobile,
						'birthdate'=>$row->birthdate,
						'prof'=>$row->prof,
						'job'=>$row->job,
						'city'=>$row->city,
						'hobbit'=>$row->hobbit,
						);
						
						
						$did_add_user=$this->db->insert('users',$data);
						
						if($did_add_user){
							$this->db->where('key',$key);
							$this->db->delete('temp_users');
							return $data['email'];
							}else{
								return false;
								}
						
						
						}
						
				}
	///////////////////////////////////////////login method////////////////////////////////////////////
	  public function check_can_log_in($username, $password){
       
        $query = "select id ,email from users where email=? and password=?  ";
      $result=$this->db->query($query,array($username,$password,$password));
       if ( $result) {
          $result=array('id'=>$result->row(0)->id, 'email'=>$result->row(0)->email);
	   return  $result; 
        } else {
            return false;
        }
        }
		///////////////////////////////////////////////////////////////
		    public function can_log_in(){
        $username=  $this->input->post('email');
        $password= md5($this->input->post('password'));
        
      // $emaiil= $this->db->where('email', $this->input->post('email'));
      // $password= $this->db->where('password', md5($this->input->post('password')));
        
        $query = "select id from users where email=? and password=?";
        $result=$this->db->query($query,array($username,$password,$password));
        
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
        
    }
	////////////////////////////////////////////////////////////
	function select_user($id){
		$query="select id,email,username,phone,country,city,address,profile_pic,zip_code from user where id=?";
		 $result=$this->db->query($query,$id);
		 if($result->num_rows() == 1){
			 $data_result=array('id'=>$result->row(0)->id,'username'=>$result->row(0)->username, 'address'=>$result->row(0)->address ,
				                   'city'=>$result->row(0)->city,'country'=>$result->row(0)->country,'email'=>$result->row(0)->email,'pic'=>$result->row(0)->profile_pic,
								   'phone'=>$result->row(0)->phone,'zip_code'=>$result->row(0)->zip_code
								     );
				return  $data_result; 
			 
			 }else{
				 return false;
				 }
		}
	

////////////////////////////////////////////////////////////////////////

function contact_form($name,$mail,$type,$message){
	$sql='insert into contact(name,mail,message,type)
			              values(?,?,?,?)';
		$result=$this->db->query($sql,array($name,$mail,$message,$type));
		if ($this->db->affected_rows()==1) {
            return true;
        } else {
            return false;
        }				  
	}
////////////////////////////////////////////
function select_contacts(){
	$sql='select * from contact ';
	$result=$this->db->query($sql);
	if ($result->num_rows() >=1) {
            return $result;
        } else {
            return false;
        }
	}
	/////////////////////////////////
	function select_contacts_level2($id){
		$sql='select * from contact where id=? ';
	$result=$this->db->query($sql,$id);
	if ($result->num_rows() >=1) {
            return $result;
        } else {
            return false;
        }
		}	
		//////////////////////////////
		function read_message($id){
			$v=1;
			$sql='update contact set `read`=? where id=? ';
	$result=$this->db->query($sql,array($v,$id));
	if ($this->db->affected_rows()==1) {
            return true;
        } else {
            return false;
        }
			}
		
	
	
}



?>
