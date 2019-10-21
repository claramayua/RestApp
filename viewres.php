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
    <link rel="stylesheet" href="view.css" type="text/css">
	<link rel="icon" href="favicon.ico" type="image/x-con">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">

    <title>RestApp</title>
  </head>

  <body>

<?php
  $fullname = "";
  if(isset($_SESSION["login_applicant"])) {
    $fullname = $_SESSION["login_fullname"];
	$username = $_SESSION["login_applicant"];
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
              <a class="nav-link" href="viewapp.php">View Applications</a>
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

    <!-- Start View Residence -->
	<section id="section-view" class="container-fluid">
		<div id="generic_price_table">   
		<section>
				<div class="container">
					
					<!--BLOCK ROW START-->
					<div class="row">
						<div class="col-md-12">
							<!--PRICE HEADING START-->
							<div class="price-heading clearfix">
								<h1>View Residence</h1>
							</div>
							<!--//PRICE HEADING END-->
						</div>
<?php
  $name_array = array();
  $area_array = array();
  $address_array = array();
  $monthlyrental_array = array();
  $size_array = array();
  $unit_array = array();
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
	$SELECT = "SELECT * From residence";
	//prepare statement
	$stmt = $conn->query($SELECT);
	if ($stmt->num_rows > 0)
		while ($row = $stmt->fetch_assoc()) {
		  array_push($name_array, $row["name"]);
		  array_push($address_array, $row["address"]);
		  array_push($area_array, $row["area"]);
		  array_push($unit_array, $row["numUnits"]);
		  array_push($size_array, $row["sizePerUnit"]);
		  array_push($monthlyrental_array, $row["monthlyRental"]);
		}
	$stmt->close();
	$conn->close();
 }
 
 for ($i = 0; $i < count($name_array); $i=$i+3) {
   for ($j = 0; $j < 3 && ($j+$i) < count($name_array); $j++) { 
?>
						<div class="col-md-4">
						
							<!--PRICE CONTENT START-->
							<div class="generic_content clearfix">
								
								<!--HEAD PRICE DETAIL START-->
								<div class="generic_head_price clearfix">
								
									<!--HEAD CONTENT START-->
									<div class="generic_head_content clearfix">
									
										<!--HEAD START-->
										<div class="head_bg"></div>
										<div class="head">
											<span><?php echo $name_array[$i+$j] ?></span>
										</div>
										<!--//HEAD END-->
										
									</div>
									<!--//HEAD CONTENT END-->
									
									<!--PRICE START-->
									<div class="generic_price_tag clearfix">	
										<span class="price">
											<span class="sign">RM</span>
											<span class="currency"><?php echo $monthlyrental_array[$i+$j] ?></span>
											<span class="month">/MONTH</span>
										</span>
									</div>
									<!--//PRICE END-->
									
								</div>                            
								<!--//HEAD PRICE DETAIL END-->
								
								<!--FEATURE LIST START-->
								<div class="generic_feature_list">
									<ul>
										<li><span><?php echo $address_array[$i+$j] ?></span></li>
										<li><span><?php echo $size_array[$i+$j] ?></span> sq. ft.</li>
										<li><span>Available Unit:</span> <?php echo $unit_array[$i+$j] ?> units</li>
									</ul>
								</div>
								<!--//FEATURE LIST END-->
								
								<!--BUTTON START-->
								<div class="generic_price_btn clearfix">
									<a class="" href="submitapp.php">Apply</a>
								</div>
								<!--//BUTTON END-->
								
							</div>
							<!--//PRICE CONTENT END-->
								
						</div>						
						
					<!--//BLOCK ROW END-->
<?php
    }
?>

                        <div class="col-md-12">
							<div class="price-heading clearfix">
							  <br><br>
							</div>
						</div>
						
<?php
  }
?>  


				</div>
			</section>
		</div>		
	</section>
	<!-- End View Residence -->

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
