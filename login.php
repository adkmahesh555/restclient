<?php 
	setcookie('auth', '', time()-10000);
	session_start();
	session_destroy();
?>

<!doctype html>
<html lang="en">
<head>
	<title>PF Rest Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">	
	<link rel="stylesheet" type="text/css" href="css/lib/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body style="background:aliceblue">
	<div class="container-fluid" style="background:none;height:100px;">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
			<div class="col-lg-4 col-md-5 col-sm-6 col-xs10">
				<div class="jumbotron" style="margin-top:70px;border:2px solid skyblue;">					
					<form class="form" action="authenticate.php" method="post">
						<h2 class="text-info">PF Rest Services<small><abbr title="Client Application to test Webservices"> app</abbr></small></h2>
						<label for="username">Webaccount</label>
						<?php 
							if(isset($_GET["error"])) {
								echo '<span class="text-danger" style="float:right"><b>Login Error!! </b></span>';
							}
						?>
						<input type="text" class="form-control" name="username" id="username" autofocus required>
						<br>
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" required><br>
						<button class="form-control btn btn-info" type="submit">Login</button>
					</form>
				</div>
			</div>
			<div class="col-lg-4 col-md-3 col-sm-3 col-xs-1"></div>
		</div>
	</div>
</body>

</html>