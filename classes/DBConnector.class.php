<?php


/**
 * Klasse für die Datenbankverbingdun
 * 
 * @author Daniela Merkl
 */
class DBConnector
{

	private $connect_pdo;
	private $tabs;
	private $debug;
	
	/**
	 * Kontruktor DBConnector
	 * 
	 * Variablen kommen aus der config.ini
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param int debug Gibt an, ob Debugausgaben geschrieben werden sollen. (1 = true, 0 = false)
	 *  
	 */
	public function __construct($debug=null)
	{
		include 'includes/config.inc.php';
		
		$this->connect_pdo = new PDO("mysql:host=".$db_host.";dbname=".$db_name.";charset=utf8", $db_user, $db_password);
		$this->connect_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		

			$this->debug = $debug;
	}
	
	/**
	 * Select ausführen
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param query Selectabfrage
	 * @param param Array mit Parametern
	 * 
	 * @return array Ergebnis in Zeilen 
	 */
	function runSelectPDO($query,$param=null)
	{
	
		if($this->debug==1)
		self::writeQuery($query,$param);
		try
		{
			//connect as appropriate as above
			$this->connect_pdo->beginTransaction();
		
			$stmt = $this->connect_pdo->prepare($query);
		
			if($param!=null)
				$stmt->execute($param);
			else
				$stmt->execute();
		
		
			$this->connect_pdo->commit();
			
			if($stmt->rowCount() > 0)
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			else
				return null;
		}
		catch(PDOException $ex)
		{
			self::writeQuery($query,null,$ex);
			$this->connect_pdo->commit();
			return null;
		}
	
	}
	
	/**
	 * Update ausführen
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param query Selectabfrage
	 * @param param Array mit Parametern
	 * 
	 * @return void
	 */
	function runUpdatePDO($query,$param=null)
	{
		if($this->debug==1)
			self::writeQuery($query,$param);
	
		try
		{
			//connect as appropriate as above
			$this->connect_pdo->beginTransaction();
			
			$stmt = $this->connect_pdo->prepare($query);
			if($param!=null)
				$stmt->execute($param);
			else
				$stmt->execute();
		
			$this->connect_pdo->commit();
			return $stmt->rowCount();
		}
		catch(PDOException $ex)
		{
			self::writeQuery($query,$param,$ex);
			return null;
		}
	}
	
	/**
	 * SQLAbfrage ausführen
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param query Selectabfrage
	 * @param param Array mit Parametern
	 * 
	 * @return void
	 */
	function runQueryPDO($query,$param=null)
	{
		if($this->debug==1)
			self::writeQuery($query,$param);
	
		try
		{
			$stmt = $this->connect_pdo->prepare($query);
			if($param!=null)
				$stmt->execute($param);
			else
				$stmt->execute();
	
			return $stmt->rowCount();
		}
		catch(PDOException $ex)
		{
			self::writeQuery($query,$param,$ex);
			return null;
		}
	}
	
	/**
	 * Insert ausführen
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param query Selectabfrage
	 * @param param Array mit Parametern
	 * 
	 * @return int ID der letzten Zeile
	 */
	function runInsertPDO($query,$param=null)
	{
		if($this->debug==1)
			self::writeQuery($query,$param);
	
		try
		{
			$this->connect_pdo->beginTransaction();
			$stmt = $this->connect_pdo->prepare($query);
			if($param!=null)
				$stmt->execute($param);
			else
				$stmt->execute();
	
			$id = $this->connect_pdo->lastInsertId();
			$this->connect_pdo->commit();
			return $id;
		}
		catch(PDOException $ex)
		{
			$this->connect_pdo->rollback();
			self::writeQuery($query,$param,$ex);
			return null;
		}
	}
	
	/**
	 * Logdatei schreiben
	 * 
	 * @author Daniela Merkl
	 * 
	 * @param query Selectabfrage
	 * @param param Array mit Parametern
	 * @param ex Exception
	 * 
	 * @return void
	 */
	function writeQuery($query,$param,$ex=null)
	{
		if($ex!=null)
		{
		    echo "<br><b>Es ist ein DB-Fehler aufgetreten:</b><br><br>"; 
			$string = $ex->getTraceAsString();
			$dbmessage = $ex->getMessage();
		}
		else 
		{
			$string = "";
			$dbmessage = "";
		}
		
		$datum = date("Y-m-d");
		echo "<br>----------------------<br>";
		echo "<b>QUERY:</b><br>$query<br><br>"; 
		echo "<b>PARAM:</b><br>"; 
		print_r($param); 
		echo "<br>"; 
        if($ex!=null)
        {
		  echo "<b>STACKTRACE:</b><br>"; 
		  echo "<pre>$string</pre>"; 
		  echo "<b>DBMESSAGE:</b><br>"; 
		  echo "<pre>$dbmessage</pre>";
        } 
	} 
}
?> 