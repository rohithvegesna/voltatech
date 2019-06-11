<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	
	session_start();
	date_default_timezone_set('Asia/Kolkata');
	if( !isset($_SESSION['empID']) )
	{
		header('Location: logout.php');die;exit;
	}
	else
	{
		$_SESSION['time'] = time();
		$isadmin = $_SESSION['IsAdmin'];
		if($isadmin != 'supadmin')
		{
			header("Location: ../index.php");exit;die;
		}
	}
	
	include_once('db.php'); 
	
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$date = strtotime(mysqli_real_escape_string($conn, $_POST['date']));
	
	$time = time();
	
	$sql = "SELECT COUNT(*) FROM nonworkingdays WHERE DAY(FROM_UNIXTIME(Doe)) = '".$date."'";
	$qury = mysqli_query($conn, $sql);
	$array = mysqli_fetch_array($qury);
	if($array['COUNT(*)'] != 0)
	{
		header("Location: ../index.php");exit;die;
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS nonworkingdays ( ID INT NOT NULL AUTO_INCREMENT, Title TEXT, Date TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	
	$sql = "INSERT into nonworkingdays (`Title`, `Date`, `Doe`) VALUES ('$title', '$date', '$time')";
	$qury = mysqli_query($conn, $sql);
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
	}
	else
	{
		header("Location: ../index.php");
	}