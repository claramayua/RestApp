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
        <a class="navbar-brand" href="menuoff.html"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="allocate.php">Application & Allocation</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="account.html" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
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
  //Getting the application to be shown
  $roomname_array = array();
  $roomnameID_array = array();
  $chosen = $_SESSION['chosen_application'];
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
	$SELECT = "SELECT userID, residenceID, requiredDate, endDate, roomID From submitapp Where submitappID = ? Limit 1";
	//prepare statement
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("i", $chosen);
	$stmt->execute();
	$stmt->store_result();
	$rnum = $stmt->num_rows;
	if ($rnum > 0) {
		$stmt->bind_result($userID, $residenceID, $requiredDate, $endDate, $roomID);
		$stmt->fetch();
	}
	$stmt->close();
	$SELECT = "SELECT fullname, monthlyIncome From user Where userID = ? Limit 1";
	//prepare statement
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("i", $userID);
	$stmt->execute();
	$stmt->store_result();
	$rnum = $stmt->num_rows;
	if ($rnum > 0) {
		$stmt->bind_result($fullname, $monthlyIncome);
		$stmt->fetch();
	}
	$stmt->close();
	$SELECT = "SELECT name From residence Where residenceID = ? Limit 1";
	//prepare statement
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
	$status = 1;
	$SELECT = "SELECT roomNameID, roomName From roomname Where residenceID = ? AND status = ?";
	//prepare statement
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("ii", $residenceID, $status);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
		array_push($roomname_array, $row["roomName"]);
		array_push($roomnameID_array, $row["roomNameID"]);
    }
	$stmt->close();
	$conn->close();
  }
?>

<?php
//Get the data from the input form
//Update the room and status into the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$roomnameID = $_POST['roomname'];
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
		$UPDATE = "UPDATE submitapp SET roomID = '".$roomnameID."', status='APPROVED' WHERE submitappID = '".$chosen."'";
		//prepare statement
		$conn->query($UPDATE);
		$UPDATE = "UPDATE roomname SET userID = '".$userID."', endDate = '".$endDate."', status='2' WHERE roomNameID = '".$roomnameID."'";
		//prepare statement
		$conn->query($UPDATE);
		header('Location: http://localhost/restapp/allocate.php');
	}
	$conn->close();
}
?>

    <!-- Start Allocate Housing Form -->
    <br>
	<section id="section-form" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">Room Allocation Form</h2></center>
	  <div class="form-style">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
		<fieldset>
			<legend><span class="number">1</span>Residence Name</legend>
			<pre><?php echo $name; ?></pre>      
		</fieldset>
		<fieldset>
			<legend><span class="number">2</span>Applicant Name</legend>
			<pre><?php echo $fullname; ?></pre>      
		</fieldset>
		<fieldset>
			<legend><span class="number">3</span>Monthly Income</legend>
			<pre><?php echo $monthlyIncome; ?></pre>
		</fieldset>
		<fieldset>
			<legend><span class="number">4</span>Required Date</legend>
			<pre><?php echo $requiredDate; ?></pre>
		</fieldset>
		<fieldset>
			<legend><span class="number">5</span>End Date</legend>
			<pre><?php echo $endDate; ?></pre>
		</fieldset>
		<fieldset>
			<legend><span class="number">6</span>Room Name</legend>
			<select name="roomname" class="custom-select" required>
				<option value="">Room Name</option>
<?php
	for ($i = 0; $i < count($roomname_array); $i = $i + 1) {
?>
				<option value="<?php echo $roomnameID_array[$i]; ?>"><?php echo $roomname_array[$i]; ?></option>
<?php
	}
?>
			</select>      
		</fieldset>
		<input type="submit" value="Submit" />
		</form>
		<script>
			function check(form)
			{

			if(form.rid.value != "" && form.name.value != "" && form.uno.value != "" && form.fdate.value != "")
			{
				alert("Submit Allocate Housing Form Successfully!")
				window.location = "allocate.html";
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
    <!-- End Allocate Housing Form -->
      
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