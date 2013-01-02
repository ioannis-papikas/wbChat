<?php
/*
 * Title : User Controller
 * Description : Manages user profile
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

class validator
{
	// Regular Expressions
	const emailRegExp = "/^[a-z0-9._%+-]+@(?:[a-z0-9-]+\.)+(?:[a-z]{2}|com|xxx|cat|org|tel|net|int|pro|edu|gov|mil|biz|coop|info|mobi|name|aero|arpa|asia|jobs|travel|museum)$/i";
	const usernameRegExp = "/^[a-z][a-zA-Z]{5,19}$/i";
	const passwordRegExp = "/^.*(?=.*\d)((?=.*[a-z])|(?=.*[A-Z]))((?=.*\W)|(?=.*\_)).*$/";
	
	// Check if the given value is empty
	public static function _empty($value)
	{
		return (is_null($value) || empty($value) || $value == "");
	}
	
	// Check if the given value is not set and empty
	public static function _notset($value)
	{
		return self::_empty($value) && !isset($value);
	}
	
	// Check if the given value is a valid password
	public static function _password($value)
	{
		return preg_match(self::passwordRegExp, $value);
	}
	
	// Check if the given value is a valid email
	public static function _email($value)
	{
		return preg_match(self::emailRegExp, $value);
	}
	
	// Check if the given value is a valid username
	public static function _username($value)
	{
		return preg_match(self::usernameRegExp, $value);
	}
}
?>