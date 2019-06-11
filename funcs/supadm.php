<div class="container text-center">
<!--Headder-->
	<div class="jumbotron">
		<h1>Voltatech</h1>
		<h4>Welcome : rohith</h4>
		<ul class="nav nav-tabs">
		  <li <?php if($page == 'home') echo 'class="active"';?>><a href="?page=home">Home</a></li>
		  <li <?php if($page == 'attandance') echo 'class="active"';?>><a href="?page=attandance">Attandance</a></li>
		  <li <?php if($page == 'attandancetrack') echo 'class="active"';?>><a href="?page=attandancetrack">Attandance Track</a></li>
		  <li <?php if($page == 'leaves') echo 'class="active"';?>><a href="?page=leaves">Leaves</a></li>
		  <li <?php if($page == 'employee') echo 'class="active"';?>><a href="?page=employee">Employees</a></li>
		  <li <?php if($page == 'salary') echo 'class="active"';?>><a href="?page=salary">Salary</a></li>
		  <li <?php if($page == 'profile') echo 'class="active"';?>><a href="?page=profile">Profile</a></li>
		  <li><a href="funcs/logout.php">Logout</a></li>
		</ul>
	</div>
<!--Headder-->

<?php if($page == null || $page == 'home') {?>
<!--Home-->
<div class="row">
	<div class="col-sm-12">
		<div class="well well-lg text-center">
			<h1>Branches</h1>
			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline" action="funcs/addbranch.php" method="post" autocomplete="off">
					  <div class="form-group">
						<label>Branch</label>
						<input type="text" class="form-control" name="branchname" placeholder="Branch Name" required>
						<input type="text" class="form-control" name="branch" placeholder="Branch City" required>
						<button type="submit" class="btn btn-danger">Add</button>
					  </div>
					</form>
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-12 text-center">
					<table style="background:white;" class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Branch Id</th>
								<th>Branch Name</th>
								<th>Branch</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$sql = "SELECT * FROM branches";
							$res = mysqli_query( $db, $sql );
							
							if( !is_bool($res) )
							{
								while($array = mysqli_fetch_array($res))
								{
									echo '<tr>
												<td>'.$array['ID'].'</td>
												<td>'.$array['BranchName'].'</td>
												<td>'.$array['Branch'].'</td>
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
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="well well-lg text-center">
			<h1>Non working days this month</h1>
				<div class="row">
					<div class="col-sm-12">
						<form action="funcs/addnondays.php" method="post" autocomplete="off">
						  <div class="form-group">
							<div class="row">
								<div class="col-sm-3">
									<label>Add Non Working days</label>
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
						</form><br>
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
		</div>
	</div>
	<div class="col-sm-6">
		<div class="well well-lg text-center">
			<h1>Attandance Today</h1>
			<?php $sql = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'A'";
				$res = mysqli_query( $db, $sql );
				$array = mysqli_fetch_array($res);
				echo '<h6>No of staff absent: '.$array['COUNT(*)'].'</h6>';
				$sql = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'P'";
				$res = mysqli_query( $db, $sql );
				$array = mysqli_fetch_array($res);
				echo '<h6>No of staff present: '.$array['COUNT(*)'].'</h6>';?>
		</div>
	</div>
</div>
<!--Home-->
<?php }?>

<?php if($page == 'attandance') {?>
<!--attandance-->
	<div class="well well-lg text-center">
		<h1>Attandance</h1>
		<div class="row">
		<?php 
			$sql = "SELECT DISTINCT BranchID FROM attandance";
			$res = mysqli_query( $db, $sql );
			
			if( !is_bool($res) )
			{
				while($array = mysqli_fetch_array($res))
				{
					$sql1 = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'A' AND BranchID=".$array['BranchID'];
					$res1 = mysqli_query( $db, $sql1 );
					$array1 = mysqli_fetch_array($res1);
					echo '<div class="col-sm-6">
							<div class="well text-center">
								<h4>Bangalore</h4>
								<h6>No of staff presents: '.$array1['COUNT(*)'].'</h6>';
					$sql2 = "SELECT COUNT(*) FROM attandance WHERE DAY(FROM_UNIXTIME(Doe)) = DAY(CURRENT_DATE()) AND Att = 'P' AND BranchID=".$array['BranchID'];
					$res2 = mysqli_query( $db, $sql2 );
					$array2 = mysqli_fetch_array($res2);
					echo '<h6>No of staff absent: '.$array2['COUNT(*)'].'</h6>
							</div>
						</div>';
				}
			}
		?>
		</div>
	</div>
<!--attandance-->
<?php }?>

<?php if($page == 'attandancetrack') {?>
<!--attandancetrack-->
<script>
function getTrack() {
var bid = $('#branch').val();
var date = $('#date').val();
    if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
		$('#atttrack').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		$('#atttrack').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("atttrack").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","funcs/atttrack.php?bid="+bid+"&date="+date,true);
	xmlhttp.send();
}
</script>
<div class="well well-lg text-center">
	<h1>Attandance Track</h1>
	<div class="row">
		<div class="col-sm-12">
			<form class="form-inline" autocomplete="off">
			  <div class="form-group">
				<label>track</label>
				<select class="form-control" id="branch" required>
					<option value="">Select Branch</option>
					<?php
						$sql = "SELECT * FROM branches";
						$res = mysqli_query( $db, $sql );
						
						if( !is_bool($res) )
						{
							while($array = mysqli_fetch_array($res))
							{
								echo '<option value="'.$array['ID'].'">'.$array['ID'].'-'.$array['BranchName'].'/'.$array['Branch'].'</option>';
							}
						}
					?>
				</select>
				<input type="text" class="form-control" id="date" value="" required>
				<a onclick="getTrack()" class="btn btn-danger">Track</a>
			  </div>
			</form>
		</div>
	</div><br>
	<div class="row">
		<div id="atttrack" class="col-sm-12 text-center"></div>
	</div>
</div>
<!--attandancetrack-->
<?php }?>

<?php if($page == 'leaves') {?>
<!--leaves-->
<div class="well well-lg text-center">
	<h1>Leaves</h1>
	<div class="row">
		<div class="col-sm-12 text-center">
			<table style="background:white;" class="table table-bordered text-center">
				<thead>
					<tr>
						<th>EmpNum</th>
						<th>Reason</th>
						<th>From - To</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sql = "SELECT * FROM leaves ORDER BY Doe DESC";
					$res = mysqli_query( $db, $sql );
					
					if( !is_bool($res) )
					{
						while($array = mysqli_fetch_array($res))
						{
							echo '<tr>
										<td>'.$array['EmpNum'].'</td>
										<td>'.$array['Reason'].'</td>
										<td>'.$array['FromDT'].' - '.$array['ToDT'].'</td>
										<td><a href="funcs/delleave.php?id='.$array['ID'].'"><i class="fa fa-trash" aria-hidden="true"></i></td>
									</tr>';
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--leaves-->
<?php }?>

<?php if($page == 'employee') {?>
<!--employees-->
	<div class="well well-lg text-center">
		<h1>Employees</h1>
			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline" action="funcs/addemp.php" method="post" autocomplete="off">
					  <div class="form-group">
						<label>Add Employee</label>
						<input type="text" class="form-control" name="enum" placeholder="Employee Number" required>
						<input type="number" class="form-control" name="gsal" placeholder="Gross Salary" required>
						<select class="form-control" name="adm" required>
							<option value="">Admin/Employee</option>
							<option value="emp">Employee</option>
							<option value="admin">Admin</option>
						</select>
						<select class="form-control" name="branch" required>
							<option value="">Select Branch</option>
							<?php
								$sql = "SELECT * FROM branches";
								$res = mysqli_query( $db, $sql );
								
								if( !is_bool($res) )
								{
									while($array = mysqli_fetch_array($res))
									{
										echo '<option value="'.$array['ID'].'">'.$array['ID'].'-'.$array['BranchName'].'/'.$array['Branch'].'</option>';
									}
								}
							?>
						</select>
						<button type="submit" class="btn btn-danger">Add</button>
					  </div>
					</form>
				</div>
			</div><br>
		<table id="emptable" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>EmpID</th>
					<th>Name</th>
					<th>Position</th>
					<th>Office</th>
					<th>Gross Salary</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>EmpID</th>
					<th>Name</th>
					<th>Position</th>
					<th>Office</th>
					<th>Gross Salary</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</tfoot>
			<tbody>
			<?php
				$sql = "SELECT A.ID,A.EmpNum,A.UserName,A.IsAdmin,B.BranchName,B.Branch,A.Gsal,A.Status FROM employee A,branches B WHERE B.ID = A.BranchID";
				$res = mysqli_query( $db, $sql );
				
				if( !is_bool($res) )
				{
					while($array = mysqli_fetch_array($res))
					{
						echo '<tr>
								<td>'.$array['EmpNum'].'</td>
								<td>'.$array['UserName'].'</td>
								<td>'.$array['IsAdmin'].'</td>
								<td>'.$array['BranchName'].'/'.$array['Branch'].'</td>
								<td>'.$array['Gsal'].'</td>
								<td>'.$array['Status'].'</td>
								<td><a href="" data-toggle="modal" data-target="#myModal'.$array['ID'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
								<td><a href="funcs/delemp.php?id='.$array['ID'].'"><i class="fa fa-trash" aria-hidden="true"></i></td>
							</tr>
							<!-- Modal -->
							<div id="myModal'.$array['ID'].'" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Edit</h4>
								  </div>
								  <div class="modal-body">
									<form action="funcs/editemp.php" method="post">
									  <div class="form-group">
										<label for="email">Employee Num:</label>
										<input type="hidden" class="form-control" value="'.$array['ID'].'">
										<input disabled="disabled" class="form-control" value="'.$array['EmpNum'].'">
									  </div>
									  <div class="form-group">
										<label for="email">Gross Salary:</label>
										<input type="disabled" class="form-control" name="gsal" value="'.$array['Gsal'].'">
									  </div>
									  <div class="form-group">
										<label for="email">Gross Salary:</label>
										<select class="form-control" name="adm" required>
											<option value="'.$array['IsAdmin'].'">'.$array['IsAdmin'].'</option>
											<option value="emp">Employee</option>
											<option value="admin">Admin</option>
										</select>
									  </div>
									  <button type="submit" class="btn btn-default">Submit</button>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div>
							</div>';
					}
				}
			?>
			</tbody>
		</table>
	</div>
<!--employees-->
<?php }?>

<?php if($page == 'salary') {?>
<!--salary-->
<script>
function genSal() {
    if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
		$('#txtHint').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		$('#txtHint').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","funcs/gensal.php",true);
	xmlhttp.send();
}
</script>
	<div class="well well-lg text-center">
		<h1>Salary</h1>
		<div class="row">
			<div class="col-sm-12">
				<h4>Total Salary to be paid from Last generated to Today</h4>
				<?php include 'funcs/salcalc.php';?>
			</div>
		</div>
	</div>
	<div class="well well-lg text-center">
		<div class="row">
			<div class="col-sm-12">
				<h4>Generate Salary</h4>
				<div id="txtHint"><a onclick="genSal()" class="btn btn-lg btn-danger">Generate</a></div>
			</div>
		</div>
	</div>
<!--salary-->
<?php }?>

<?php if($page == 'profile') {?>
<!--profile-->
	<div class="well well-lg text-center">
		<h1>Profile</h1>
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<h4>Change Password</h4>
				<form action="funcs/changeadmpass.php" method="post">
				  <div class="form-group">
					<input type="password" class="form-control" name="pwd">
				  </div>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
<!--profile-->
<?php }?>
</div>


<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script>
$(document).ready(function() {
    $('#emptable').DataTable();
} );
</script>
<script>
$(function() {
$('input[name="date"]').daterangepicker(
{
    locale: {
      format: 'DD-MM-YYYY'
    },
	singleDatePicker: true,
        showDropdowns: true
});
});
</script>
<script>
$(function() {
$('input[id="date"]').daterangepicker(
{
    locale: {
      format: 'DD-MM-YYYY'
    },
        showDropdowns: true
});
});
</script>