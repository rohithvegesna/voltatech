<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?php 
	include_once("db.php"); 
	session_start(); 
	date_default_timezone_set('Asia/Kolkata');
 
	$un = mysqli_real_escape_string($conn,$_POST['uname']);
	$pass = mysqli_real_escape_string($conn,$_POST['pwd']);
		
	$sql = "SELECT count(*),ID,EmpNum,IsAdmin FROM employee WHERE( ( EmpNum='".$un."' OR UserName='".$un."' ) AND Password='".md5(md5($pass))."') GROUP BY ID";
	$qury = mysqli_query($db, $sql);
	$result = mysqli_fetch_array($qury);
	
	if($result['count(*)'] != 0)
	{
		
		$_SESSION['empID'] = $result['EmpNum'];
		$_SESSION['userID'] = $result['ID'];
		$_SESSION['IsAdmin'] = $result['IsAdmin'];
		$_SESSION['time'] = time();
		header('Location: ../index.php');
		exit;
	}
	header('Location: ../login.php');
?>