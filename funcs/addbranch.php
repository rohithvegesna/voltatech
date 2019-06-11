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
	
	$bname = strtoupper(mysqli_real_escape_string($conn, $_POST['branchname']));
	$branch = strtoupper(mysqli_real_escape_string($conn, $_POST['branch']));
	
	$sql = "SELECT COUNT(*) FROM branches WHERE BranchName='".$bname."'";
	$qury = mysqli_query($conn, $sql);
	$array = mysqli_fetch_array($qury);
	if($array['COUNT(*)'] != 0)
	{
		header("Location: ../index.php");exit;die;
	}
	
	$time = time();
	
	$sql = "CREATE TABLE IF NOT EXISTS branches ( ID INT NOT NULL AUTO_INCREMENT, BranchName TEXT, Branch TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	
	$sql = "INSERT into branches (`BranchName`, `Branch`, `Doe`) VALUES ('$bname', '$branch', '$time')";
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