<?php
	/* Logged in session handling*/
	require "includes/validateLogin.php";
	//include "includes/header.php"; //include top header part
	$webaccount = isset($_SESSION["webaccount"])? $_SESSION["webaccount"]:"unknown";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require "includes/header.php" ?>
</head>
<body style="background:aliceblue">	
	<?php require "includes/navbar.php" ?>
	<div class="container" style="margin-top:60px;">
		<div class="contact-wrapper form-horizontal" style="border:2px solid lightgray;border-radius:5px;padding:10px 20px 20px 40px;margin-bottom:30px;">
			<h4 class="text-primary text-uppercase" style="margin-left:-15px"><u>Contact Details</u></h4>
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<div class="form-group" style="margin-bottom:5px;padding-bottom:7px;">
							<label class="col-sm-3" for="cfirstname">First name<small>*</small></label>
							<div class="col-sm-8">
								<input type="text" id="cfirstname" class="form-control" autofocus>
							</div>
							<div class="col-sm-1"></div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3" for="cphone">Phone</label>
							<div class="col-sm-8">
								<input type="contact" id="cphone" class="form-control">
							</div>							
							<div class="col-sm-1"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3" for="cemail">E-mail<small>*</small></label>
							<div class="col-sm-8">
								<input type="email" id="cemail" class="form-control">
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3" for="cfax">Fax</label>
							<div class="col-sm-8">
								<input type="text" id="cfax" class="form-control">
							</div>
							<div class="col-sm-1"></div>
						</div>
					</div>					
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="form-group">
							<label class="col-sm-3" for="csurname">Surname</label>
							<div class="col-sm-8">
								<input type="text" id="csurname" class="form-control">
							</div>
						</div>					
						<div class="form-group" style="margin-bottom:15px;">
							<label class="col-sm-3" for="cfunction">Function</label>
							<div class="col-sm-8">
								<input type="text" id="cfunction" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3" for="cwebsite">Website</label>
							<div class="col-sm-8">
								<input type="text" id="cwebsite" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3" for="cfaxoneproof">Fax number on e-proof</label>
							<div class="col-sm-8">
								<input type="text" id="cfaxoneproof" class="form-control">
							</div>
						</div>
					</div>					
				</div>			
			</div>
			<h4 class="text-primary text-uppercase" style="margin-left:-15px"><u>Update Password</u></h4>
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<div class="form-group">
							<label class="col-sm-3" for="upuserid">User ID<small>*</small></label>
							<div class="col-sm-8">
								<input type="text" id="upuserid" class="form-control" autocomplete="off">
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3" for="uppassword">Password<small>*</small></label>
							<div class="col-sm-8">
								<input type="password" id="uppassword" class="form-control" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div><br>
			<h4 class="text-primary text-uppercase" style="margin-left:-15px"><u>Settings and Preferences</u></h4>
			<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="form-group">
						<label class="col-sm-3" for="deliveryadd">Select Address</label>
						<div class="col-sm-9">
							<select id="deliveryadd" class="form-control">
								<!-- f_customerAddress() -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3"  for="snwdisclaimer">Discalimer</label>
						<div class="col-sm-9">
							<textarea id="snwdisclaimer" rows="3" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">				
			</div>
			<div class="col-sm-3">
				<button type="button" class="btn btn-primary btn-lg btn-block" onclick="f_addContact()">Add Contact</button>
			</div>
		</div>
		</div>
	</div>
	</nav>
</body>
</html>
