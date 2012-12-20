<?php
/*
 * Title : MySQL Database Connector
 * Description : Connects to a MySQL DBMS and executes queries
 *
 */

class mysql_dbConnector
{
	// Credentials for database
	protected $connection;
	protected $host;
	protected $username;
	protected $password;
	protected $database;
	
	// Initialize the object with the proper properties
	final public function setHandler($host, $username, $password, $database)
	{
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}
	
	// Execute a single query
	final public function execute_query($query)
	{
		try
		{
			// Connect to database
			$this->connect();
	
			// Set autocommit for query
			mysqli_autocommit($this->connection, TRUE);
	
			// Execute Query
			$result = mysqli_query($this->connection, $query);
			
			// Disconnect from database
			$this->disconnect();
		}
		catch (Exception $ex)
		{
			return NULL;
		}

		// Return final result
		return $result;
	}
	
	// Execute a query transaction (queries separated by ;)
	final public function execute_query_transaction($query)
	{
		// Split queries
		$queries = array();
		$queries = explode(";", $query);
		
		// Remove last empty query
		if ($queries[count($queries)-1] == "")
			unset($queries[count($queries)-1]);
		
		// Execute Transaction
		return $this->execute_transaction($queries);
	}
	
	// Execute a transaction (multiple queries)
	final public function execute_transaction($queries)
	{
		try
		{
			// Connect to database
			$this->connect();
			
			// Disable autocommit for transaction
			mysqli_autocommit($this->connection, FALSE);
			
			// Start Transaction
			foreach ($queries as $q)
			{
				$result = mysqli_query($this->connection, $q);
				if (!$result)
				{
					// Get Exception
					$exception = mysqli_error($this->connection);
					
					// Rollback
					mysqli_rollback($this->connection);
					
					// Disconnect
					$this->disconnect();
					
					// Throw Exception
					throw new Exception($exception);
				}
			}
			// Commit Transaction
			mysqli_commit($this->connection);
			
			// Disconnect from database
			$this->disconnect();
		}
		catch (Exception $ex)
		{
			return NULL;
		}
		
		// Return final result
		return $result;
	}
	
	// Fetch an assoc row
	final public function fetch($resource)
	{
		return @mysqli_fetch_assoc($resource);
	}
	
	// Fetch an assoc array
	final public function fetch_all($resource)
	{
		return @mysqli_fetch_array($resource);
	}
	
	// Seek a position in the resource
	final public function seek($resource, $row)
	{
		return @mysqli_data_seek($resource, $row);
	}
	
	// Clears a query from unescaped strings
	final public function clear_resource($resource)
	{
		try
		{
			// Connect to database
			$this->connect();
			
			// Clear string
			$escaped = mysqli_real_escape_string($this->connection, $resource);
			
			// Disconnect from database
			$this->disconnect();
		}
		catch (Exception $ex)
		{
			return NULL;
		}
		
		// Return escaped value
		return $escaped;
	}
        
        public function getConnection() {
            return $this->connection;
        }
        
	// Returns the number of rows of the resource
	final public function get_num_rows($resource)
	{
		return @mysqli_num_rows($resource);
	}
	
	// Connect to the server
	final public function connect()
	{
		// Connect to the database
		$this->connection = @mysqli_connect($this->host, $this->username, $this->password);
		
		// If no connection, throw Exception
		if (!$this->connection)
			throw new Exception("Could not connect to MySQL Database Server '".$this->host."'.");
			
		// Set unicode names
		mysqli_query($this->connection, "SET NAMES utf8");
		
		// Select database
		$this->select();
	}
	
	// Select the database
	final public function select()
	{
		// Select Database
		$success = @mysqli_select_db($this->connection, $this->database);
		
		if (!$success)
			throw new Exception("Could not select Database '".$this->database."'.");
	}
	
	// Disconnect from the server
	final public function disconnect()
	{
		// Disconnect from the server
		@mysqli_close($this->connection);
		
		// Unset variable
		unset($this->connection);
	}
}
?>