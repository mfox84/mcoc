<?PHP
	require_once("worker/UserWorker.class.php");
	require_once("classes/User.class.php");
	
	// User hinzufügen bzw. aktualisieren
	if(isset($_GET['action']) && $_GET['action']=="addUser")
	{
		UserWorker::insertUser($_POST);
		include("includes/user.inc.php");	
	}
	else 
	{
?>

<div class='left'>
	<?php
		
	?>
</div>
	<div class='main'>
		
	
<?php
	
	$user = new User();
	
	// Userdaten holen, falls eine UserId übergeben wurde
	if(isset($_GET['userid']) && $_GET['userid']!="")
	{
		$user = UserWorker::getUser($_GET['userid']);
	}
	
	?>
		
		
<form action="?site=userform&amp;action=addUser" method="post">
	<?php
		if(isset($_GET['userid']) && $_GET['userid']!="")
		{
			echo "<input type='hidden' name='userid' value='".$_GET['userid']."'>";
		}
	?>
	<table>
		<tr>
			<td>Username</td>
			<td><input type="text" name="username" value="<?php echo $user->getUser_name();?>" required/></td>
		</tr>
		<tr>
			<td>Beigetreten am:</td>
			<td><input type="date" name="entryDate" value="<?php echo $user->getUser_entrydate();?>" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}"/></td>
		</tr>
		<tr>
			<td>Ausgetreten am:</td>
			<td><input type="date" name="leftDate" value="<?php echo $user->getUser_leftdate();?>" placeholder="dd.mm.jjjj" pattern="[\d]{2}.[\d]{2}.[\d]{4}"/></td>
		</tr>
		<tr>
			<td>Standardteam</td>
			<td><input type="text" name="defaultTeam" value="<?php echo $user->getUser_defaultteam();?>" pattern="[0-3]{1}" required/></td>
		</tr>
	</table>
	<input type="submit" class="submit">
</form>

</div>
<?php
}
?>