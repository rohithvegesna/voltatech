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
	
	$enum = mysqli_real_escape_string($conn, $_POST['enum']);
	$gsal = mysqli_real_escape_string($conn, $_POST['gsal']);
	$adm = mysqli_real_escape_string($conn, $_POST['adm']);
	$bid = mysqli_real_escape_string($conn, $_POST['branch']);
	
	$sql = "SELECT COUNT(*) FROM employee WHERE EmpNum='".$enum."'";
	$qury = mysqli_query($conn, $sql);
	$array = mysqli_fetch_array($qury);
	if($array['COUNT(*)'] != 0)
	{
		header("Location: ../index.php?page=employee");exit;die;
	}
	
	$time = time();
	
	$sql = "CREATE TABLE IF NOT EXISTS employee ( ID INT NOT NULL AUTO_INCREMENT, EmpNum TEXT, UserName TEXT, Password TEXT, Gsal TEXT, BranchID TEXT, Status TEXT, IsAdmin TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	
	$sql = "INSERT into employee (`EmpNum`, `Password`, `Gsal`, `BranchID`, `Status`, `IsAdmin`, `Doe`) VALUES ('$enum', '696d29e0940a4957748fe3fc9efd22a3', '$gsal', '$bid', '1', '$adm', '$time')";
	$qury = mysqli_query($conn, $sql);
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
	}
	else
	{
		header("Location: ../index.php?page=employee");
	}