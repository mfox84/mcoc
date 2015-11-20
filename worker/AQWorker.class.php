<?PHP
	require 'classes/DBConnector.class.php';
	require_once 'classes/AQ.class.php';
	
class AQWorker
{
	
	function showAQList()
	{
		$pdo = new DBConnector();
		$aqarr = $pdo->runSelectPDO("select aq_id, aq_start, aq_end from aq");
		
		echo "<table class='aqlist'>";
		
		
		foreach($aqarr as $aq)
		{
			echo "<tr>";
			echo "<td>".date("Y-m-d",$aq['aq_start'])." - ".date("Y-m-d",$aq['aq_end'])."</td>";
			echo "<td><a href=?site=aqform&aqid=".$aq['aq_id'].">Form</td>";
			echo "<td><a href=?site=aqresult&aqid=".$aq['aq_id'].">Results</td>";
			echo "</tr>";
		}	
		echo "</table>";	
	}
	
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
			$aq->setAq_points($row['aq_points']);
			$aq->setAq_result($row['aq_result']);
			
			return $aq;
		}
		else 
		{
			return null;
		}
		
	}

	static function insertAQResults($aqid,$results)
	{
		// ALTER TABLE `useraqres` DROP PRIMARY KEY, ADD PRIMARY KEY( `uaqres_aq_id`, `uaqres_aqday_id`, `uaqres_user_id`);
		
		$pdo = new DBConnector();
		
		foreach($results as $tag => $result)
		{
			foreach($result as $user => $points)
			{
				if($points == "")
					continue;
					
				unset($param);	
				
				$insert = "replace into useraqres (	uaqres_aq_id , uaqres_aqday_id,	uaqres_user_id, uaqres_points ) values (?,?,?,?)";
				$param[] = $aqid;
				$param[] = $tag;
				$param[] = $user;
				$param[] = $points;
				
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
		$select = "select uaqres_aqday_id,uaqres_user_id,uaqres_points from useraqres where uaqres_aq_id = $aqid";
		
		$result = $pdo->runSelectPDO($select);
		
		$results = array();
		
		if($result != null)
		{
			foreach($result as $row)
			{
				$userid = $row['uaqres_user_id'];
				$day = $row['uaqres_aqday_id'];
				$points = $row['uaqres_points'];
				$results[$day][$userid] = $points;
			}
			
				return $results;
		}
		else 
		{
			return null;
		}
	}
	
	/** 
	 * Holt die Gesamtpunkte einer AllianzQuest
	 */
	static function getPointsTotal($aqid)
	{
		$pdo = new DBConnector();
		$select = "SELECT sum(uaqres_points) as summe FROM `useraqres` where uaqres_aq_id = $aqid ";
		$result = $pdo->runSelectPDO($select);
		if($result != null)
		{
			return $result[0]['summe'];
		}
		else 
		{
			return 0;	
		}
	}
	
}	
?>