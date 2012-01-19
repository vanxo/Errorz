<?php
class DB 
{
	protected $db_name = 'db';
	protected $db_user = 'user';
	protected $db_pass = 'pass';
	protected $db_host = 'localhost';
	
	
	// Connect to the database, needs to be called on each page that needs the database
	public function connect()
	{
		$connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		mysql_select_db($this->db_name);
		
		return true;
	}
	
	// I have not really understood what this does... But I'm sure it's good?
	public function processRowSet($rowSet, $singleRow = false)
	{
		$resultArray = array();
		while ($row = mysql_fetch_assoc($rowSet))
		{
			array_push($resultArray, $row);
		}
		
		if ($singleRow == true)
		{
			return $resultArray[0];
		}
		
		return $resultArray;
	}
	
	// Selects a row in the database
	public function select($table, $where)
	{
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);
			
		return $this->processRowSet($result);
	}
	
	// Update a row in the database
	public function update($data, $table, $where)
	{
		foreach ($data as $column => $value)
		{
			$sql = "UPDATE $table SET $column=$value WHERE $where";
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}
	
	// Inserting a new row in the database
	public function insert($data, $table)
	{
		$columns = "";
		$values = "";
		
		foreach ($data as $column => $value)
		{
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}
		$sql = "INSERT INTO $table ($columns) VALUES ($values)";
		mysql_query($sql) or die(mysql_error());
		return mysql_insert_id();
	}
	
	// Delete a row in the database
	public function delete($table, $where)
	{
	}
}
?>