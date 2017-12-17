<?PHP

final class DB 
{

	public $conn = null;
	public $dbName ="nmos_shootersbar";

	public function __construct($user, $pass)
	{
		if(!($this->conn = new mysqli("localhost", $user, $pass, $this->dbName)))
		{
			die("Database Connection unavailable.");
		}
	}
	
	
	public function query($string)
	{
		$result = $this->conn->query($string);
		
		if($result)
		{
			return $result;
		}
		else
		{
			throw new Exception("Database Error: " . $this->error());
			error_log("Database Error: " . $this->error() . " SQL: " . $string);
		}
		
		
	}
	
	public function error()
	{
		return $this->conn->error;
	}
	
	public function res($string)
	{
		return $this->conn->real_escape_string($string);
	}

}


?>