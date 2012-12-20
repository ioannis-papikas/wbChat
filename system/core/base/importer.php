<?php
/*
 * Title : System Importer
 * Description : Imports System Classes and Resources
 *
 */

class importer
{
	// Import a System's Class
	public static function importCore($path)
	{
		// Normalize path
		$ns_path = systemCore."/".str_replace("::", "/", $path).".php";

		if (file_exists($ns_path))
			return require_once($ns_path);
		else
			throw new Exception("Class file $path doesn't exist for import.");
	}
	
	// Import a System's Resource Javascript File
	public static function importJS($path)
	{
		// Normalize path
		$ns_path = systemRoot.systemResources."/scripts/".str_replace("::", "/", $path).".js";
		
		if (file_exists($ns_path))
			return require_once($ns_path);
		else
			throw new Exception("Script file $path doesn't exist for import.");
	}
	
	// Import a System's Resource Style File
	public static function importCSS($path)
	{
		// Normalize path
		$ns_path = systemRoot.systemResources."/styles/".str_replace("::", "/", $path).".css";
		
		if (file_exists($ns_path))
			return require_once($ns_path);
		else
			throw new Exception("Style file $path doesn't exist for import.");
	}
	
	// Import a System's Resource
	public static function includeResource($path)
	{
		// Normalize path
		$ns_path = systemRoot.systemResources."/includes/".str_replace("::", "/", $path).".php";

		if (file_exists($ns_path))
			return require_once($ns_path);
		else
			throw new Exception("Resources file $path doesn't exist for import.");
	}
	
	// Import a System's Resource
	public static function includeConfig($path)
	{
		// Normalize path
		$ns_path = systemRoot."/system/configuration/".str_replace("::", "/", $path).".inc";

		if (file_exists($ns_path))
			return require_once($ns_path);
		else
			throw new Exception("Resources file $path doesn't exist for import.");
	}
}
?>