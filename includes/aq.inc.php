<?PHP
	require_once 'worker/AQWorker.class.php';
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
		
	?>
	
</div>