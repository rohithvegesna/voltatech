<div class="container text-center">
<!--Headder-->
	<div class="jumbotron">
		<h1>Voltatech</h1>
		<h4>Welcome : <?php
							$sql = "SELECT * FROM empdet WHERE UserID=".$sessionid;
							$res = mysqli_query( $db, $sql );
							$array = mysqli_fetch_array($res);
							echo $array['FullName'];
						?></h4>
		<ul class="nav nav-tabs">
		  <li <?php if($page == 'home') echo 'class="active"';?>><a href="?page=home">Home</a></li>
		  <?php if($session == 'admin') {if($page == 'addattandance'){ $class = 'class="active"'; } else{ $class = ''; } echo '<li '.$class.'><a href="?page=addattandance">Add Attandance</a></li>';}?>
		  <?php if($session == 'admin') {if($page == 'leaveapp'){ $class = 'class="active"'; } else{ $class = ''; } echo '<li '.$class.'><a href="?page=leaveapp">Leave Approvals</a></li>';}?>
		  <li <?php if($page == 'profile') echo 'class="active"';?>><a href="?page=profile">Profile</a></li>
		  <li <?php if($page == 'attandance') echo 'class="active"';?>><a href="?page=attandance">Attandance</a></li>
		  <li <?php if($page == 'payslip') echo 'class="active"';?>><a href="?page=payslip">Pay Slip</a></li>
		  <li><a href="funcs/logout.php">Logout</a></li>
		</ul>
	</div>
<!--Headder-->

<?php if($page == null || $page == 'home') {?>
<!--Home-->
	<div class="row">
		<div class="col-sm-6">
			<div class="well well-lg text-center">
				<h1>Non working days this month</h1><br>
				<table style="background:white;" class="table table-bordered text-center">
					<thead>
						<tr>
							<th>Reason</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT * FROM nonworkingdays WHERE Date > '".$salgen."' ORDER BY Date ASC";
						$res = mysqli_query( $db, $sql );
						
						if( !is_bool($res) )
						{
							while($array = mysqli_fetch_array($res))
							{
								echo '<tr>
											<td>'.$array['Title'].'</td>
											<td>'.date('d-m-Y',$array['Date']).'</td>
										</tr>';
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="well well-lg text-center">
				<h1>Leaves</h1>
				<p>
					Paid Leaves per month : 1.5 days<br>
					<strong>Leaves taken without approval will be considered as unpaid leaves</strong>
				</p><br>
				<table style="background:white;" class="table table-bordered text-center">
					<thead>
						<tr>
							<th>Reason</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT * FROM leaves WHERE Status = '1' AND UserID = '".$sessionid."'";
						$res = mysqli_query( $db, $sql );
						
						if( !is_bool($res) )
						{
							while($array = mysqli_fetch_array($res))
							{
								echo '<tr>
											<td>'.$array['Reason'].'</td>
											<td>'.date('d-m-Y',$array['FromDT']).' - '.date('d-m-Y',$array['ToDT']).'</td>
										</tr>';
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!--Home-->
<?php }?>

<?php if($page == 'addattandance' && $session == 'admin') {?>
<!--addattandance-->
	<div class="well well-lg text-center">
		<h1>Add Attandance</h1>
		<div class="row">
			<div class="col-sm-12">
			<?php
				$sql1 = "SELECT BranchID FROM employee WHERE ID =".$sessionid;
				$res1 = mysqli_query( $db, $sql1 );
				$array1 = mysqli_fetch_array($res1);
				$sql = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe))=DAY(CURRENT_DATE()) AND AttTime = '".date('A')."' AND BranchID ='".$array1['BranchID']."'";
				$res = mysqli_query( $db, $sql );
				$array = mysqli_fetch_array($res);
				
				if( $array['COUNT(*)'] == 0 )
				{?>
				<form action="funcs/addatt.php" method="post" autocomplete="off">
					<table style="background:white;" class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Name</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$sql1 = "SELECT BranchID FROM employee WHERE ID =".$sessionid;
							$res1 = mysqli_query( $db, $sql1 );
							$array1 = mysqli_fetch_array($res1);
							$sql = "SELECT * FROM employee WHERE IsAdmin != 'supadmin' AND BranchID =".$array1['BranchID'];
							$res = mysqli_query( $db, $sql );
							
							if( !is_bool($res) )
							{
								while($array = mysqli_fetch_array($res))
								{
									echo '<tr>
												<td><label>'.$array['EmpNum'].'</label></td>
												<td><label class="radio-inline"><input type="radio" name="optradio['.$array['EmpNum'].']" value="P">P</label></td>
												<td><label class="radio-inline"><input type="radio" name="optradio['.$array['EmpNum'].']" value="A">A</label></td>
											</tr>';
								}
							}
						?>
						</tbody>
					</table>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
				<?php } else{ echo 'Attandance was taken'; }?>
			</div>
		</div>
	</div>
<!--addattandance-->
<?php }?>

<?php if($page == 'leaveapp' && $session == 'admin') {?>
<!--leaveapp-->
	<div class="well well-lg text-center">
		<h1>Add Attandance</h1>
		<div class="row">
			<div class="col-sm-12">
				<table style="background:white;" class="table table-bordered text-center">
					<thead>
						<tr>
							<th>EmpNum</th>
							<th>Reason</th>
							<th>From-To</th>
							<th>Approve</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql1 = "SELECT BranchID FROM employee WHERE ID =".$sessionid;
						$res1 = mysqli_query( $db, $sql1 );
						$array1 = mysqli_fetch_array($res1);
						$sql = "SELECT * FROM leaves WHERE BranchID =".$array1['BranchID'];
						$res = mysqli_query( $db, $sql );
						
						if( !is_bool($res) )
						{
							while($array = mysqli_fetch_array($res))
							{
								if($array['Status'] == '2'){$button = '<a href="funcs/leaveapp.php?id='.$array['ID'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';}
								else{$button = 'Approved';}
								echo '<tr>
											<td>'.$array['EmpNum'].'</td>
											<td>'.$array['Reason'].'</td>
											<td>'.date('d-m-Y',$array['FromDT']).' TO '.date('d-m-Y',$array['ToDT']).'</td>
											<td>'.$button.'</td>
										</tr>';
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!--leaveapp-->
<?php }?>

<?php if($page == 'profile') {?>
<!--profile-->
<script>
$( document ).ready(function() {
	$('.form-control').attr('disabled','disabled');
	$('#btn').attr('disabled','disabled');
});
</script>
<script>
$(document). ready(function() {
$("#edit"). click(function(){
$(".form-control").removeAttr("disabled");
$('#btn').removeAttr("disabled");
});
});
</script>
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="Username: Please Enter Username";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
	  if(this.responseText=='Username: Available'){
		  $('#btn').removeAttr("disabled");
	  }
	  else{
			$('#btn').attr('disabled','disabled');
	  }
    }
  }
  xmlhttp.open("GET","funcs/getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>
	<div class="well well-lg text-center">
		<h1>Profile</h1><br><button id="edit" class="btn btn-lg btn-default">Edit</button><br>
		<div class="row">
			<form action="funcs/userdetails.php" method="post" autocomplete="off">
			<?php
				$sql = "SELECT A.UserName,B.FullName,B.Email,B.BankNum,B.Ifsc,B.Pan,B.Aadhar,B.Address FROM employee A,empdet B WHERE A.ID=B.UserID AND A.ID =".$sessionid;
				$res = mysqli_query( $db, $sql );
				
				if( !is_bool($res) )
				{
					while($array = mysqli_fetch_array($res))
					{
						echo '<div class="col-sm-6">
								  <div class="form-group">
									<label for="email" id="livesearch">Username:</label>
									<input type="text" class="form-control" onkeyup="showResult(this.value)" name="uname" value="'.$array['UserName'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">Full Name:</label>
									<input type="text" class="form-control" name="fname" value="'.$array['FullName'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">Email address:</label>
									<input type="email" class="form-control" name="email" value="'.$array['Email'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="pwd">Password (New/Old):</label>
									<input type="password" class="form-control" name="pwd" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">Bank Account Number:</label>
									<input type="number" class="form-control" name="bnum" value="'.$array['BankNum'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">IFSC:</label>
									<input type="text" class="form-control" name="ifsc" value="'.$array['Ifsc'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">PAN:</label>
									<input type="text" class="form-control" name="pan" value="'.$array['Pan'].'" required>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label for="email">AADHAR NO:</label>
									<input type="text" class="form-control" name="anum" value="'.$array['Aadhar'].'" required>
								  </div>
								</div>
								<div class="col-sm-12">
								  <div class="form-group">
									<label for="email">Address:</label>
									<textarea type="text" class="form-control" name="add" required>'.$array['Address'].'</textarea>
								  </div>
								</div>';
					}
				}
				$sql = "SELECT COUNT(*) FROM employee A,empdet B WHERE A.ID=B.UserID AND A.ID =".$sessionid;
				$res = mysqli_query( $db, $sql );
				$array = mysqli_fetch_array($res);
				
				if( $array['COUNT(*)'] == 0 )
				{
					echo '<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">Username:</label>
								<input type="text" class="form-control" onkeyup="showResult(this.value)" name="uname" value="" required>
								<div id="livesearch"></div>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">Full Name:</label>
								<input type="text" class="form-control" name="fname" value="" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">Email address:</label>
								<input type="email" class="form-control" name="email" value="" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="pwd">Password (New/Old):</label>
								<input type="password" class="form-control" name="pwd" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">Bank Account Number:</label>
								<input type="number" class="form-control" name="bnum" value="" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">IFSC:</label>
								<input type="text" class="form-control" name="ifsc" value="" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">PAN:</label>
								<input type="text" class="form-control" name="pan" value="" required>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<label for="email">AADHAR NO:</label>
								<input type="text" class="form-control" name="anum" value="" required>
							  </div>
							</div>
							<div class="col-sm-12">
							  <div class="form-group">
								<label for="email">Address:</label>
								<textarea type="text" class="form-control" name="add" required></textarea>
							  </div>
							</div>';
				}
			?>
				  <button id="btn" type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
<!--profile-->
<?php }?>

<?php if($page == 'attandance') {?>
<!--attandance-->
<?php if($session == 'admin'){?>
	<div class="well well-lg text-center">
	<?php
		$sql1 = "SELECT BranchID FROM employee WHERE ID =".$sessionid;
		$res1 = mysqli_query( $db, $sql1 );
		$array1 = mysqli_fetch_array($res1);
		$sql = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'A' AND BranchID =".$array1['BranchID'];
		$res = mysqli_query( $db, $sql );
		$array = mysqli_fetch_array($res);
		echo '<h6>No of staff absent: '.$array['COUNT(*)'].'</h6>';
		$sql = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'P' AND BranchID =".$array1['BranchID'];
		$res = mysqli_query( $db, $sql );
		$array = mysqli_fetch_array($res);
		echo '<h6>No of staff present: '.$array['COUNT(*)'].'</h6>';
	?>
	</div>
<?php }?>
	<div class="well well-lg text-center">
		<div class="row">
			<div class="col-md-6">
				<div class="well">
					<form action="funcs/appleave.php" method="post" autocomplete="off">
					  <div class="form-group">
						<div class="row">
							<div class="col-sm-3">
								<label>Apply Leave</label>
							</div>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="title" required>
							</div>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="date" min="1" max="31" value="" required>
							</div>
							<div class="col-sm-3">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					  </div>
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="well">
					<table style="background:white;" class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Reason</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$sql = "SELECT * FROM leaves WHERE (FromDT > '".$salgen."' OR ToDT > '".$salgen."') AND UserID =".$sessionid;
							$res = mysqli_query( $db, $sql );
							
							if( !is_bool($res) )
							{
								while($array = mysqli_fetch_array($res))
								{
									if($array['Status'] == '1'){$stat = '<strong style="color:green;">Success</strong>';}
									else{$stat = '<strong style="color:red;">Pending</strong>';}
									echo '<tr>
												<td>'.$array['Reason'].'</td>
												<td>'.$stat.'</td>
											</tr>';
								}
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="well well-lg text-center">
		<h1>Attandance</h1>
		<div class="row">
			<div class="col-sm-12 well pull-right-lg" style="border:0px solid">
				<div class="row text-center">
					<div class="col-sm-3" style="width: 25%; padding: 5px; background: #009933; color: white;">Present</div>
					<div class="col-sm-3" style="width: 25%; padding: 5px; background: #000033; color: white;">Absent</div>
					<div class="col-sm-3" style="width: 25%; padding: 5px; background: #808000; color: white;">Halfday Present</div>
					<div class="col-sm-3" style="width: 25%; padding: 5px; background: #990033; color: white;">Holiday</div>
				</div>
				<div class="col-md-12" style="padding:0px;">
				  <br>
					<table class="table table-bordered table-style table-responsive">
					  <tr>
						<th class="text-center" colspan="7"><?php echo date('F - Y');?></th>
					  </tr>
					  <tr>
						<th class="text-center">S</th>
						<th class="text-center">M</th>
						<th class="text-center">T</th>
						<th class="text-center">W</th>
						<th class="text-center">T</th>
						<th class="text-center">F</th>
						<th class="text-center">S</th>
					  </tr>
						<?php										
							$cMonth = date('n');
							$cYear = date('Y');
							 
							$prev_year = $cYear;
							$next_year = $cYear;
							$prev_month = $cMonth-1;
							$next_month = $cMonth+1;
							 
							if ($prev_month == 0 ) {
								$prev_month = 12;
								$prev_year = $cYear - 1;
							}
							if ($next_month == 13 ) {
								$next_month = 1;
								$next_year = $cYear + 1;
							}

							$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
							$maxday = date("t",$timestamp);
							$thismonth = getdate ($timestamp);
							$startday = $thismonth['wday'];
							for ($i=0; $i<($maxday+$startday); $i++) {
								if(($i % 7) == 0 ) echo "<tr>";
								if($i < $startday) echo "<td></td>";
								else{
										$sql1 = "SELECT COUNT(*) FROM nonworkingdays WHERE DAY(FROM_UNIXTIME(Date)) ='".($i - $startday + 1)."'";
										$res1 = mysqli_query( $db, $sql1 );
										$array1 = mysqli_fetch_array($res1);
										$sql = "SELECT COUNT(*) FROM attandance WHERE Att = 'P' AND EmpNum = '".$empnum."' AND DAY(FROM_UNIXTIME(Doe)) ='".($i - $startday + 1)."'";
										$res = mysqli_query( $db, $sql );
										$array = mysqli_fetch_array($res);
										if($array['COUNT(*)'] == 2){
											if(($i - $startday + 1) == date('j')){$style='style="text-decoration: underline;background: #009933;color: white;"';}
											elseif(($i - $startday + 1) < date('j')){$style='style="background: #009933;color: white;"';}
											else{$style='style="background: #009933;color: white;"';} 
										}
										elseif($array['COUNT(*)'] == 1){
											if(($i - $startday + 1) == date('j')){$style='style="text-decoration: underline;background: #808000;color: white;"';}
											elseif(($i - $startday + 1) < date('j')){$style='style="background: #808000;color: white;"';}
											else{$style='style="background: #808000;color: white;"';} 
										}
										elseif($array['COUNT(*)'] == 0 && $array1['COUNT(*)'] == 0){
											if(($i - $startday + 1) == date('j')){$style='style="text-decoration: underline;background: #000033;color: white;"';}
											elseif(($i - $startday + 1) < date('j')){$style='style="background: #000033;color: white;"';}
											else{$style='';} 
										}
										elseif($array['COUNT(*)'] == 0 && $array1['COUNT(*)'] != 0){
											if(($i - $startday + 1) == date('j')){$style='style="text-decoration: underline;background: #990033;color: white;"';}
											elseif(($i - $startday + 1) < date('j')){$style='style="background: #990033;color: white;"';}
											else{$style='';} 
										}
										echo "<td ".$style.">". ($i - $startday + 1) . "</td>";
									}
								if(($i % 7) == 6 ) echo "</tr>";
							}
						?>
					</table>

				</div>
			</div>
		</div>
	</div>
<!--profile-->
<?php }?>

<?php if($page == 'payslip') {?>
<!--payslip-->
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<?php
	$sql1 = "SELECT MAX(Doe) FROM salary WHERE UserID =".$sessionid;
	$res1 = mysqli_query( $db, $sql1 );
	$array1 = mysqli_fetch_array($res1);
	$sql = "SELECT * FROM salary WHERE Doe = '".$array1['MAX(Doe)']."' AND UserID =".$sessionid;
	$res = mysqli_query( $db, $sql );
	
	if( !is_bool($res) )
	{
		while($array = mysqli_fetch_array($res))
		{
			$sql2 = "SELECT * FROM empdet WHERE UserID = '".$array['UserID']."'";
			$res2 = mysqli_query( $db, $sql2 );
			$array2 = mysqli_fetch_array($res2);
?>
	<div id="print" class="well well-lg text-center">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1><img src="http://voltatech.in/logo.jpg" /> Voltatech</h1>
				<h1>Payslip</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="invoice-title">
					<h3 class="pull-right">Employee No # <?php echo $array['EmpNum'];?></h3>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-6">
						<address>
							<strong>Processed Date:</strong><br>
							<?php echo date('d-m-Y', $array['Doe']);?><br><br>
						</address>
					</div>
					<div class="col-xs-6 text-right">
						<address>
						<strong>To:</strong><br>
							<?php echo $array2['FullName'];?><br>
							<?php echo $array2['Address'];?>
						</address>
					</div>
					<div class="col-xs-6">
						<address>
							<strong>Bank Account No:</strong><br>
							<?php echo $array2['BankNum'];?><br>
							<strong>IFSC:</strong><br>
							<?php echo $array2['Ifsc'];?><br><br>
						</address>
					</div>
					<div class="col-xs-6 text-right">
						<address>
						<strong>Leaves</strong><br>
							Unpaid Leaves : <?php echo $array['Leaves'];?>
						</address>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading text-center">
						<h3 class="panel-title"><strong>Salary Summary</strong></h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed">
								<thead>
									<tr>
										<td><strong>Earnings</strong></td>
										<td class="text-center"><strong>Amount</strong></td>
										<td class="text-center"><strong>Deductions</strong></td>
										<td class="text-right"><strong>Amount</strong></td>
									</tr>
								</thead>
								<tbody>
									<!-- foreach ($order->lineItems as $line) or some such thing here -->
									<tr>
										<td>Basic</td>
										<td class="text-center">₹<?php echo $array['Basic'];?></td>
										<td class="text-center">Leaves</td>
										<td class="text-right">₹<?php echo $array['LeavePrice'];?></td>
									</tr>
									<tr>
										<td>HRA</td>
										<td class="text-center">₹<?php echo $array['Hra'];?></td>
										<td class="text-center">Provident Fund</td>
										<td class="text-right">₹<?php echo $array['Pf'];?></td>
									</tr>
									<tr>
										<td>Conveyance Allowance</td>
										<td class="text-center">₹<?php echo $array['Conveyance'];?></td>
										<td class="text-center">ESI</td>
										<td class="text-right"><?php echo $array['Esi'];?></td>
									</tr>
									<tr>
										<td>Special Allowance</td>
										<td class="text-center">₹<?php echo $array['SpecialA'];?></td>
										<td class="text-center">Professional Tax</td>
										<td class="text-right">₹<?php echo $array['ProfTax'];?></td>
									</tr>
									<tr>
										<td class="thick-line"><strong>Gross Salary</strong></td>
										<td class="thick-line">₹<?php echo $array['Gross'];?></td>
										<td class="thick-line text-center"><strong>Gross Deduction</strong></td>
										<td class="thick-line text-right">₹<?php echo ($array['Pf']+$array['Esi']);?></td>
									</tr>
									<tr>
										<td class="no-line"></td>
										<td class="no-line"></td>
										<td class="no-line text-center"><strong>Net Salary</strong></td>
										<td class="no-line text-right">₹<?php echo $array['Total'];?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }}?>
	<button onclick="printDiv('print')" class="btn btn-lg btn-default">Print</button><br><br>
	<div class="well well-lg text-center">
		<h1>Previous Payslips</h1>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel-group" id="accordion">
				<?php
					$sql = "SELECT DISTINCT Doe FROM salary WHERE Doe != '".$salgen."' AND UserID=".$sessionid;
					$res = mysqli_query( $db, $sql );
					
					if( !is_bool($res) )
					{
						while($array = mysqli_fetch_array($res))
						{
				?>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo date('d-m-Y', $array['Doe']);?>"><?php echo date('d-m-Y', $array['Doe']);?></a>
					  </h4>
					</div>
					<div id="collapse<?php echo date('d-m-Y', $array['Doe']);?>" class="panel-collapse collapse">
					  <div class="panel-body">
						<?php
							$sql1 = "SELECT * FROM salary WHERE Doe = '".$array['Doe']."' AND UserID =".$sessionid;
							$res1 = mysqli_query( $db, $sql1 );
							
							if( !is_bool($res1) )
							{
								while($array1 = mysqli_fetch_array($res1))
								{
									$sql2 = "SELECT * FROM empdet WHERE UserID = '".$array1['UserID']."'";
									$res2 = mysqli_query( $db, $sql2 );
									$array2 = mysqli_fetch_array($res2);
						?>
							<div id="print" class="well well-lg text-center">
								<div class="row">
									<div class="col-sm-12 text-center">
										<h1><img src="http://voltatech.in/logo.jpg" /> Voltatech</h1>
										<h1>Payslip</h1>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="invoice-title">
											<h3 class="pull-right">Employee No # <?php echo $array1['EmpNum'];?></h3>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-6">
												<address>
													<strong>Generation Date:</strong><br>
													<?php echo date('d-m-Y', $array1['Doe']);?><br><br>
												</address>
											</div>
											<div class="col-xs-6 text-right">
												<address>
												<strong>To:</strong><br>
													<?php echo $array2['FullName'];?><br>
													<?php echo $array2['Address'];?>
												</address>
											</div>
											<div class="col-xs-6">
												<address>
													<strong>Bank Account No:</strong><br>
													<?php echo $array2['BankNum'];?><br>
													<strong>IFSC:</strong><br>
													<?php echo $array2['Ifsc'];?><br><br>
												</address>
											</div>
											<div class="col-xs-6 text-right">
												<address>
												<strong>Leaves</strong><br>
													Unpaid Leaves : <?php echo $array1['Leaves'];?>
												</address>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-default">
											<div class="panel-heading text-center">
												<h3 class="panel-title"><strong>Salary Summary</strong></h3>
											</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-condensed">
														<thead>
															<tr>
																<td><strong>Earnings</strong></td>
																<td class="text-center"><strong>Amount</strong></td>
																<td class="text-center"><strong>Deductions</strong></td>
																<td class="text-right"><strong>Amount</strong></td>
															</tr>
														</thead>
														<tbody>
															<!-- foreach ($order->lineItems as $line) or some such thing here -->
															<tr>
																<td>Basic</td>
																<td class="text-center">₹<?php echo $array1['Basic'];?></td>
																<td class="text-center">Leaves</td>
																<td class="text-right">₹<?php echo $array1['LeavePrice'];?></td>
															</tr>
															<tr>
																<td>HRA</td>
																<td class="text-center">₹<?php echo $array1['Hra'];?></td>
																<td class="text-center">Provident Fund</td>
																<td class="text-right">₹<?php echo $array1['Pf'];?></td>
															</tr>
															<tr>
																<td>Conveyance Allowance</td>
																<td class="text-center">₹<?php echo $array1['Conveyance'];?></td>
																<td class="text-center">ESI</td>
																<td class="text-right"><?php echo $array1['Esi'];?></td>
															</tr>
															<tr>
																<td>Special Allowance</td>
																<td class="text-center">₹<?php echo $array1['SpecialA'];?></td>
																<td class="text-center">Professional Tax</td>
																<td class="text-right">₹<?php echo $array1['ProfTax'];?></td>
															</tr>
															<tr>
																<td class="thick-line"><strong>Gross Salary</strong></td>
																<td class="thick-line">₹<?php echo $array1['Gross'];?></td>
																<td class="thick-line text-center"><strong>Gross Deduction</strong></td>
																<td class="thick-line text-right">₹<?php echo ($array1['Pf']+$array1['Esi']);?></td>
															</tr>
															<tr>
																<td class="no-line"></td>
																<td class="no-line"></td>
																<td class="no-line text-center"><strong>Net Salary</strong></td>
																<td class="no-line text-right">₹<?php echo $array1['Total'];?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php }}?>
					  </div>
					</div>
				  </div>
				<?php }}?>
				</div>
			</div>
		</div>
	</div>
<!--payslip-->
<?php }?>
</div>

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script>
$(function() {
$('input[name="date"]').daterangepicker(
{
    locale: {
      format: 'DD-MM-YYYY'
    },
        showDropdowns: true
});
});
</script>