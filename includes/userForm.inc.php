<?PHP
	require_once("worker/UserWorker.class.php");
	
	
	
?>

<div class='left'>
	<?php
		
	?>
</div>
	<div class='main'>
		
	<?php
	// User hinzufügen bzw. aktualisieren
	if(isset($_GET['action']) && $_GET['action']=="addUser")
	{
		UserWorker::insertUser($_POST);	
	}
	?>
		
		
<form action="?site=userform&amp;action=addUser" method="post">
	<table>
		<tr>
			<td>Username</td>
			<td><input type="text" name="username" required/></td>
		</tr>
		<tr>
			<td>Beigetreten am:</td>
			<td><input type="date" name="entryDate" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}"/></td>
		</tr>
		<tr>
			<td>Ausgetreten am:</td>
			<td><input type="date" name="leftDate" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}"/></td>
		</tr>
		<tr>
			<td>Standardteam</td>
			<td><input type="text" name="defaultTeam" pattern="[0-3]{1}" required/></td>
		</tr>
	</table>
	<input type="submit">
</form>

</div>