<?php
  //Setting up session 
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="formshort.css" type="text/css">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">

    <title>RestApp</title>
  </head>

  <body>

<?php
  //Check login session whether it is an applicant or officer
  //this to make sure page is accessed manually using its url
  $loginfullname = "";
  if(isset($_SESSION["login_userID"])) {
    $loginuserID = $_SESSION["login_userID"];
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
		$SELECT = "SELECT staffID From user Where userID = '".$loginuserID."' Limit 1";
		$stmt = $conn->query($SELECT);
		if ($stmt->num_rows > 0) {
			while($row = $stmt->fetch_assoc()) {
				if(empty($row["staffID"])) {
					$loginfullname = $_SESSION["login_fullname"];
				}
				else {
					session_destroy();
					header('Location: http://localhost/restapp/login.php');
				}
			}
		}
	}		
  }
  else {
    session_destroy();
    header('Location: http://localhost/restapp/login.php');
  }
?>

    <header id="header">
      <!-- Start Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="menuapp.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="viewres.php">View Residence</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="viewapp.php">View Applications</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="account.html" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
			  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="home.php">Logout</a>
			  </div>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </header>

<?php
  //Getting the residence to be shown
  $residenceID = $_SESSION['chosen_residence'];
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
	$SELECT = "SELECT name From residence Where residenceID = ? Limit 1";
	//prepare statement
	$stmt = $conn->query($SELECT);
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("i", $residenceID);
	$stmt->execute();
	$stmt->store_result();
	$rnum = $stmt->num_rows;
	if ($rnum > 0) {
		$stmt->bind_result($name);
		$stmt->fetch();
	}
	$stmt->close();
	$conn->close();
  }
?>

<?php
//Get the data from the input form
//Save into the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$requiredDate = date('Y-m-d', strtotime($_POST['requireddate']));
	$endDate = date('Y-m-d', strtotime($_POST['endDate']));
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
		$INSERT = "INSERT Into submitapp (userID, residenceID, requiredDate, endDate, status) values(?, ?, ?, ?, ?)";
		//prepare statement
		$stmt = $conn->prepare($INSERT);
		$status = "NEW";
		$stmt->bind_param("iisss", $loginuserID, $residenceID, $requiredDate, $endDate, $status);
		$stmt->execute();
		$stmt->close();
		header('Location: http://localhost/restapp/viewres.php');
	}
	$conn->close();
}
?>

    <!-- Start Submit Application -->
    <section id="section-form" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">Submit Application for <?php echo $name; ?></h2></center>
	  <div class="form-style">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
		<fieldset>
			<legend><span class="number">1</span>Required Date</legend>
			<input type="date" class="form-control" id="inputRequiredDate" name="requireddate" value="<?php echo date("Y-m-d", strtotime('+1 day')) ?>" required>      
		</fieldset>
		</br>
		<fieldset>
			<legend><span class="number">2</span>End Date</legend>
			<input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo date("Y-m-d", strtotime('+1 month')); ?>" required>
		</fieldset>
		</br>
		<input type="submit" value="Submit" />
		</form>
		<script>
			function check(form)
			{

			if(form.reqmonth.value != "" && form.reqyear.value != "")
			{
				alert("Submit Application Successfully!")
				window.location = "viewres.html";
				return true;
			}
			else
			{
				alert("Please fill all fields!")
				return false;
			}
			}
		</script>
	  </div>
    </section>
    <!-- End Submit Application -->
      
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