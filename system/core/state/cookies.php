<?php
/*
 * Title : Cookie Manager
 * Description : Handles All Client Storage
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

class cookies
{
	// Create a new cookie
	public static function set($name, $value, $expiration = 0, $path = "/", $domain = "", $secure = FALSE, $httpOly = FALSE)
	{
		if ($expiration == 0)
			return self::_create_session($name, $value, 0, $path, $domain, $secure, $httpOly);
		else if (setcookie($name, $value, time() + $expiration, $path, $domain, ($secure ? 1 : 0), ($httpOly ? 1 : 0)))
			return true;
		else
			throw new Exception("Cannot create cookie '".$name."'.");
	}
	
	// Get the value of a cookie
	public static function get($name)
	{
		return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : NULL);
	}
	
	// Delete a cookie
	public static function delete($name)
	{
		if (self::set($name, NULL, - 3600))
			return true;
		else
			throw new Exception("Cannot delete cookie '".$name."'.");
	}
	
	// Delete all cookies
	public static function clear()
	{
		foreach ($_COOKIE as $name => $value)
			self::delete($name);
	}
	
	// Create a new cookie within the Session
	protected static function _create_session($name, $value, $expiration = 0, $path = "/", $domain = "", $secure = FALSE, $httpOly = FALSE)
	{
		if (setcookie($name, $value, 0, $path, $domain, ($secure ? 1 : 0), ($httpOly ? 1 : 0)))
			return true;
		else
			throw new Exception("Cannot create cookie '".$name."'.");
	}
}
?>