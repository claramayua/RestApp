<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="form.css" type="text/css">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">

    <title>RestApp</title>
  </head>

  <body>
  <?php
	$msg = "";
	?>
    <header id="header">
      <!-- Start Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="home.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
			  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="signup.php">Sign Up</a>
				<a class="dropdown-item" href="login.php">Login</a>
			  </div>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </header>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$monthlyIncome = $_POST['monthlyIncome'];
if (!empty($username) || !empty($password) || !empty($fullname) || !empty($email) || !empty($monthlyIncome)) {
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "restapp";
	//create connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if (mysqli_connect_error()) {
		$msg = "Connection Error!";
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	}
	else {
		$SELECT = "SELECT email From user Where email = ? Limit 1";
		$INSERT = "INSERT Into user (username, password, fullname, email, monthlyIncome) values(?, ?, ?, ?, ?)";
		//prepare statement
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		if ($rnum==0) {
			$stmt->close();
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssssi", $username, $password, $fullname, $email, $monthlyIncome);
			$stmt->execute();
			header('Location: http://localhost/restapp/login.php');
		}
		else {
			$msg = "Someone already register using this email!";
		}
		$stmt->close();
		$conn->close();
	}
}
else {
	$msg = "Please fill all fields!";
	die();
}
}
?>	
    <!-- Start Sign Up -->
    <section id="section-form" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">Sign Up</h2></center>
	  <div class="form-style">		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
		<fieldset>
			<legend><span class="number">1</span>Username</legend>
			<input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username" required>		
		</fieldset>
		<fieldset>
			<legend><span class="number">2</span>Password</legend>
			<input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">3</span>Full Name</legend>
			<input type="text" class="form-control" id="inputfName" placeholder="Full Name" name="fullname" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">4</span>Email</legend>
			<input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">5</span>Monthly Income</legend>
			<input type="number" class="form-control" id="inputmIncome" placeholder="Monthly Income" name="monthlyIncome" required>
		</fieldset>
		<span class="error" style="color: red; font-family: Courier"><b><?php echo $msg;?></b></span>
		<br><br>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" id="gridCheck">
			<label class="form-check-label" for="gridCheck">
			I agree to the Terms of Use of RestApp.<br><br>
			</label>
		</div>
		<input type="submit" value="Join" />			
		</form>
		<p>
			<a href="login.php" style="color:#1abc9c"><center><b>Have an account? Click here to login.</b></center></a>
		</p>
		<script>
			function check(form)
			{

			if(form.username.value == "" || form.password.value == "" || form.fullname.value == "" || form.email.value == "" || form.mincome.value == "")
			{				
				alert("Please fill all fields!")
				return false;
			}
			}
		</script>
	  </div>
    </section>
    <!-- End Sign Up -->
      
    <!-- Start Footer -->
	<div class="footer">
		<small><i>Copyright &copy; 2019 RestApp</i></small>
	</div>
	<!-- End Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/14.2.1/smooth-scroll.min.js"></script>
    <script type="text/javascript">
      $(function(){
          var scroll = new SmoothScroll('a[href*="#section"]');
      });
    </script>
    <script type="text/javascript">
      $(window).on('scroll', function() {
        if ($(window).scrollTop()){
          $('nav.navbar').addClass('navcolor');
        }
        else {
          $('nav.navbar').removeClass('navcolor');
        }
      })
    </script>
  </body>
</html>