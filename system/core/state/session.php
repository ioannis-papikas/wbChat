<?php
/*
 * Title : Session Manager
 * Description : Handles All SERVER Session Storage
 *
 */
 
class session
{
	const expire = 18000;
	
	// Init session
	public static function init($options = array())
	{
		//_____ Start session
		self::_start();
		
		// Initialise the session timers
		self::_setTimers();
		
		// Validate this session
		self::_validate();
		
		// Set options
		self::_setOptions($options);
	}
	
	// Get session variable
	public static function get($name, $default = NULL, $namespace = 'default')
	{
		// Add prefix to namespace to avoid collisions
		$namespace = '__' . $namespace;

		if (isset($_SESSION[$namespace][$name]))
			return $_SESSION[$namespace][$name];
			
		return $default;
	}
	
	// Set session variable
	public static function set($name, $value = NULL, $namespace = 'default')
	{
		// Add prefix to namespace to avoid collisions
		$namespace = '__' . $namespace;

		$old = isset($_SESSION[$namespace][$name]) ? $_SESSION[$namespace][$name] : NULL;

		if (NULL === $value)
			unset($_SESSION[$namespace][$name]);
		else
			$_SESSION[$namespace][$name] = $value;

		return $old;
	}
	
	// Check if there is a session variable
	public static function has($name, $namespace = 'default')
	{
		// Add prefix to namespace to avoid collisions.
		$namespace = '__' . $namespace;

		return isset($_SESSION[$namespace][$name]);
	}
	
	// Delete a session variable
	public static function clear($name, $namespace = 'default')
	{
		// Add prefix to namespace to avoid collisions
		$namespace = '__' . $namespace;

		$value = NULL;
		if (isset($_SESSION[$namespace][$name]))
		{
			$value = $_SESSION[$namespace][$name];
			unset($_SESSION[$namespace][$name]);
		}

		return $value;
	}
	
	// Delete a set of session variables under the same namespace
	public static function clear_set($namespace)
	{
		// Add prefix to namespace to avoid collisions
		$namespace = '__' . $namespace;
			
		if (isset($_SESSION[$namespace]))
		{
			unset($_SESSION[$namespace]);
			return TRUE;
		}
		else
			return FALSE;
	}
	
	// Get session name
	public static function get_name()
	{
		return session_name();
	}
	
	// Get session id
	public static function get_id()
	{
		return session_id();
	}
	
	// Destroy session
	public static function destroy()
	{
		if (isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time() - 42000, "", "");
		}

		session_unset();
		session_destroy();

		return true;
	}
	
	protected static function _setTimers()
	{
		if (!self::has('session.timer.start'))
		{
			$start = time();

			self::set('session.timer.start', $start);
			self::set('session.timer.last', $start);
			self::set('session.timer.now', $start);
		}

		self::set('session.timer.last', self::get('session.timer.now'));
		self::set('session.timer.now', time());

		return true;
	}
	
	protected static function _setOptions(array $options)
	{
		// Set name
		if (isset($options['id']))
		{
			session_id(md5($options['id']));
		}

		// Sync the session maxlifetime
		//ini_set('session.gc_maxlifetime', self::expire);

		return true;
	}
	
	protected static function _start()
	{
		register_shutdown_function('session_write_close');

		session_cache_limiter('none');
		
		// Set name
		session_name();
		
		session_start();
		
		return true;
	}
	
	protected static function _validate()
	{
		// Regenerate session if gone too long
		if ((time() - self::get('session.timer.start') > self::expire))
		{
			session_regenerate_id(true);
		}
		
		// Destroy session if expired
		if ((time() - self::get('session.timer.last') > self::expire))
		{
			self::destroy();
		}
	}
}
?>