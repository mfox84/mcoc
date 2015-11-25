<?PHP
	require_once("worker/AQWorker.class.php");
	require_once("classes/AQ.class.php");
	
	// User hinzufügen bzw. aktualisieren
	if(isset($_GET['action']) && $_GET['action']=="addAQ")
	{
		AQWorker::insertAQ($_POST);
		include("includes/aq.inc.php");	
	}
	else 
	{
?>

<div class='left'>
	<?php
		$worker = new AQWorker();
		$worker->showAQList();
	?>
		<br><a href="?site=aqform">AQ hinzufügen</a>
</div>
	<div class='main'>
		
	
<?php
	
	$aq = new AQ();
	
	// Userdaten holen, falls eine UserId übergeben wurde
	if(isset($_GET['aqid']) && $_GET['aqid']!="")
	{
		$aq = AQWorker::getAQDetails($_GET['aqid']);
	}
	
	?>
		
		
<form action="?site=aqform&amp;action=addAQ" method="post">
	<?php
		if(isset($_GET['aqid']) && $_GET['aqid']!="")
		{
			echo "<input type='hidden' name='aqid' value='".$_GET['aqid']."'>";
		}
		
		$startDate = ($aq->getAq_start() != 0 ?  date("d.m.Y",$aq->getAq_start()) : "");
		$endDate = ($aq->getAq_end() != 0 ?  date("d.m.Y",$aq->getAq_end()) : "");
	?>
	<table>
		<tr>
			<td>Start am:</td>
			<td><input type="date" name="startDate" value="<?php echo $startDate;?>" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}" required/></td>
		</tr>
		<tr>
			<td>Ende am:</td>
			<td><input type="date" name="endDate" value="<?php echo $endDate;?>" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}" required/></td>
		</tr>
		<tr>
			<td>Rang: </td>
			<td><input type="text" name="rank" value="<?php echo $aq->getAq_rank();?>" /></td>
		</tr>
		<tr>
			<td>
				Ergebnisse
			</td>
			<td>
				<table>
					<tr>
						<td>Mission</td><td>Grad in Prozent</td><td>Prestige</td>
					</tr>
					<?php
					$missions = $aq->getAq_missions();
					$percent = $aq->getAq_percent();
					$prestige = $aq->getAq_prestige();
					for($i = 1; $i<=5;$i++)
					{
						
						
						echo "<tr>
								<td>
									<input type='text' name='mission[$i]' size='40' value='".($missions != null ? $missions[$i] : "")."'>
								</td>
								<td>
									<input type='text' name='percent[$i]' size='40' value='".($percent != null ? $percent[$i] : "")."'>
								</td>
								<td>
									<input type='text' name='prestige[$i]' size='40' value='".($prestige != null ? $prestige[$i] : "")."'>
								</td>
							</tr>"; 
					}
					?>
				</table>
			</td>
		</tr>
	</table>
	<input type="submit" class="submit">
</form>

</div>
<?php
}
?>