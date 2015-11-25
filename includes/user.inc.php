<?PHP
	require_once 'worker/UserWorker.class.php';
?>

<div class='left'>
	<ul>
	<li><a href="?site=users&active=1">aktive User</a><br></li>
	<li><a href="?site=users&active=0">inaktve User</a><br></li>
	<li><a href="?site=users">alle User</a></li>
	<li><a href='?site=userform'>User hinzufügen</a></li>	
	</ul>
</div>
	<div class='main'>
		<?php
		$active = null;
		
		if(isset($_GET['active']) && $_GET['active'] != "")
			$active = $_GET['active'];
		
		$worker = new UserWorker();
		$userarr = $worker->showuser($active);
			
		
		
		if($userarr != null)
		{
			echo "<table class='user'>";
			echo "<tr>";
			echo "<th>Name</th>";
			echo "<th>Team</th>";
			echo "<th>Beigetreten am</th>";
			echo "<th>Ausgetreten am</th>";
			echo "<th>Update</th>";
			echo "</tr>";
			foreach($userarr as $user)
			{
				echo "<tr>";
				echo "<td>".$user['user_name']."</td>";
				echo "<td>".$user['user_defaultteam']."</td>";
				echo "<td>".date("d.m.Y",$user['user_entrydate'])."</td>";		
				echo "<td>".($user['user_leftdate'] != 0 ? date("d.m.Y",$user['user_leftdate']):' --- ')."</td>";
				echo "<td><a href='?site=userform&userid=".$user['user_id']."'>Update</td>";				
				echo "</tr>";
			}	
			echo "</table>";
		}	
		else 
		{
			echo "Keine User vorhanden";	
		}	
					
			
			
		?>
	
	</div>