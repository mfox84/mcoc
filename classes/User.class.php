<?php
class User
{
		private $user_id;
		private $user_name;	
		private $user_entrydate;
		private $user_leftdate;	
		private $user_defaultteam;
		
		
			public function getUser_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	public function getUser_name(){
		return $this->user_name;
	}

	public function setUser_name($user_name){
		$this->user_name = $user_name;
	}

	public function getUser_entrydate(){
		return $this->user_entrydate;
	}

	public function setUser_entrydate($user_entrydate){
		$this->user_entrydate = $user_entrydate;
	}

	public function getUser_leftdate(){
		return $this->user_leftdate;
	}

	public function setUser_leftdate($user_leftdate){
		$this->user_leftdate = $user_leftdate;
	}

	public function getUser_defaultteam(){
		return $this->user_defaultteam;
	}

	public function setUser_defaultteam($user_defaultteam){
		$this->user_defaultteam = $user_defaultteam;
	}
}
?>