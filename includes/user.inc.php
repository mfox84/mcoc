<?PHP
	require_once 'worker/UserWorker.class.php';
?>

<div class='left'>
	User
</div>
	<div class='main'>
		<?php
			$worker = new UserWorker();
			$worker->showuser();
		?>
	<a href='?site=userform'>User hinzufügen</a>	
	</div>