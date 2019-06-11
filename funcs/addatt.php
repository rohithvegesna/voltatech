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
		if($isadmin != 'admin')
		{
			header("Location: ../index.php");exit;die;
		}
		$usrid = $_SESSION['userID'];
	}
	
	include_once('db.php');
	
	$sql1 = "SELECT BranchID FROM employee WHERE ID =".$usrid;
	$res1 = mysqli_query( $db, $sql1 );
	$array1 = mysqli_fetch_array($res1);
	$branch = $array1['BranchID'];
	
	$time = time();
	$atttime = date('A');
	$opt = $_POST['optradio'];
	
	$sql = "CREATE TABLE IF NOT EXISTS attandance ( ID INT NOT NULL AUTO_INCREMENT, EmpNum TEXT, Att TEXT, AttTime TEXT, AttBy TEXT, BranchID TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	foreach($opt as $key => $option) { 
				$sql = "INSERT into attandance (`EmpNum`, `Att`, `AttTime`, `AttBy`, `BranchID`, `Doe`) VALUES ('$key', '$option', '$atttime', '$usrid', '$branch', '$time');";
				$qury = mysqli_query($conn, $sql);
            }
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
	}
	else
	{
		header("Location: ../index.php?page=addattandance");
	}