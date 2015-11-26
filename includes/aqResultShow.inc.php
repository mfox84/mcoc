<?PHP
	require_once 'worker/AQWorker.class.php';
	require_once("classes/AQ.class.php");
	require_once("worker/UserWorker.class.php");
?>

<div class='left'>
	<?php
		$worker = new AQWorker();
		$worker->showAQList();
	?>
</div>
	<div class='main'>
		<?php

		
$aqid = $_GET['aqid'];
// Alle Benutzer holen, die zur AQ-Zeit in der Allianz waren

if(isset($_GET['action']) && $_GET['action'] == "insertResults")
{
	AQWorker::insertAQResults($_GET['aqid'],$_POST['res']);
}

$users = UserWorker::getUsersForAQ($_GET['aqid']);

if($users == null)
{
	echo "Keine Teilnehmer gefunden!";
}
else 
{
	
	// Details zur AQ holen
	$aq = AQWorker::getAQDetails($aqid);

	// Gesamtpunkte holen
	$pointsTotalAQ = AQWorker::getTotalPoints($aqid);
	
	// Schon vorhandene Punkte holen, um das Formular ggfs. zu füllen
	$results = AQWorker::getAQResults($aqid);
	if($results == null)
		$results = array(); // damit später auf ein leeres Array geprüft werden kann
		
	
	
	// AQ-Zeit auf Tage aufteilen
	
	// StartTag holen
	$temp = $aq->getAq_start();
	while($temp < $aq->getAq_end())
	{
		$tag[] = $temp;
		$temp = $temp + 24*60*60;
		
	}
	
	// Matrix aufspannen
	$rows = array();
	foreach($users as $user)
	{
		unset($row);
		$row['user'] = $user['user_name'];
		$row['userid'] = $user['user_id'];
		$row['userteam'] = $user['user_defaultteam'];
		
		$pointsTotal = 0;
		
		foreach($tag as $key => $t)
		{
			$key+=1;
			$tid = "tag".$key;
			$row[$tid] = (UserWorker::checkDate($user, $t) ? 1 : 0);	
			
			// Punkte schreiben, falls vorhanden
			// Team schreiben
			$pid = "points".$key;
			$teamid = "team".$key;
			
			if(array_key_exists($key, $results) && array_key_exists($user['user_id'], $results[$key]))
			{
				
				$temp = $results[$key][$user['user_id']];
				if(array_key_exists("points", $temp))
				{
					$row[$pid] = $results[$key][$user['user_id']]['points'];
					$pointsTotal+=$results[$key][$user['user_id']]['points'];
				}
				else
					$row[$pid] = 0;	
				
				if(array_key_exists("team", $temp))
					$row[$teamid] = $temp['team'];
				else
					$row[$teamid] = $row['userteam'];
			}
			else
			{
				$row[$pid] = 0;
				$row[$teamid] = $row['userteam'];
			}
		}
		// Anteil berechnen
		$share = round($pointsTotal / $pointsTotalAQ * 100,2);
		
		$row["pointsTotal"] = $pointsTotal;
		$row["share"] = sprintf("%01.2f",$share);
		$rows[$row['userid']] = $row;
	}
	
	//Tools::printArray($rows);
}

// Details zur AQ ausgeben
include("includes/aqStatistic.inc.php");

// Formular aufspannen
if(isset($rows))
{
	echo "<form action='?site=aqform&aqid=$aqid&action=insertResults' method='post'>";
	echo "<table class='aqresult'>";
echo "<tr>";
	echo "<th>Username</th>";
	echo "<th colspan='2'>Tag1</th>";
	echo "<th colspan='2'>Tag2</th>";
	echo "<th colspan='2'>Tag3</th>";
	echo "<th colspan='2'>Tag4</th>";
	echo "<th colspan='2'>Tag5</th>";
	echo "<th>Gesamt</th>";
	echo "<th>Anteil</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th></th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "</tr>";
	foreach($rows as $key => $row)
	{
		echo "<tr>";
		echo "<td>".$row['user']."</td>";
		
		
		for($i=1;$i<=5;$i++)
		{
			$keyDay = "tag".$i;
			$keyPoints = "points".$i;
			$keyTeam = "team".$i;
			
			echo "<td>";
			if($row[$keyDay]==1)
			{
				echo $row[$keyPoints];	
			}
			else
			{
				echo "---";
			}
			echo "</td>";	
				
			echo "<td>";
			if($row[$keyDay]==1)
			{
				echo $row[$keyTeam];	
			}
			else
			{
				echo "---";
			}
			echo "</td>";					 
		}
			echo "<td>".$row['pointsTotal']."</td>";
			echo "<td>".$row['share']."</td>";
		
		echo "</tr>";
	}
	echo "</table>";
	echo "</form>";
	
	echo "<form action='?site=aqform&aqid=$aqid' method='post'>";
	echo "<input type='submit' value='bearbeiten' class='submit'>";
	echo "</form>";
}

	

					
		?> 		
	</div>

