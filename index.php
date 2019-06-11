<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
	if( !isset($_SESSION['empID']) )
	{
		header('Location: funcs/logout.php');die;exit;
	}
	
	else
	{
		$_SESSION['time'] = time();
		include "funcs/db.php";
		$page = mysqli_real_escape_string($conn,$_GET['page']);
		$session = $_SESSION['IsAdmin'];
		$sessionid = $_SESSION['userID'];
		$empnum = $_SESSION['empID'];
		
		$sql = "SELECT MAX(Doe) FROM salary";
		$res = mysqli_query( $db, $sql );
		$array = mysqli_fetch_array($res);
		$_SESSION['Salgen'] = $array['MAX(Doe)'];
		$salgen = $_SESSION['Salgen'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Voltatech ~ employee</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</head>
<body>
<?php
	if($session == 'supadmin'){ include 'funcs/supadm.php'; }
	elseif(($session == 'admin') || ($session == 'emp')){ include 'funcs/admuser.php'; }
	else{ echo 'Please Contact Administrator'; }
?>
</body>
</html>