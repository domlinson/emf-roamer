<?php
// Start the session
session_start();
?>

<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>The EMF Roamer</title>
	<meta name="description" content="The EMF Roamer">
	<meta name="author" content="DT-CS">
	
</head>

<html>
<body>

<?php
$myNum = -255;
if (isset($_SESSION["inQueue"]))
{
	// already in the queue, so let them know
	//upon refresh if they are queue num 0 then let them in.
	$queueNum = 0;
	$handle = fopen("people.queue", "r");
	if ($handle) {
    while (($line = fgets($handle)) !== false) {
		
		$newLine = preg_replace('/\s+/', '', $line);
		$queueNum = $queueNum + 1;

		//echo $newLine . "<br />";
        if($newLine == $_SESSION["myID"])
		{
			//echo $queueNum;
			break;
		}
    }

    fclose($handle);
	} else {
    // error opening the file.
	} 
		if($queueNum == 0)
		{
			echo "<center>You're up! You've got 5 minutes.</center>";
		} else {
			echo "<center>Number in queue: " . $queueNum . ". Wait time approx " . ($queueNum*5) . " minutes.</center>";
			
		}
		$newLine = preg_replace('/\s+/', '', $line);

			$IDTime = date("r",hexdec(substr($newLine,0,8)));
			$nowTime = date('Y-m-d H:i:s');
			//$since_start = $nowTime->diff(new DateTime('2018-08-19 10:25:00'));
			$difference_in_seconds = strtotime($nowTime) - strtotime($IDTime);//28800
			if ($difference_in_seconds > 300)
			{
				echo "<center>Your 5 minutes is up!</center>";
			}
}
else
{
	
	$file="people.queue";
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)){
	  $line = fgets($handle);
	  $linecount++;
	}

	fclose($handle);
	//echo $linecount;
	
	//$queue = file_get_contents('./queue.num', true);
	$myNum = $linecount + 1;
	// Set session variables
	$_SESSION["inQueue"] = $linecount;
	$_SESSION["myID"] = uniqid();

	//$_SESSION["favanimal"] = "cat";
	echo "<center>Hold Tight! You are number " . $myNum . " in the queue</center>";
	file_put_contents('./queue.num', $_SESSION["inQueue"]);
	file_put_contents('people.queue', $_SESSION["myID"].PHP_EOL , FILE_APPEND | LOCK_EX);

// <= PHP 5
}
?>


</body>
</html>
