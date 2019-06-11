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
		if($isadmin != 'supadmin')
		{
			header("Location: ../index.php");exit;die;
		}
	}
	
	include_once('db.php');
	$pass = mysqli_real_escape_string($conn, $_POST['pwd']);
	$sql = "UPDATE employee SET Password = '".md5(md5($pass))."' WHERE ID = ".$usrid;
	$res = mysqli_query( $db, $sql );
	if(!res){
		echo 'Failed!!';
	}
	else{
		header("Location: ../index.php?page=profile");
	}