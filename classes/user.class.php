<?php
	require_once 'db.class.php';

	class User 
	{
		public $id;
		public $username;
		public $hashedpassword;
		public $salt;
		public $email;
		public $joindate;
		public $apikey;
		
		function __construct($data)
		{
			$this->id = (isset($data['id'])) ? $data['id'] : "";  
			$this->username = (isset($data['username'])) ? $data['username'] : "";  
			$this->hashedpassword = (isset($data['password'])) ? $data['password'] : "";  
			$this->email = (isset($data['email'])) ? $data['email'] : "";  
			$this->joindate = (isset($data['joindate'])) ? $data['joindate'] : "";  
			$this->apikey = (isset($data['apikey'])) ? $data['apikey'] : "";
			$this->salt = (isset($data['salt'])) ? $data['salt'] : "";
		}
		
		public function save($isNewUser = false)
		{
			$db = new DB();
			
			if (!$isNewUser)
			{
				$data = array(
					"username" => "'$this->username'",
					"password" => "'$this->hashedpassword'",
					"email" => "'$this->email'"
				);
				
				$db->update($data, 'users', 'id = '.$this->id);
			} else {
				date_default_timezone_set('Europe/Oslo');
				$data = array(
					"username" => "'$this->username'",
					"password" => "'$this->hashedpassword'",
					"salt" => "'$this->salt'",
					"email" => "'$this->email'",
					"apikey" => "'$this->apikey'",
					"joindate" => "'".date("Y-m-d H:i:s",time())."'"
				);
				
				$this->id = $db->insert($data, 'users');
				$this->joinDate = time();
			}
			
			return true;
		}
	}
?>