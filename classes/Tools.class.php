<?php


class Tools
{
	static function printArray($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	
	static function formatNumber($number,$decimal=0)
	{
		return number_format($number,$decimal,',',".");
	}
}

?>
