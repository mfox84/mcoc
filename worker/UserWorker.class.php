<?PHP
	require_once 'classes/DBConnector.class.php';
	
class UserWorker
{
	
	function showuser()
	{
		$pdo = new DBConnector();
		$userarr = $pdo->runSelectPDO("select user_id, user_name, user_defaultteam from users order by user_name asc");
		
		echo "<table class='user'>";
		echo "<tr>";
		echo "<th>Name</th>";
		echo "<th>Team</th>";
		echo "</tr>";
		
		
		foreach($userarr as $user)
		{
			echo "<tr>";
			echo "<td>".$user['user_name']."</td>";
			echo "<td>".$user['user_defaultteam']."</td>";		
			echo "</tr>";
		}	
		echo "</table>";	
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
		
		if(isset($userData['leftDate']))
		{
			$temp = explode(".",$userData['entryDate']);
			$leftDate = mktime(23,59,59,$temp[1],$temp[0],$temp[2]);
		}
		else
			$leftDate = 0;
		
		if(isset($userData['userid']))
		{
			$insert = "replace into users (userid,user_name,user_entrydate, user_leftdate,user_defaultteam  ) values (?,?,?,?,?)";
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
	
	
}	
?>