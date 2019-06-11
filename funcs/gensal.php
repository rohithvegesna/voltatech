<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
	$time = strtotime(date('d-m-Y'));
	
	if( !isset($_SESSION['empID']) )
	{
		header('Location: logout.php');die;exit;
	}
	else
	{
		$_SESSION['time'] = time();
		$isadmin = $_SESSION['IsAdmin'];
		$salgen = $_SESSION['Salgen'];
		if($isadmin != 'supadmin')
		{
			echo "error";exit;die;
		}
	}
	include "db.php";
	$start = "SELECT COUNT(*) FROM `salary` WHERE 1";
	$start1 = mysqli_query( $db, $start );
	$start3 = mysqli_fetch_array($start1);
	if( $start3['COUNT(*)'] == 0 )
	{
		$sql = "INSERT INTO salary (`UserID`, `EmpNum`, `Leaves`, `Gross`, `Basic`, `Hra`, `Conveyance`, `SpecialA`, `Pf`, `Esi`, `LeavePrice`, `ProfTax`, `Total`, `Doe`) VALUES ('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$time')";
		$qury = mysqli_query( $db, $sql );
		echo 'Salary Generated';
		exit;die;
	}
	$grandtot=null;
	$days= ((strtotime(date('d-m-Y')) - $salgen)/86400);
	$myTime = strtotime($salgen);
	$workDays = 0;
	while($days > 0)
	{
		$day = date("D", $myTime);
		if($day != "Sun")
			$workDays++;

		$days--;
		$myTime += 86400; // 86,400 seconds = 24 hrs.
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS salary ( ID INT NOT NULL AUTO_INCREMENT, UserID TEXT, EmpNum TEXT, Leaves TEXT, Gross TEXT, Basic TEXT, Hra TEXT, Conveyance TEXT, SpecialA TEXT, Pf TEXT, Esi TEXT, LeavePrice TEXT, ProfTax TEXT, Total TEXT, Doe TEXT, PRIMARY KEY (ID) )";
	$res = mysqli_query( $db, $sql );
	
	$sqll = "SELECT * FROM employee WHERE Status='1' AND IsAdmin != 'supadmin'";
	$resl = mysqli_query( $db, $sqll );
	
	if( !is_bool($resl) )
	{
		while($array = mysqli_fetch_array($resl))
		{
			$sql1 = "SELECT * FROM leaves WHERE ToDT > '".$salgen."' AND Status = '1' AND UserID='".$array['ID']."'";
			$res1 = mysqli_query( $db, $sql1 );
			
			if( !is_bool($res1) )
			{
				while($array1 = mysqli_fetch_array($res1))
				{
					if($array1['FromDT'] < $salgen && $array1['ToDT'] > $salgen){
						$daysl= ((($array1['ToDT']+86400)-($salgen))/86400);
						$myTimel = $salgen;
						$leave = 0;
						while($daysl > 0)
						{
							$dayl = date("D", $myTime);
							if($dayl != "Sun")
								$leave++;

							$daysl--;
							$myTimel += 86400; // 86,400 seconds = 24 hrs.
						}
					}
					elseif($array1['FromDT'] < $time && $array1['ToDT'] > $time){
						$daysl= ((($array1['ToDT'])-($time))/86400);
						$myTimel = $time;
						$leave = 0;
						while($daysl > 0)
						{
							$dayl = date("D", $myTime);
							if($dayl != "Sun")
								$leave++;

							$daysl--;
							$myTimel += 86400; // 86,400 seconds = 24 hrs.
						}
					}
					else{
						$daysl= ((($array1['ToDT']+86400)-($array1['FromDT']))/86400);
						$myTimel = $array1['FromDT'];
						$leave = 0;
						while($daysl > 0)
						{
							$dayl = date("D", $myTime);
							if($dayl != "Sun")
								$leave++;

							$daysl--;
							$myTimel += 86400; // 86,400 seconds = 24 hrs.
						}
					}
				}
			}
			
			$sql2 = "SELECT COUNT(*) FROM attandance WHERE Att = 'P' AND MONTH(FROM_UNIXTIME(Doe)) = MONTH(CURRENT_DATE()) AND EmpNum='".$array['EmpNum']."'";
			$res2 = mysqli_query( $db, $sql2 );
			$array2 = mysqli_fetch_array($res2);
			$present = (($array2['COUNT(*)'])/2);
			
			if($leave > 1.5){
				$leaves = (($workDays-$present)-($leave - 1.5));
			}
			elseif($leave <= 1.5){
				$leaves = ($workDays-$present);
			}
			
			$gross = $array['Gsal'];
			$basic = ((40/100)*($gross));
			$hra = ((40/100)*($basic));
			$conveyance = 1600;
			$spcallowance = ($gross-($basic+$hra+$conveyance));
			$pf = ((12/100)*($basic));
			
			if($gross > 21000){
				$esi = ((1.75/100)*(21000));
			}
			else{
				$esi = ((1.75/100)*($gross));
			}

			$grossn = ($pf+$esi);
			$leavesprice = (($gross/$workDays)*$leaves);
			$tot = ($gross-$grossn-$leavesprice);
			
			if($tot > 15000){
				$proftax = 200;
			}
			else{
				$proftax = 0;
			}
			
			$total = round(($tot-$proftax), 2);
			
			$sql = "INSERT INTO salary (`UserID`, `EmpNum`, `Leaves`, `Gross`, `Basic`, `Hra`, `Conveyance`, `SpecialA`, `Pf`, `Esi`, `LeavePrice`, `ProfTax`, `Total`, `Doe`) VALUES ('".$array['ID']."', '".$array['EmpNum']."', '$leaves', '$gross', '$basic', '$hra', '$conveyance', '$spcallowance', '$pf', '$esi', '$leavesprice', '$proftax', '$total', '$time')";
			$qury = mysqli_query( $db, $sql );
			
			$leave = null;
		}
	}
	echo 'Salary Generated';
?>