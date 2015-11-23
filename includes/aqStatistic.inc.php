<?php

$teamcount = AQWorker::getTeamCount($aqid);
	
echo "<table class='aqdetails'>";
echo "<tr>";
echo "<td>Gesamtpunkte</td>";
echo "<td>".$pointsTotalAQ."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Teamverteilung</td>";
echo "<td>";

if($teamcount!=null)
{
	echo "<table>";
	echo "<tr><th>Tag<th><th>Team1<th><th>Team2</th><th>Team3</th><th>Gesamt pro Tag</th></tr>";
	foreach($teamcount as $day => $details)	
	{
		if(!array_key_exists(1, $details))
			$details[1] = 0;
		if(!array_key_exists(2, $details))
			$details[2] = 0;
		if(!array_key_exists(3, $details))
			$details[3] = 0;
		
		$gesamtDay = $details[1] * $details[2] + $details[3];
		
		echo "<tr><td>$day<td><td>$details[1]<td><td>$details[2]</td><td>$details[3]</td><td>$gesamtDay</td></tr>";			
	}
	echo "</table>";
}

echo "</td>";
echo "</tr>";
echo "</table>";

?>