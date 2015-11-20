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
	$aq = AQWorker::getAQDetails($_GET['aqid']);
	
	// Gesamtpunkte holen
	$pointsTotalAQ = AQWorker::getPointsTotal($aqid);
	
	// Schon vorhandene Punkte holen, um das Formular ggfs. zu füllen
	$points = AQWorker::getAQResults($aqid);
	if($points == null)
		$points = array(); // damit später auf ein leeres Array geprüft werden kann
	
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
		foreach($tag as $key => $t)
		{
			$key+=1;
			$tid = "tag".$key;
			$row[$tid] = (UserWorker::checkDate($user, $t) ? 1 : 0);	
			
			// Punkte schreiben, falls vorhanden
			$pid = "points".$key;
			if(array_key_exists($key, $points) && array_key_exists($user['user_id'], $points[$key]))
			{
				$row[$pid] = $points[$key][$user['user_id']];	
			}
			else
			{
				$row[$pid] = "";
			}
		}
		
		$rows[$row['userid']] = $row;
	}
	
	//Tools::printArray($rows);
}

// Details zur AQ ausgeben
include("includes/aqDetails.inc.php");

// Formular aufspannen
if(isset($rows))
{
	echo "<form action='?site=aqform&aqid=$aqid&action=insertResults' method='post'>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Username</th>";
	echo "<th>Tag1</th>";
	echo "<th>Tag2</th>";
	echo "<th>Tag3</th>";
	echo "<th>Tag4</th>";
	echo "<th>Tag5</th>";
	echo "</tr>";
	foreach($rows as $key => $row)
	{
		echo "<tr>";
		echo "<td>".$row['user']."</td>";
		
		
		for($i=1;$i<=5;$i++)
		{
			$keyDay = "tag".$i;
			$keyPoints = "points".$i;
			
			echo "<td>";
			if($row[$keyDay]==1)
			{
				echo "<input type='number' name='res[$i][".$row['userid']."]' value='".$row[$keyPoints]."'>";	
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";						 
			
		}
		
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type='submit'>";
	echo "</form>";
}

	

					
		?>
		
	</div>

