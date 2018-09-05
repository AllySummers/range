<?php

$error = NULL;
$page_generate = "";

function page_generate($template) {
	if ($template === 'form') {
		echo "		<form class='text-center' method='POST' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>\n";
		echo "			<fieldset class='row'>\n";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "				<div style='margin: 0 auto;' class='form-group col-xs-12 col-sm-8 col-md-4 col-lg-4 col-xl-2'>\n";
		echo "					<label for='username'>Username: </label>\n";
		echo "					<input class='form-control' type='text' name='username' id='username' placeholder='user-1234'>\n";
		echo "				</div>\n";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "			</fieldset>\n";
		echo "			<fieldset class='row'>\n";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "				<div style='margin: 0 auto;' class='form-group col-xs-12 col-sm-8 col-md-4 col-lg-4 col-xl-2'>\n";
		echo "					<label for='password'>Password: </label>\n";
		echo "					<input class='form-control' type='text' name='password' id='password' placeholder='password'>\n";
		echo "				</div>\n";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "			</fieldset>\n";
		echo "			<input style='margin-top: 1%;' type='submit' value='Login'>\n";
		echo "		</form>\n";
	} else if ($template === 'wrong') {
		echo "		<form class='text-center' method='POST' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>\n";
		echo "			<fieldset class='row'>\n";
		echo "				<h3 style='color: red;'>Please correct your login details.</h3>";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "				<div style='margin: 0 auto;' class='form-group col-xs-12 col-sm-8 col-md-4 col-lg-4 col-xl-2'>\n";
		echo "					<label for='username'>Username: </label>\n";
		echo "					<input class='form-control' type='text' name='username' id='username' placeholder='user-1234'>\n";
		echo "				</div>\n";
		echo "				<div class='col-md-4 col-lg-4 col-xl-5 col-sm-2'></div>\n";
		echo "			</fieldset>\n";
		echo "			<fieldset class='row'>\n";
		echo "				<div class='col-md-2 col-lg-3 col-xl-3'></div>\n";
		echo "				<div style='margin: 0 auto;' class='form-group col-xs-12 col-sm-12 col-md-8 col-lg-6 col-xl-6'>\n";
		echo "					<label for='password'>Password: </label>\n";
		echo "					<input class='form-control' type='text' name='password' id='password' placeholder='password'>\n";
		echo "				</div>\n";
		echo "				<div class='col-md-2 col-lg-3 col-xl-3'></div>\n";
		echo "			</fieldset>\n";
		echo "			<span id='form-error' class='form-text'>Please enter the correct username and password.</span>\n";
		echo "			<input style='margin-top: 1%;' type='submit' value='Login'>\n";
		echo "		</form>\n";
	} else if ($template === 'show') {
		$con = mysqli_connect("localhost", "redacted", "redacted", "health_records");
		if (mysqli_connect_errno()) {
			die("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		$result = mysqli_query($con,"SELECT * FROM health_records");
		echo "		<table style='text-align: center; margin: 1% auto;' ar border='1'>\n";
		echo "			<thead>\n";
		echo "				<tr>\n";
		echo "					<th>ID</th>\n";
		echo "					<th>First Name</th>\n";
		echo "					<th>Last Name</th>\n";
		echo "					<th>Address</th>\n";
		echo "					<th>Phone Number</th>\n";
		echo "					<th>Current GP</th>\n";
		echo "					<th>Major Disease</th>\n";
		echo "				</tr>\n";
		echo "			</thead>\n";
		echo "			<tbody>\n";
		while($row = mysqli_fetch_array($result)) {
		echo "				<tr>";
		echo "					<td>" . $row['id'] . "</td>";
		echo "					<td>" . $row['first_name'] . "</td>";
		echo "					<td>" . $row['last_name'] . "</td>";
		echo "					<td>" . $row['address'] . "</td>";
		echo "					<td>" . $row['phone_number'] . "</td>";
		echo "					<td>" . $row['current_gp'] . "</td>";
		echo "					<td>" . $row['major_disease'] . "</td>";
		echo "				</tr>";
		}
		echo "			</tbody>\n";
		echo "		</table>\n";
		mysqli_close($con);
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["username"])) {
		$error = true;
	}
	else {
		$error = false;
		$username = $_POST["username"];
	}

	if (empty($_POST["password"])) {
		$error = true;
	}
	else {
		$error = false;
		$password = $_POST["password"];
	}

	if ($error === false) {
		if (md5($username) === "63a9f0ea7bb98050796b649e85481845" && md5($password) === "abc20d7bde1df257f890e152af2e3470") {
			$page_generate = "show";
		} else {
			$page_generate = "wrong";
		}
	} else if ($error === true) {
		$page_generate = "wrong";
	}
} else {
	$page_generate = "form";
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Health Records - The Range</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="stylesheet" href="css/bootswatch.css" media="screen">
	</head>
	<body style="margin: 0 auto; text-align: center;" class="container-fluid">
		<a href="http://192.168.1.3"><img src="range_logo_transparent.png" alt="The Range Logo (Transparent Background)"></a>
		<h1>Health Records</h1>
<?php page_generate($page_generate); ?>
<footer style="position: fixed; bottom: 1px; left: 0; right: 0; height: 10%;">
	<hr style="border: 0; height: 1px; background: #333; background-image: linear-gradient(to right, #ccc, #333, #ccc);">
	<em style="width: 10%; float: right;">Designed by The Range Programming Team</em>
	<em style="width: 10%; float: left;">Copyright 2018 The Range</em>
</footer>
	</body>
</html>
