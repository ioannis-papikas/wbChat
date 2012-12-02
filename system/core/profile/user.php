<?php
/*
 * Title : User Controller
 * Description : Manages user profile
 *
 */

class user
{
	// Login user to system
	public static function login($username, $password, $rememberDuration = 0)
	{
		$user = self::authenticate($username, $password);
		
		if (!is_null($user))
		{
			session::set("id", $user['user_id'], "user");
			
			$profile = self::profile();
			self::set_cookies($profile, $rememberDuration);
			self::set_session($profile);
			return TRUE;
		}
		
		return FALSE;
	}
	
	// Authenticate user and return user data
	public static function authenticate($username, $password)
	{
		$dbm = new dbManager();
		
		$username = $dbm->clear_resource($username);
		$password = $dbm->clear_resource($password);
		$password = hash("SHA256", $password);

		$dbq = dbLib::get_query("348282469", "profile.user");
		
		$attr = array();
		$attr['username'] = $username;
		$attr['password'] = $password;
		$result = $dbc->execute_query($dbq, $attr);

		if ($dbc->get_num_rows($result) == 1)
		{
			$userRow = $dbc->fetch($result);
			return $userRow;
		}
		return NULL;
	}
	
	// Initalize user's data
	public static function profile()
	{
		// Check if user is logged in
		$user_id = session::get("id", NULL, "user");//cookies::get("user");
		$salted_password = cookies::get("cp");
		
		// If a cookie is missing, clear all relative cookies
		if (!isset($user_id))
		{
			self::logout();
			return NULL;
		}

		// Initialize connection
		$dbc = new dbManager();
		
		// Get data
		$dbq = dbLib::get_query("1589356652", "profile.user");
		$attr = array();
		$attr['uid'] = $user_id;
		$result = $dbc->execute_query($dbq, $attr);
		$user = $dbc->fetch($result);

		// Create profile
		$profile = array();
		$profile['id'] = $user['user_id'];
		$profile['username'] = $user['username'];
		$profile['firstname'] = $user['firstname'];
		$profile['lastname'] = $user['lastname'];
		$profile['fullname'] = $user['firstname']." ".$user['lastname'];
		
		return $profile;
	}
	
	// Logout user
	public static function logout()
	{
		self::_clear_cookies();
		self::_clear_session();
	}
	
	//_____ Set boscuits for the loggined user _____//
	protected static function set_cookies($profile, $rememberDuration = 0)
	{
		cookies::set("user", $profile['id'], $rememberDuration);
		cookies::set("cp", $profile['cp'], $rememberDuration);
		cookies::set("acc", $profile['accountID'], $rememberDuration);
		cookies::set("pacc", $profile['accountID'], $rememberDuration);
	}
	
	protected static function set_session($profile)
	{
		session::set("id", $profile['id'], "user");
		session::set("acc", $profile['accountID'], "user");
		session::set("pacc", $profile['accountID'], "user");
		session::set("username", $profile['username'], "user");
		session::set("fullname", $profile['fullname'], "user");
	}
	
	//_____ Clear all user relevant biscuits _____//
	protected static function _clear_cookies()
	{
		cookies::delete("user");
		cookies::delete("cp");
		cookies::delete("acc");
		cookies::delete("pacc");
	}
	
	protected static function _clear_session()
	{
		session::clear_set('user');
	}
}

?>