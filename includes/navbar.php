<nav class="navbar navbar-inverse navbar-fixed-top navbar-custom">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#pfrestNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand">PF Rest Application</a>				
		</div>
		<div class="collapse navbar-collapse" id="pfrestNavbar">
			<ul class="nav navbar-nav">				
				<li <?php if(basename($_SERVER["PHP_SELF"])=="dashboard.php")  echo "class='active'"; ?>>
					<a href="dashboard.php">
						<span class="glyphicon glyphicon-home"></span> Home
					</a>
				</li>
				<li <?php if(basename($_SERVER["PHP_SELF"])=="orderinquiry.php") echo "class='active'"; ?>>
					<a href="orderinquiry.php" title="Order Inquiry">Order Inquiry</a>
				</li>
				<li <?php if(basename($_SERVER["PHP_SELF"])=="invoices.php") echo "class='active'"; ?>>
					<a href="invoices.php" title="Invoices">Invoices</a>
				</li>
				<li <?php if(basename($_SERVER["PHP_SELF"])=="contacts.php") echo "class='active'"; ?>>
					<a href="contacts.php" title="Contacts Setting">Personal Settings</a>
				</li>
				<!--<li <?php if(basename($_SERVER["PHP_SELF"])=="address.php") echo "class='active'"; ?>>
					<a href="#" title="Customer Address">Address</a>
				</li>-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#" title="Webaccount" data-toggle="tooltip" data-placement="bottom">
						<span class="glyphicon glyphicon-user"></span> <?php echo $webaccount?>
					</a>
				</li>
				<li><a href="login.php">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
				<li><a href="pfrestservicedocs.html" target="_blank" title="Help documentation">Help</a></li>
				<li>
					<a href="help.php">
						<span class="glyphicon glyphicon-question-sign" title="Quick help"></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Webaccount -->
<input type="hidden" id="webaccount" value="<?php if(isset($_SESSION["webaccount"])) echo $_SESSION["webaccount"]; else echo "Unknown"; ?>">

<!-- Loading -->
<div id="dvLoading" style="display:none;"></div>
<!-- Modal for alert -->
<div class="modal fade" id="alertModal" role="dialog">
   <div class="modal-dialog">
	  <div class="modal-content">
		 <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title text-warning"></h4>
		 </div>
		 <div class="modal-body">
			<p class="text-primary"></p>
		 </div>
		 <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
		 </div>
	  </div>
   </div>
</div>
<!-- modal:end -->