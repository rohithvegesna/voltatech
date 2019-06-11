<?php
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
	
	$bid = mysqli_real_escape_string($conn, $_GET['bid']);
	$from = mysqli_real_escape_string($conn, strtotime(substr($_GET['date'], 0, -13)));
	$to = mysqli_real_escape_string($conn, (strtotime(substr($_GET['date'], -10)))+86400);?>
	<table style="background:white;" class="table table-bordered text-center">
				<thead>
					<tr>
						<th>Date</th>
					<?php
					$sql = "SELECT DISTINCT Doe FROM attandance WHERE BranchID = '".$bid."' AND ( Doe >= '".$from."' AND Doe <= '".$to."' )";
					$res = mysqli_query( $db, $sql );
					if( !is_bool($res) )
					{
						while($array = mysqli_fetch_array($res))
						{
							echo '<th>'.date('d-m-Y', $array['Doe']).'</th>';
						}
					}
					?>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT DISTINCT EmpNum FROM attandance WHERE BranchID = '".$bid."' AND ( Doe >= '".$from."' AND Doe <= '".$to."' )";
					$res = mysqli_query( $db, $sql );
					if( !is_bool($res) )
					{
						while($array = mysqli_fetch_array($res))
						{
							echo '<tr><td>'.$array['EmpNum'].'</td>';
								$sql1 = "SELECT Att,AttTime FROM attandance WHERE EmpNum = '".$array['EmpNum']."' AND BranchID = '".$bid."' AND ( Doe >= '".$from."' AND Doe <= '".$to."' )";
								$res1 = mysqli_query( $db, $sql1 );
								if( !is_bool($res1) )
								{
									while($array1 = mysqli_fetch_array($res1))
									{
										echo '<td>'.$array1['Att'].' ('.$array1['AttTime'].')</td>';
									}
								}
							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>