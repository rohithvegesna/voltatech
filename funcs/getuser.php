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
	}
	
	include_once('db.php');
	$uname = mysqli_real_escape_string($conn, $_GET['q']);
	$sql = "SELECT COUNT(UserName) FROM employee WHERE ID != '".$usrid."' AND UserName ='".$uname."'";
	$res = mysqli_query( $db, $sql );
	$array = mysqli_fetch_array($res);
	if($array['COUNT(UserName)'] == 0){
		echo 'Username: Available';
	}
	else{
		echo 'Username: <strong style="color:red;">Not Available</strong>';
	}