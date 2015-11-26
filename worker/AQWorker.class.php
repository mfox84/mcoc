<?PHP
	require 'classes/DBConnector.class.php';
	require_once 'classes/AQ.class.php';
	
class AQWorker
{
	/**
	 * Liste aller Quests zurückgeben
	 */
	function showAQList()
	{
		$pdo = new DBConnector();
		$aqarr = $pdo->runSelectPDO("select aq_id, aq_start, aq_end from aq");
		
		return $aqarr;
	}
	
	/**
	 * Details einer Quest holen
	 */
	static function getAQDetails($id)
	{
		$pdo = new DBConnector();
		$aqdetailsSelect = "select * from aq where aq_id = $id";
		$result = $pdo->runSelectPDO($aqdetailsSelect);
		
		if($result != null)
		{
			$row = $result[0];
			$aq = new AQ();
			$aq->setAq_id($id);
			$aq->setAq_start($row['aq_start']);
			$aq->setAq_end($row['aq_end']);
			$aq->setAq_rank($row['aq_rank']);
			
			
			// Missionen, Prozent und Prestige holen
			$select = "select aqday_number,aqday_percent,aqday_mission,aqday_prestige from aqday where aqday_aq_id = $id";
			
			$res = $pdo->runSelectPDO($select);
			
			$mission = array();
			$prestige = array();
			$percent = array();
			
			if($res != null)
			{
			
				foreach($res as $row)
				{
					$mission[$row['aqday_number']] = $row['aqday_mission'];
					$prestige[$row['aqday_number']] = $row['aqday_prestige'];
					$percent[$row['aqday_number']] = $row['aqday_percent'];
				}
			}
			else 
			{
				$mission = null;
				$prestige = null;
				$percent = null;	
			}			
			
			$aq->setAq_missions($mission);
			$aq->setAq_percent($percent);
			$aq->setAq_prestige($prestige);	
			
			
			return $aq;
		}
		else 
		{
			return null;
		}
		
	}

	static function getLastQuests($limit=10)
	{
		$pdo = new DBConnector();
		
		$select = "select aq_id from aq order by aq_start desc limit $limit";
		$quests = $pdo->runSelectPDO($select);
		
		$questList = array();		
		
		// Nun die Ergebnisse der Quests holen
		foreach($quests as $row)
		{
			$aqid = $row['aq_id'];
			$AQ = new AQ();
			$AQ = self::getAQDetails($aqid);
			
			// Gesamtsummen holen und speichern
			$AQ->setAq_totalSum(self::getTotalPoints($aqid));
			
			$dailyPoints = array();
			
			for($i = 1;$i<=5;$i++)
			{
				$dailyPoints[$i] = self::getTotalPoints($aqid,$i);
			}
			
			$AQ->setAq_sumsPerDay($dailyPoints);
			
			
			$questList[] = $AQ;
		}
		
		return $questList;
		
		
	}
	
	/**
	 * Holt Summen für Quests
	 * 
	 * @param int aqid ID der Quest
	 * @param int day Tag der Quest, 0 = Summe aller Tage 
	 */
	static function getTotalPoints($aqid,$day=0)
	{
		$pdo = new DBConnector();
		
		if(!$day) // Summe aller Tage zusammen holen
		{
			$select = "select sum(uaqres_points) as summe from useraqres where uaqres_aq_id = $aqid";
		}
		else // Summe eines bestimmten Tages holen 
		{
			$select = "select sum(uaqres_points) as summe from useraqres where uaqres_aq_id = $aqid and uaqres_aqday_id = $day";
		}
		
		$result = $pdo->runSelectPDO($select);
		
		if($result != null)
		{
			if($result[0]['summe'] != "")
				return $result[0]['summe'];
			else
				return 0;
		}
		else 
		{
			return 0;
		}
	}
	

	static function insertAQResults($aqid,$results)
	{
		
		$pdo = new DBConnector();
		
		foreach($results as $tag => $result)
		{
			foreach($result as $user => $data)
			{
				
				if($data['points'] == 0)
					continue;
		
				unset($param);	
				
				$insert = "replace into useraqres (	uaqres_aq_id , uaqres_aqday_id,	uaqres_user_id, uaqres_points,uaqres_team ) values (?,?,?,?,?)";
				$param[] = $aqid;
				$param[] = $tag;
				$param[] = $user;
				$param[] = $data['points'];
				$param[] = $data['team'];
				
				$pdo->runInsertPDO($insert,$param);
			}
		}
	}
	
	/**
	 * Holt die Ergebnisse einer AllianzQuest 
	 * Die Ergebnisse werden in einem Array gespeichert
	 * $arr[TAG][USERID] = PUNKTE
	 */
	static function getAQResults($aqid)
	{
		$pdo = new DBConnector();
		$select = "select uaqres_aqday_id,uaqres_user_id,uaqres_points,uaqres_team from useraqres where uaqres_aq_id = $aqid";
		
		$result = $pdo->runSelectPDO($select);
		
		$results = array();
		
		if($result != null)
		{
			foreach($result as $row)
			{
				$userid = $row['uaqres_user_id'];
				$day = $row['uaqres_aqday_id'];
				$points = $row['uaqres_points'];
				$team = $row['uaqres_team'];
				$results[$day][$userid]['points'] = $points;
				$results[$day][$userid]['team'] = $team;
			}
			
				return $results;
		}
		else 
		{
			return null;
		}
	}
	
	static function getTeamCount($aqid)
	{
		$pdo = new DBConnector();
		$select = "SELECT uaqres_aqday_id,uaqres_team,count(*) as anzahl FROM useraqres where uaqres_aq_id = 1 group by uaqres_aqday_id,uaqres_team ORDER BY `uaqres_aqday_id` ASC ";
		$result = $pdo->runSelectPDO($select);
		
		if($result != null)
		{
			foreach($result as $row)
			{
				
				$day = $row['uaqres_aqday_id'];
				$team = $row['uaqres_team'];
				$teamcount[$day][$team] = $row['anzahl'];
			}
			return $teamcount;
		}
		else 
		{
			return $result;	
		}
		
	}
	
	static function insertAQ($AQData)
	{
		$pdo = new DBConnector();
		
		// Datum umsetzen
		$temp = explode(".",$AQData['startDate']);
		$startDate = mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
		
		$temp = explode(".",$AQData['endDate']);
		$endDate = mktime(23,59,59,$temp[1],$temp[0],$temp[2]);
		
		// Grunddaten eintragen
		if(isset($AQData['aqid']))
		{
			$insert = "replace into aq ( aq_id, aq_start,aq_end,aq_rank  ) values (?,?,?,?)";
			$param[] = $AQData['aqid'];
		}
		else
			$insert = "insert into aq (aq_start,aq_end,aq_rank ) values (?,?,?)";
		
		$param[] = $startDate;
		$param[] = $endDate;
		$param[] = $AQData['rank'];
		
		$aqid = $pdo->runInsertPDO($insert,$param);
		//if(isset($AQData['aqid']))
			//$aqid = $AQData['aqid']);
		
		// Details eintragen
		for($i = 1;$i<=5;$i++)
		{
			unset($param);
			
			$insert = "replace into aqday ( aqday_aq_id,aqday_number,aqday_percent,aqday_mission,aqday_prestige ) values (?,?,?,?,?)";
			
			$param[] = $aqid;
			$param[] = $i;
			$param[] = $AQData['percent'][$i];
			$param[] = $AQData['mission'][$i];
			$param[] = $AQData['prestige'][$i];
			
			$pdo->runInsertPDO($insert,$param);
			 
		}
	}
	
}	
?>