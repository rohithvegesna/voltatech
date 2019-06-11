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
		$usrid = $_SESSION['userID'];
		$empnum = $_SESSION['empID'];
	}
	
	include_once('db.php');
	
	$reason = mysqli_real_escape_string($conn, $_POST['title']);
	$from = mysqli_real_escape_string($conn, strtotime(substr($_POST['date'], 0, -13)));
	$to = mysqli_real_escape_string($conn, strtotime(substr($_POST['date'], -10)));
	
	$time = time();
	$sql = "SELECT BranchID FROM employee WHERE ID =".$usrid;
	$res = mysqli_query( $db, $sql );
	$array = mysqli_fetch_array($res);
	$branchid = $array['BranchID'];
	
	$sql = "CREATE TABLE IF NOT EXISTS leaves ( ID INT NOT NULL AUTO_INCREMENT, UserID TEXT, EmpNum TEXT, Reason TEXT, FromDT TEXT, ToDT TEXT, BranchID TEXT, Status TEXT, ApprovedBy TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	
	$sql = "INSERT INTO leaves (`UserID`, `EmpNum`, `Reason`, `FromDT`, `ToDT`, `BranchID`, `Status`, `Doe`) VALUES ('$usrid', '$empnum', '$reason', '$from', '$to', '$branchid', '2', '$time')";
	$qury = mysqli_query($conn, $sql);
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
		echo mysqli_error($conn);
	}
	else
	{
		header("Location: ../index.php?page=attandance");
	}