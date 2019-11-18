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
    <link rel="stylesheet" href="table.css" type="text/css">
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
  //Getting the residence to be shown
  
  $chosen = $_SESSION["chosen_residence"];
  $originalRoomNameID_array = array();
  $originalRoomName_array = array();
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
	$SELECT = "SELECT name, numUnits From residence Where residenceID = ? Limit 1";
	//prepare statement
	$stmt = $conn->query($SELECT);
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("i", $chosen);
	$stmt->execute();
	$stmt->store_result();
	$rnum = $stmt->num_rows;
	if ($rnum > 0) {
		$stmt->bind_result($name, $numUnits);
		$stmt->fetch();
	}
	$stmt->close();
	$SELECT = "SELECT * From roomname Where residenceID = '".$chosen."'";
	//prepare statement
	$stmt = $conn->query($SELECT);
	if ($stmt->num_rows > 0)
		while ($row = $stmt->fetch_assoc()) {
		  array_push($originalRoomNameID_array, $row["roomNameID"]);
		  array_push($originalRoomName_array, $row["roomName"]);
		}
	$stmt->close();
	$conn->close();
  }
?>

<?php
//Get the data from the input form
//Save and update data into the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$flagEmpty = False;
	$roomNameID_array = array();
	$roomName_array = array();
	foreach($_POST['roomName'] as $key => $tempString) {
		array_push($roomNameID_array, $key);
		array_push($roomName_array, $tempString);
		if (empty($tempString))
			$flagEmpty = True;
	}	
  
	if ($flagEmpty == False) {
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
			for ($i = 0; $i < count($roomName_array); $i=$i+1) {
				if ($i < count($originalRoomNameID_array)) {
					$UPDATE = "UPDATE roomname SET roomName = '".$roomName_array[$i]."' WHERE roomNameID = '".$originalRoomNameID_array[$i]."'";
					//prepare statement
					$conn->query($UPDATE);
				}
				else {
					$INSERT = "INSERT Into roomname (residenceID, roomName, status) values(?, ?, ?)";
					//prepare statement
					$stmt = $conn->prepare($INSERT);
					$status = 1;
					$roomNameString = $roomName_array[$i];
					$stmt->bind_param("isi", $chosen, $roomNameString, $status);
					$stmt->execute();
					$stmt->close();	
				}
			}	
		}
		$conn->close();
		header('Location: http://localhost/restapp/menuoff.php');
	}
	else {
		$msg = "Please fill all fields and check the inputs!";
		die();
	}
}
?>

    <!-- Start Allocate Housing -->
	<section id="section-table" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">Set Room Name for <?php echo $name; ?></h2></center>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

	  <div class="table-responsive">
	  <table class="table" id="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col"></th>
			  <th scope="col"></th>
			  <th scope="col">No</th>
			  <th scope="col">Room Name</th>
			  <th scope="col"></th>
			  <th scope="col"></th>
			</tr>
		  </thead>									
		  <tbody>

<?php   
  for($i=0; $i<$numUnits; $i=$i+1) {
?>
			<tr>
			  <td></td>
			  <td></td>
			  <td><?php echo $i+1; ?></td>
<?php
  if($i < count($originalRoomNameID_array)) {
?>
			  <td><input type="text" class="form-control" id="roomName[<?php echo $i; ?>]" placeholder="input room name" name="roomName[<?php echo $originalRoomNameID_array[$i]; ?>]" value="<?php echo $originalRoomName_array[$i]; ?>" required></td>
<?php
  }
  else {
?>
			  <td><input type="text" class="form-control" id="roomName[<?php echo $i; ?>]" placeholder="input room name" name="roomName[<?php echo $i; ?>]" required></td>
<?php
  }
?>  
			  <td></td>
			  <td></td>
			</tr>

<?php
  }
?>
<!--
			<tr>
			  <td><input type="submit" class="form-control" name="save" value="Save" /></td>
			</tr>
-->
		  </tbody>		  		  
		</table>
		<input type="submit" class="form-control" name="save" value="Save" />
		</form>
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