<?php
	$days= date('t');
	$myTime = strtotime("1/".date('n')."/".date('Y'));
	$workDays = 0;
	while($days > 0)
	{
		$day = date("D", $myTime);
		if($day != "Sun")
			$workDays++;

		$days--;
		$myTime += 86400; // 86,400 seconds = 24 hrs.
	}
	
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
?>