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
		if($isadmin != 'admin')
		{
			header("Location: ../index.php");exit;die;
		}
	}
	
	include_once('db.php');
	
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	
	$sql = "UPDATE leaves SET `Status`='1', `ApprovedBy`='".$usrid."' WHERE ID=".$id;
	$qury = mysqli_query($conn, $sql);
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
		echo mysqli_error($conn);
	}
	else
	{
		header("Location: ../index.php?page=leaveapp");
	}