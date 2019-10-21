<?php
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

<?php
  $fullname = "";
  if(isset($_SESSION["login_officer"])) {
    $fullname = $_SESSION["login_fullname"];
	$username = $_SESSION["login_officer"];
  }
  else {
    session_destroy();
    header('Location: http://localhost/restapp/login.php');
  }
?>

    <header id="header">
      <!-- Start Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="menuoff.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
			<li class="nav-item">
              <a class="nav-link" href="viewoff.php">View Applications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="allocate.php">Allocate Housing</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
			  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="logout.php">Logout</a>
			  </div>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </header>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $area = $_POST['area'];
  $numUnits = $_POST['numUnits'];
  $sizePerUnit = $_POST['sizePerUnit'];
  $monthlyRental = $_POST['monthlyRental'];
  if (!empty($name) && !empty($address) && !empty($area) && !empty($numUnits) && !empty($sizePerUnit) && !empty($monthlyRental)) {
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
		$INSERT = "INSERT Into residence (name, address, area, numUnits, sizePerUnit, monthlyRental) values(?, ?, ?, ?, ?, ?)";
		//prepare statement
		$stmt = $conn->prepare($INSERT);
		$stmt->bind_param("ssiiii", $name, $address, $area, $numUnits, $sizePerUnit, $monthlyRental);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		header('Location: http://localhost/restapp/menuoff.php');
	}
}
else {
	$msg = "Please fill all fields!";
	die();
}
}
?>	
    <!-- Start Set Residence -->
	<section id="section-form" class="container-fluid">
	  <center><h2 class="pb-3 pt-2 border-bottoms">Set Residence</h2></center>
	  <div class="form-style">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
		<fieldset>
			<legend><span class="number">1</span>Name</legend>
			<input type="text" class="form-control" id="inputName" placeholder="Name" name="name" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">2</span>Address</legend>
			<input type="text" class="form-control" id="inputAddress" placeholder="Address" name="address" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">3</span>Area</legend>
			<select class="custom-select" name="area" required>
				<option value="">Area</option>
				<option value="1">Selangor</option>
				<option value="2">Kuala Lumpur</option>
				<option value="3">Johor</option>
				<option value="4">Penang</option>
				<option value="5">Perak</option>
				<option value="6">Negeri Sembilan</option>
				<option value="7">Melaka</option>
				<option value="8">Pahang</option>
				<option value="9">Sabah</option>
				<option value="10">Sarawak</option>
				<option value="11">Kedah</option>
				<option value="12">Putrajaya</option>
				<option value="13">Kelantan</option>
				<option value="14">Terengganu</option>
				<option value="15">Perlis</option>
				<option value="16">Labuan</option>
			</select>      
		</fieldset>
		<fieldset>
			<legend><span class="number">4</span>Number of Unit</legend>
			<input type="number" class="form-control" id="inputnoUnit" placeholder="Number of Unit" name="numUnits" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">5</span>Size Per Unit</legend>
			<input type="number" class="form-control" id="inputsizeUnit" placeholder="Size Per Unit" name="sizePerUnit" required>
		</fieldset>
		<fieldset>
			<legend><span class="number">6</span>Monthly Rental</legend>
			<input type="number" class="form-control" id="inputmRental" placeholder="Monthly Rental" name="monthlyRental" required>
		</fieldset>
		<input type="submit" value="Submit" />
		</form>
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
	<!-- End Set Residence -->
      
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