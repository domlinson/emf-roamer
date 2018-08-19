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

		echo $newLine . "<br />";
        if($newLine == $_SESSION["myID"])
		{
			$queueNum = $queueNum + 1;
			echo $queueNum;
			break;
		}
    }

    fclose($handle);
	} else {
    // error opening the file.
	} 
	
		echo "<center>Number in queue: " . $queueNum . ". Wait time approx " . ($queueNum*5) . " minutes.</center>";

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
