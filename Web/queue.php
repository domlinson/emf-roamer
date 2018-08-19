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
	echo "<center>Number in queue: " . $_SESSION["inQueue"] . ". Wait time approx " . ($_SESSION["inQueue"]*5) . " minutes.</center>";
	//upon refresh if they are queue num 0 then let them in.
}
else
{
	$queue = file_get_contents('./queue.num', true);
	$myNum = $queue + 1;
	// Set session variables
	$_SESSION["inQueue"] = $myNum;
	//$_SESSION["favanimal"] = "cat";
	echo "<center>Hold Tight! You are number " . $myNum . " in the queue</center>";
	file_put_contents('./queue.num', $_SESSION["inQueue"]);

// <= PHP 5
}
?>


</body>
</html>
