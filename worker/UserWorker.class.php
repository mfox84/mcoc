<?PHP
	require_once 'classes/DBConnector.class.php';
	
class UserWorker
{
	/**
	 * Holt alle Benutzer
	 * 
	 * @param boolean aktiv (true = nur aktive Benutzer, false = nur inaktive, null = alle, Standard ist true)
	 */
	function showuser($aktiv=1)
	{
		$pdo = new DBConnector();
	
		if($aktiv == null)
			$where = "";
		else if($aktiv)
			$where = "where user_leftdate is null";
		else if(!$aktiv)
			$where = "where user_leftdate is not null";
	
		$select = "select user_id, user_name, user_defaultteam,user_entrydate,user_leftdate from users $where order by user_name asc";
		$userarr = $pdo->runSelectPDO($select);
		
		return $userarr;
		
			
	}
	
	
	static function getUsersForAQ($aqid)
	{
		$pdo = new DBConnector();
		
		// Select holt alle Benutzer
		$select = "SELECT u.user_id,u.user_name,u.user_entrydate,u.user_leftdate,u.user_defaultteam FROM `aq` a, users u WHERE user_entrydate <= aq_end and aq_id = $aqid order by u.user_name asc ";
		
		$result = $pdo->runSelectPDO($select);
		
		if($result != null)
		{
			return $result;
		}
		else {
			return null;
		}
	}
	
	static function checkDate($user,$tag)
	{
		$userStart = $user['user_entrydate'];
		$userEnd = $user['user_leftdate'];
		
		if($tag >= $userStart && $tag <=$userEnd)
			return true;	
		if($tag >= $userStart && $userEnd == 0)
			return true;
		
		return false;
	}
	
	static function insertUser($userData)
	{
		$pdo = new DBConnector();
		
		// Datum umsetzen
		$temp = explode(".",$userData['entryDate']);
		$entryDate = mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
		
		if($userData['leftDate']!="")
		{
			$temp = explode(".",$userData['leftDate']);
			$leftDate = mktime(23,59,59,$temp[1],$temp[0],$temp[2]);
		}
		else
			$leftDate = null;
		
		if(isset($userData['userid']))
		{
			$insert = "replace into users (user_id,user_name,user_entrydate, user_leftdate,user_defaultteam  ) values (?,?,?,?,?)";
			$param[] = $userData['userid'];
		}
		else
			$insert = "insert into users (user_name,user_entrydate, user_leftdate,user_defaultteam  ) values (?,?,?,?)";
		
		$param[] = $userData['username'];
		$param[] = $entryDate;
		$param[] = $leftDate;
		$param[] = $userData['defaultTeam'];
		
		$pdo->runInsertPDO($insert,$param);
	}
	
	/**
	 * Holt die Daten eines bestimmten Benutzers
	 */
	static function getUser($userid)
	{
		$pdo = new DBConnector();
		$select = "select * from users where user_id = $userid";
		$result = $pdo->runSelectPDO($select);
		if($result != null)
		{
			$user = new User();
			$row = $result[0];
			
			$user->setUser_id($row['user_id']);
			$user->setUser_name($row['user_name']);
			$user->setUser_entrydate(date("d.m.Y",$row['user_entrydate']));
			$user->setUser_leftdate(($row['user_leftdate'] != null ? date("d.m.Y",$row['user_leftdate']) : ""));
			$user->setUser_defaultteam($row['user_defaultteam']);
			
			return $user;
		}
		else 
		{
			return null;	
		}
	}
	
}	
?>