<?php

	session_start(); // to track the logged in user
	$upass = "";
	$username = $_POST['username'];
	$password = $_POST['password'];
	$upass = $username . ":" . $password;

	$authentication = base64_encode($upass);
	$url =  "https://wsa.pfconcept.com/test/v01/rest/PFRestService/login";

	// create a new cURL resource
	$ch = curl_init($url);
	$options = array(
			CURLOPT_RETURNTRANSFER => true,         // return web page
			CURLOPT_HEADER         => false,        // don't return headers
			CURLOPT_FOLLOWLOCATION => false,         // follow redirects
		   // CURLOPT_ENCODING       => "utf-8",           // handle all encodings
			CURLOPT_AUTOREFERER    => true,         // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 20,          // timeout on connect
			CURLOPT_TIMEOUT        => 20,          // timeout on response
			CURLOPT_POST            => 1,            // sending post data
			CURLOPT_POSTFIELDS     => "",    // this are my post vars
			CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
			CURLOPT_SSL_VERIFYPEER => false,        //
			CURLOPT_VERBOSE        => 1,
			CURLOPT_HTTPHEADER     => array(
				"Authorization: Basic $authentication",
				"Content-Type: application/json"
			)

	);

	// set URL and other appropriate options
	curl_setopt_array($ch,$options);

	// grab URL and pass it to the browser
	$data = curl_exec($ch);

	//$myfile = fopen("maheshrest.txt", "w") or die("Unable to open file!");
	//fwrite($myfile, $data);
	//fclose($myfile);

	$curl_errno = curl_errno($ch);
	$curl_error = curl_error($ch);
	//echo $curl_errno;
	//echo $curl_error;

	// close cURL resource, and free up system resources
	curl_close($ch);
	echo $data;
	$data = json_decode($data, true);
	$data = $data['response']['get_login_rsp'];
	//var_dump($data);return;

	if(!empty($data) && $data["login_rsp"][0]["status"] == "success" ){ /* Valid Login */
		$loginresp  = $data["login_rsp"][0];
		$webaccount = $loginresp["webaccount"];
		//set session variable to track loggedIn status and webaccount
		$_SESSION["loggedIn"] = true;
		$_SESSION["webaccount"] = $webaccount;
		//$_SESSION["auth"] = $authentication;

		setcookie("auth",$authentication); // set authentication in cookie
		header( 'Location: dashboard.php');
	}
	else{
		header('Location: index.php?error="authentication failed"');
	}
?>
