<title><?php 
	if	(basename($_SERVER["PHP_SELF"])=="dashboard.php")  echo 'PF Rest Home';
	else if (basename($_SERVER["PHP_SELF"])=="createorder.php") echo 'Configure Order';
	else if (basename($_SERVER["PHP_SELF"])=="orderinquiry.php") echo 'Order Overview';
	else if (basename($_SERVER["PHP_SELF"])=="invoices.php") echo 'Invoices';
	else if (basename($_SERVER["PHP_SELF"])=="contacts.php") echo 'Contacts';
	else if (basename($_SERVER["PHP_SELF"])=="address.php") echo 'Address';
	else echo 'PF Rest Application';
?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">	
<link rel="stylesheet" type="text/css" href="css/lib/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<script src="js/lib/jquery-3.3.1.min.js"></script>
<script src="js/lib/bootstrap.min.js"></script>
<script src="js/lib/handlebars.min.js"></script>
<script src="js/handlebarhelpers.js"></script>
<script src="js/pfrest.js"></script>
