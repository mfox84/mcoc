<?PHP
	require_once 'classes/DBConnector.class.php';
	
class UserWorker
{
	
	function showuser()
	{
		$pdo = new DBConnector();
		$userarr = $pdo->runSelectPDO("select user_id, user_name, userteam_team from users, userteam where user_id=userteam_user_id");
		
		echo "<table class='user'>";
		echo "<tr>";
		echo "<th>Name</th>";
		echo "<th>Team</th>";
		echo "</tr>";
		
		
		foreach($userarr as $user)
		{
			echo "<tr>";
			echo "<td>".$user['user_name']."</td>";
			echo "<td>".$user['userteam_team']."</td>";		
			echo "</tr>";
		}	
		echo "</table>";	
	}
	
	
	static function getUsersForAQ($aqid)
	{
		$pdo = new DBConnector();
		
		// Select holt alle Benutzer
		$select = "SELECT u.user_id,u.user_name,u.user_entrydate,u.user_leftdate FROM `aq` a, users u WHERE user_entrydate <= aq_end and aq_id = $aqid order by u.user_name asc ";
		
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
	
	/**
	 * Holt das Team eines Benutzers zu einem bestimmten Zeitpunkt
	 */
	static function getTeamForDate($start,$end)
	{
		$pdo = new DBConnector();
		$select = "select "
	}
	
	
	
}	
?>