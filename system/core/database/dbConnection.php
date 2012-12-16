<?php
/*
 * Title : Database Connection
 * Description : Connects and executes queries with a DBMS
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore('database::connectors::mysql_dbConnector');

class dbConnection
{
	// Database connector
	protected $dbConnector;
	
	// Set connection options
	public function __construct()
	{
		// Require Database Credentials
		$config = importer::includeConfig("database::credentials::local.testing");
		
		// Get mysql_dbConnector
		$this->dbConnector = new mysql_dbConnector();
		
		// Set dbConnector Handler
		$this->dbConnector->setHandler($config['server'], $config['username'], $config['password'], $config['database']);
	}
	
	// Executes a query
	public function execute_query($dbQuery, $isTransaction = 1)
	{
		if ($isTransaction)
			return $this->dbConnector->execute_query($dbQuery->get_query());
		else
			return $this->dbConnector->execute_query_transaction($dbQuery->get_query());
			
		return NULL;
	}
	
	// Executes a general transaction
	public function execute_transaction($dbQueries, $attr = array())
	{
		if (!is_array($queries))
				$this->execute_query($dbQueries);
		
		$queries = array();
		foreach ($dbQueries as $dbq)
			$queries[] = $dbq->get_query();
		
		return $this->dbConnector->execute_transaction($queries);
	}
	
	// Clears Escaping strings
	public function clear_resource($resource)
	{
		return $this->dbConnector->clear_resource($resource);
	}
	
	// Fetch results from resource (assoc)
	public function fetch($resource)
	{
		return $this->dbConnector->fetch($resource);
	}
	
	public function seek($resource, $row)
	{
		return $this->dbConnector->seek($resource, $row);
	}

	// Returns the count of rows of the given resource
	public function get_num_rows($resource)
	{
		return $this->dbConnector->get_num_rows($resource);
	}
}
?>