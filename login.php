<?php
	session_start();
	if(!isset($_SESSION['empID'])) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Voltatech ~ Employee</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container text-center">
	<div class="jumbotron">
		<img src="http://voltatech.in/logo.jpg" />
		<h1>Voltatech</h1> 
		<p>Employee Portal</p> 
	</div>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<form action="funcs/signin.php" method="post" autocomplete="off">
				<div class="form-group">
					<input type="text" class="form-control" name="uname" placeholder="EmployeeID/UserName" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="pwd" placeholder="Password" required>
				</div>
					<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

</body>
</html>
<?php } else { echo header('Location: index.php');}
?>