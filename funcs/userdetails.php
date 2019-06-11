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
	
	$uname = mysqli_real_escape_string($conn, $_POST['uname']);
	$fname = ucwords(strtolower(mysqli_real_escape_string($conn, $_POST['fname'])));
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$bnum = mysqli_real_escape_string($conn, $_POST['bnum']);
	$ifsc = ucwords(strtolower(mysqli_real_escape_string($conn, $_POST['ifsc'])));
	$pan = ucwords(strtolower(mysqli_real_escape_string($conn, $_POST['pan'])));
	$anum = mysqli_real_escape_string($conn, $_POST['anum']);
	$add = mysqli_real_escape_string($conn, $_POST['add']);
	
	$time = time();
	
	$sql = "CREATE TABLE IF NOT EXISTS empdet ( ID INT NOT NULL AUTO_INCREMENT, UserID TEXT, FullName TEXT, Email TEXT, BankNum TEXT, Ifsc TEXT, Pan TEXT, Aadhar TEXT, Address TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$qury = mysqli_query($conn, $sql);
	
	$sql1 = "SELECT COUNT(*) FROM empdet WHERE UserID = ".$usrid;
	$res1 = mysqli_query( $db, $sql1 );
	$array1 = mysqli_fetch_array($res1);
	if( $array1['COUNT(*)'] == 0 )
	{
		$sql = "INSERT into empdet (`UserID`, `FullName`, `Email`, `BankNum`, `Ifsc`, `Pan`, `Aadhar`, `Address`, `Doe`) VALUES ('$usrid', '$fname', '$email', '$bnum', '$ifsc', '$pan', '$anum', '$add', '$time');";
	}
	else
	{
		$sql = "UPDATE empdet SET `FullName`='$fname', `Email`='$email', `BankNum`='$bnum', `Ifsc`='$ifsc', `Pan`='$pan', `Aadhar`='$anum', `Address`='$add', `Doe`='$time' WHERE UserID='$usrid';";
	}
	$sql .= "UPDATE employee SET UserName = '$uname', Password = '".md5(md5($pwd))."' WHERE ID='$usrid';";
	$qury = mysqli_multi_query($conn, $sql);
	
	mysqli_close($conn);

	if(!$qury)
	{
		echo "Failed.";
	}
	else
	{
		header("Location: ../index.php?page=profile");
	}