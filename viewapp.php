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
    <link rel="stylesheet" href="tableshort.css" type="text/css">
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
				if(empty($row["staffID"]))
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
        <a class="navbar-brand" href="menuapp.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="viewres.php">View Residence</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
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
  // Checking and setting session for the button clicked
  
  $chosen = "";
  if (isset($_REQUEST['appeal'])) {
	$aKey = array_keys($_REQUEST['appeal']);
	$chosen = array_pop($aKey); 
    $_SESSION["chosen_application"] = $chosen;
	header('Location: http://localhost/restapp/appealform.php');
  }
?>

<?php
  //Setting up the value shown in list of residences with appeal capability
  
  $submitappID_array = array();
  $residenceID_array = array();
  $residence_array = array();
  $requiredDate_array = array();
  $endDate_array = array();
  $status_array = array();
  $roomID_array = array();
  $reason_array = array();
  $roomname_array = array();
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
	$SELECT = "SELECT * From submitapp Where userID = '".$loginuserID."'";
	//prepare statement
	$stmt = $conn->query($SELECT);
	if ($stmt->num_rows > 0)
		while ($row = $stmt->fetch_assoc()) {
		  array_push($submitappID_array, $row["submitappID"]);
		  array_push($residenceID_array, $row["residenceID"]);
		  array_push($requiredDate_array, $row["requiredDate"]);
		  array_push($endDate_array, $row["endDate"]);
		  array_push($status_array, $row["status"]);
		  if (!empty($row["roomID"]))
			array_push($roomID_array, $row["roomID"]);
		  else
			array_push($roomID_array, "");
		  if (!empty($row["rejectionNote"]))
			array_push($reason_array, $row["rejectionNote"]);
		  else
			array_push($reason_array, "");
		}
	$stmt->close();
	for ($i = 0; $i < count($submitappID_array); $i = $i + 1) {
		$value = $residenceID_array[$i];
		$SELECT = "SELECT name From residence Where residenceID = '".$value."'";
		$stmt = $conn->query($SELECT);
		if ($stmt->num_rows > 0)
			while ($row = $stmt->fetch_assoc()) {
				array_push($residence_array, $row["name"]);
			}
		$stmt->close();
	}
	for ($i = 0; $i < count($submitappID_array); $i = $i + 1) {
		if ($roomID_array[$i] != "") {
			$value = $roomID_array[$i];
			$SELECT = "SELECT roomName From roomname Where roomNameID = '".$value."'";
			$stmt = $conn->query($SELECT);
			if ($stmt->num_rows > 0)
				while ($row = $stmt->fetch_assoc()) {
					array_push($roomname_array, $row["roomName"]);
				}
			$stmt->close();
		}
		else
			array_push($roomname_array, "");
	}
  }
  $conn->close();
?>



    <!-- Start Allocate Housing -->
    <section id="section-table" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">View Applications</h2></center>
	  <div class="table-responsive">
	  <table class="table" id="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">No</th>
			  <th scope="col">Residence</th>
			  <th scope="col">Required Date</th>
			  <th scope="col">End Date</th>
			  <th scope="col">Status</th>
			  <th scope="col">Room Name</th>
			  <th scope="col">Reason</th>
			  <th scope="col">Appeal</th>
			</tr>
		  </thead>
		  <tbody>

<?php
  //Looping for the content of the application list
  for ($i = 0; $i < count($submitappID_array); $i=$i+1) {
?>

<?php
  //Setting the appeal button only for the rejected status
  if ($status_array[$i] == "REJECTED") {
?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<?php
  }
?>
			<tr>
			  <th><?php echo $i+1; ?></th>
			  <td><?php echo $residence_array[$i]; ?></td>
			  <td><?php echo $requiredDate_array[$i]; ?></td>
			  <td><?php echo $endDate_array[$i]; ?></td>
			  <td><?php echo $status_array[$i]; ?></td>
			  <td><?php echo $roomname_array[$i]; ?></td>
			  <td><?php echo $reason_array[$i]; ?></td>
<?php
  if ($status_array[$i] == "REJECTED") {
?>
			  <td><input type="submit" class="form-control" name="appeal[<?php echo $submitappID_array[$i]; ?>]" value="Appeal" /></td>
<?php
  }
?>
			</tr>
<?php
  if ($status_array[$i] == "REJECTED") {
?>
			</form>
<?php
  }
  }
?>

		  </tbody>
		</table>
		</div>
    </section>
    <!-- End Allocate Housing -->
      
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