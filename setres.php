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
    <link rel="stylesheet" href="form.css" type="text/css">
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
				if(!empty($row["staffID"]))
					$loginfullname = $_SESSION["login_fullname"];
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
        <a class="navbar-brand" href="menuoff.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
			<li class="nav-item">
              <a class="nav-link" href="viewressetroomname.php">Set Room Name</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="allocate.php">Application & Allocation</a>
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
//Get the data from the input form including image file
//Save into the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$area = $_POST['area'];
	$numUnits = $_POST['numUnits'];
	$sizePerUnit = $_POST['sizePerUnit'];
	$monthlyRental = $_POST['monthlyRental'];
  
	$target_dir = "pictures/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	echo $target_file;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	
	// Check file size
	//if ($_FILES["fileToUpload"]["size"] > 500000) {
	//	echo "Sorry, your file is too large.";
	//	$uploadOk = 0;
	//}
	
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	//if ($uploadOk == 0) {
	//	echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	//} else {
	//	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	//		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	//	} else {
	//		echo "Sorry, there was an error uploading your file.";
	//	}
	//}
  
	if (!empty($name) && !empty($address) && !empty($area) && !empty($numUnits) && !empty($sizePerUnit) && !empty($monthlyRental) && $uploadOk == 1) {
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
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
			$INSERT = "INSERT Into residence (name, address, area, numUnits, sizePerUnit, monthlyRental, picture) values(?, ?, ?, ?, ?, ?, ?)";
			//prepare statement
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssiiiis", $name, $address, $area, $numUnits, $sizePerUnit, $monthlyRental, $target_file);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			header('Location: http://localhost/restapp/menuoff.php');
		}
	}
	else {
		$msg = "Please fill all fields and check the inputs!";
		die();
	}
}
?>
	
    <!-- Start Set Residence -->
	<section id="section-form" class="container-fluid">
	  <center><h2 class="pb-3 pt-2 border-bottoms">Set Residence</h2></center>
	  <div class="form-style">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated" enctype="multipart/form-data">
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
		<fieldset>
			<legend><span class="number">7</span>Picture</legend>
			<input type="file" class="form-control" id="fileToUpload" placeholder="Picture" name="fileToUpload" required>
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