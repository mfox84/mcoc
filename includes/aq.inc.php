<?PHP
	require_once 'worker/AQWorker.class.php';
?>

<div class='left'>
	<?php
		$worker = new AQWorker();
		$aqarr = $worker->showAQList();
		
		if($aqarr != null)
		{
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
		}
	?>
	<br><a href="?site=aqform">AQ hinzufügen</a>
</div>
<div class='main'>
	<h2>Übersicht der letzten 10 Quests</h2>
	<?php
		// Quests holen
		$questList = AQWorker::getLastQuests(10);
		
		
		
		if(count($questList)>0)
		{
			foreach($questList as $q)
			{
				$quest = new AQ();
				$quest = $q;
				
				$startDate = ($quest->getAq_start() != 0 ?  date("d.m.Y",$quest->getAq_start()) : "");
				$endDate = ($quest->getAq_end() != 0 ?  date("d.m.Y",$quest->getAq_end()) : "");
				
				$mission = $quest->getAq_missions();
				$percent = $quest->getAq_percent();
				$prestige = $quest->getAq_prestige();
				$points = $quest->getAq_sumsPerDay();
				
				echo "
				<table>
					<tr>
						<th>Ergebnis</th>
						<th>Mission</th>
						<th>Grad</th>
						<th>Prestige</th>
						<th>Punkte</th>
					</tr>
					<tr>
						<td rowspan='2'>".$startDate." - ".$endDate."</td>
						<td>$mission[1]</td>
						<td>$percent[1] %</td>
						<td>$prestige[1]</td>
						<td>".Tools::formatNumber($points[1])."</td>
					</tr>
					<tr>
						<td>$mission[2]</td>
						<td>$percent[2] %</td>
						<td>$prestige[2]</td>
						<td>".Tools::formatNumber($points[2])."</td>
					</tr>
					<tr>
						<td>".Tools::formatNumber($quest->getAq_totalSum())."</td>
						<td>$mission[3]</td>
						<td>$percent[3] %</td>
						<td>$prestige[3]</td>
						<td>".Tools::formatNumber($points[3])."</td>
					</tr>
					<tr>
						<td rowspan='2'>Rang ".$quest->getAq_rank()."</td>
						<td>$mission[4]</td>
						<td>$percent[4] %</td>
						<td>$prestige[4]</td>
						<td>".Tools::formatNumber($points[4])."</td>
					</tr>
					<tr>
						<td>$mission[5]</td>
						<td>$percent[5] %</td>
						<td>$prestige[5]</td>
						<td>".Tools::formatNumber($points[5])."</td>
					</tr>
				</table>
				<hr>
				";
				
			}
		}
		else 
		{
			echo "Leider keine Quests vorhanden!";	
		}
	?>
	
</div>