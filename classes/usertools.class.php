<?php
	require_once 'db.class.php';
	require_once 'user.class.php';
	
	class UserTools
	{
		public function login($username, $password)
		{
			$result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
			if (mysql_num_rows($result) == 1)
			{
				$row = mysql_fetch_assoc($result);
				setcookie("notifo_user", $row['id'], time()+(60*60*24*30));
				return true;
			} else {
				return false;
			}
		}
		
		public function logout()
		{
			setcookie("notifo_user", "", time()-3600);
		}
		
		public function checkusernameExists($username)
		{
			$result = mysql_query("select id from users where username='$username'");
			if(mysql_num_rows($result) == 0)
			{
				return false;
			}else{
				return true;
			}
		}
		
		public function get($id)
		{
			$db = new DB();
			$result = $db->select('users', "id = $id");
			
			return $result;
		}
		
		public function isLoggedIn()
		{
			if (isset($_COOKIE["notifo_user"]))
			{
				return true;
			} else {
				return false;
			}
		}
	}
	
?>