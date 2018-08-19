<?php

	$f = fopen("people.queue", 'r');
	$currentUser = fgets($f);
	fclose($f);
	
	$newLine = preg_replace('/\s+/', '', $currentUser);
	if ($newLine > 0)
	{
		
		$IDTime = date("r",hexdec(substr($newLine,0,8)));
		$nowTime = date('Y-m-d H:i:s');
		//$since_start = $nowTime->diff(new DateTime('2018-08-19 10:25:00'));
		$difference_in_seconds = strtotime($nowTime) - strtotime($IDTime);//28800
		if ($difference_in_seconds > 10)
		{
			echo $difference_in_seconds . " duration for current user. Terminating their session and removing their Session ID from the file.";
			read_and_delete_first_line("people.queue");
		}
	}	
		
	function read_and_delete_first_line($filename) {
		$file = file($filename);
		$output = $file[0];
		unset($file[0]);
		file_put_contents($filename, $file);
		return $output;
	}
?>