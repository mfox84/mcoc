<?PHP
	require_once 'worker/AQWorker.class.php';
	require_once("classes/AQ.class.php");
	require_once("worker/UserWorker.class.php");
?>

<td class='left'>
	<?php
		$worker = new AQWorker();
		$aqarr = $worker->showAQList();
		
		echo "<p class='lefthead'>Allianzmissionen<p>";
		
		if($aqarr != null)
		{
			/*
			echo "<table class='aqlist'>";
						
			foreach($aqarr as $aq)
			{
				echo "<tr>";
				echo "<td><a href='?site=aqform&aqid=".$aq['aq_id']."'>".date("Y-m-d",$aq['aq_start'])." - ".date("Y-m-d",$aq['aq_end'])."</a></td>";
				echo "<td><a href='?site=aqresultform&aqid=".$aq['aq_id']."'>Form</a></td>";
				echo "<td><a href='?site=aqresult&aqid=".$aq['aq_id']."'>Results</a></td>";
				echo "</tr>";
			}	
			echo "</table>";
			*/
			
			echo "<ul>";
			foreach($aqarr as $aq)
			{
				echo "<li>";
				echo "<a href='?site=aqresultform&aqid=".$aq['aq_id']."'>".date("Y-m-d",$aq['aq_start'])." - ".date("Y-m-d",$aq['aq_end'])."</a>";
				echo "</a>";
				echo "</li>";
			}	
			echo "</ul>";	
		}
	?>
	<p align="right">
	<form action='?site=aqform' method='post'>
	<input type='submit' value='AQ hinzufügen' class='submit'>
	</form>
	</p>
</td>
	<td class='main'>
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
		foreach($tag as $key => $t)
		{
			$key+=1;
			$tid = "tag".$key;
			$row[$tid] = (UserWorker::checkDate($user, $t) ? 1 : 0);	
			
			// Punkte schreiben, falls vorhanden
			// Team schreiben, falls vorhanden
			$pid = "points".$key;
			$teamid = "team".$key;
			
			if(array_key_exists($key, $results) && array_key_exists($user['user_id'], $results[$key]))
			{
				$temp = $results[$key][$user['user_id']];
				if(array_key_exists("points", $temp))
					$row[$pid] = $temp['points'];
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
		
		$rows[$row['userid']] = $row;
	}
	
	//Tools::printArray($rows);
}

// Details zur AQ ausgeben
include("includes/aqStatistic.inc.php");

// Formular aufspannen
if(isset($rows))
{
	echo "<form action='?site=aqresultform&aqid=$aqid&action=insertResults' method='post'>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Username</th>";
	echo "<th colspan='2'>Tag1</th>";
	echo "<th colspan='2'>Tag2</th>";
	echo "<th colspan='2'>Tag3</th>";
	echo "<th colspan='2'>Tag4</th>";
	echo "<th colspan='2'>Tag5</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th></th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
	echo "<th>Punkte</th><th>Team</th>";
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
			if(array_key_exists($keyDay, $row) && $row[$keyDay]==1)
			{
				echo "<input type='number' name='res[$i][".$row['userid']."][points]' value='".$row[$keyPoints]."' size='8'>";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";
			
			
			echo "<td>";
			if(array_key_exists($keyDay, $row) && $row[$keyDay]==1)
			{
				echo "<input type='text' name='res[$i][".$row['userid']."][team]' value='".$row[$keyTeam]."' pattern='[0-3]{1}' size='3'>";
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
	echo "<input type='submit' value='speichern' class='submit'>";
	echo "</form>";
}

	

					
		?>
		
	</td>

