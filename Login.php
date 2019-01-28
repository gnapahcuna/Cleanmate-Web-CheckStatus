<?php include('config.php') ?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<script>
    function IsEmpty(){
        if(document.forms['frm'].question.value === "")
        {
            alert("empty");
            return false;
        }
        return true;
    }
</script>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="assets/img/logo.png" alt="Klorofil Logo"></div>
								<p class="lead">Login to your account</p>
							</div>
							<form class="form-auth-small" action="check_login.php" name="frm">
								<div class="form-group">
									<label for="txtUsername" class="control-label sr-only">Email</label>
									<input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Username" onclick="return IsEmpty();">
								</div>
								<div class="form-group">
									<label for="txtPassword" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password" onclick="return IsEmpty();">
								</div><br>
								<button type="submit" class="btn btn-primary btn-lg btn-block" onclick="return IsEmpty();">LOGIN</button>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1>CLEANMATE REPORT</h1>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
