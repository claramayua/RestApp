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
    <link rel="stylesheet" href="home.css" type="text/css">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">

    <title>RestApp</title>
  </head>

  <body>
    <header id="header">
      <!-- Start Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="home.php"><b>RestApp</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="link ml-auto navbar-nav">
			<li class="nav-item">
              <a class="nav-link" href="#section-aboutus">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#section-contactus">Contact Us</a>
            </li>
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
      <div class="insideheader">
        <img class="responsive" src="welcome.png" alt="welcome">
        <center>
          <button type="button" class="btn btn-dark">
            <a href="#section-residence">View Residence</a>
          </button>
        </center>
      </div>
    </header>

    <!-- Start View Residence -->
	<section id="section-residence" class="container-fluid">
		<div id="generic_price_table">   
		<section>
				<div class="container">
					
					<!--BLOCK ROW START-->
					<div class="row">
						<div class="col-md-12">
							<!--PRICE HEADING START-->
							<div class="price-heading clearfix">
								<h1 style="color: white">View Residence</h1>
							</div>
							<!--//PRICE HEADING END-->
						</div>

<?php 
    // Setting mailer dan sending email to requester

	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\src\PHPMailer;
	use PHPMailer\src\SMTP;
	use PHPMailer\src\Exception;
	
	if(isset($_POST['submit'])){
		$to = "claramayua.cm@gmail.com"; // this is your Email address
		$from = $_POST['email']; // this is the sender's Email address
		$name = $_POST['name'];
		$subject = $_POST['subject'];
		$message = $name . " wrote the following:" . "\n\n" . $_POST['message'];
		
		

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                    	// Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = $to;                     				// SMTP username
			$mail->Password   = 'password';                             // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to

			//Recipients
			$mail->setFrom($from, 'Mailer');
			$mail->addAddress($to, 'Ni Putu Clara Mayu Agusta');     	// Add a recipient
			$mail->addReplyTo($from, $name);
			$mail->addCC($to);

			// Content
			$mail->isHTML(true);                                  		// Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;
			
			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
    }
?>

<?php
  //Setting up the value shown in list of residences without applying capability
  $residenceID_array = array();
  $name_array = array();
  $area_array = array();
  $address_array = array();
  $monthlyrental_array = array();
  $size_array = array();
  $unit_array = array();
  $picture_array = array();
  $remainedUnit_array = array();
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
		  array_push($residenceID_array, $row["residenceID"]);
		  array_push($name_array, $row["name"]);
		  array_push($address_array, $row["address"]);
		  array_push($area_array, $row["area"]);
		  array_push($unit_array, $row["numUnits"]);
		  array_push($size_array, $row["sizePerUnit"]);
		  array_push($monthlyrental_array, $row["monthlyRental"]);
		  array_push($picture_array, $row["picture"]);
		}
	$stmt->close();
	for ($i = 0; $i < count($unit_array); $i=$i+1) {
		$SELECT = "SELECT * From roomname Where residenceID = '".$residenceID_array[$i]."' AND status = '1'";
		$stmt = $conn->query($SELECT);
		array_push($remainedUnit_array, $stmt->num_rows);
	}
	$conn->close();
 }
 
 //Looping for the content of the residence list
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
											<img src=<?php echo $picture_array[$i+$j] ?> alt="Residence Image" height="200" width="300"/>
										</span>
									</div>
									<!--//PRICE END-->
									
								</div>                            
								<!--//HEAD PRICE DETAIL END-->
								
								<!--FEATURE LIST START-->
								<div class="generic_feature_list">
									<ul>
										<li><span><?php echo $address_array[$i+$j] ?></span></li>
										<li><span><?php echo $monthlyrental_array[$i+$j] ?></span> / month</li>
										<li><span><?php echo $size_array[$i+$j] ?></span> sq. ft.</li>
<?php
  //Setting the value for the units available
  if ($remainedUnit_array[$i+$j] != 0) {
?>
										<li><span><?php echo $remainedUnit_array[$i+$j] ?> out of <?php echo $unit_array[$i+$j] ?> units available.</span></li>
<?php
  }
  else {
?>
										<li><span>No more unit available.</span></li>
<?php
  }
?>
									</ul>
								</div>
								<!--//FEATURE LIST END-->
								
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

	
	  <!-- Start About Us -->
    <section id="section-aboutus">
      <div class="container">
        <center><h2 class="pb-3 pt-2 border-bottoms">ABOUT US</h2></center>
		    <div class="about">
			    <p>
			      RestApp is a global, digital advertising website specialising in property.
			      The business is innovative and values-driven, and it has a team of more than 1,600 people, united by one common goal 'to change the way the world experiences property'.
			      RestApp uses new technology to deliver innovative products and experiences to all of our users around the world.<br><br>
			      Asia is the world's fastest growing property region and remains an important part of the RestApp's global strategy.
			      The RestApp's website deliver the most comprehensive set of real estate services across South East Asia.
			      RestApp is headquartered in Kuala Lumpur, Malaysia.
			      With more than 3 million visits each month, RestApp is the market leading property portal, offering a search experience in English.
			    </p><br>
		    </div>
		    <center><h3 class="pb-3 pt-2 border-bottoms">RestApp Goals</h3></center>
        <!--first section-->
        <div class="row align-items-center how-it-works d-flex">
          <div class="col-2 text-center bottom d-inline-flex justify-content-center align-items-center">
            <div class="circle font-weight-bold">1</div>
          </div>
          <div class="col-6">
            <p></p>
            <h5>THIRD</h5>
			      <p>LIVE HAPPILY IN THE RESIDENCE</p>
          </div>
        </div>
        <!--path between 1-2-->
        <div class="row timeline">
          <div class="col-2">
            <div class="corner top-right"></div>
          </div>
          <div class="col-8">
            <hr/>
          </div>
          <div class="col-2">
            <div class="corner left-bottom"></div>
          </div>
        </div>
        <!--second section-->
        <div class="row align-items-center justify-content-end how-it-works d-flex">
          <div class="col-6 text-right">
            <p></p>
            <h5>SECOND</h5>
			      <p>APPLY TO RENT THE RESIDENCE</p>
          </div>
          <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
            <div class="circle font-weight-bold">2</div>
          </div>
        </div>
        <!--path between 2-3-->
        <div class="row timeline">
          <div class="col-2">
            <div class="corner right-bottom"></div>
          </div>
          <div class="col-8">
            <hr/>
          </div>
          <div class="col-2">
            <div class="corner top-left"></div>
          </div>
        </div>
        <!--third section-->
        <div class="row align-items-center how-it-works d-flex">
          <div class="col-2 text-center top d-inline-flex justify-content-center align-items-center">
            <div class="circle font-weight-bold">3</div>
          </div>
          <div class="col-6">
            <p></p>
            <h5>FIRST</h5>
			      <p>SEARCH FOR A RESIDENCE</p>
          </div>
        </div>
      </div>
    </section>  
    <!-- End About -->
    
	  <!-- Start Contact Us -->
    <section id="section-contactus" class="section footer-classic context-dark bg-image" style="background: #2d3246;">
      <div class="container">
        <div class="row row-30">
          <div class="col-md-6 mt-4">
            <h2>CONTACT US</h2>
            <dl class="contact-list">
              <dt>Address:</dt>
              <dd>10, Jalan Semantan, Bukit Damansara, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</dd>
            </dl>
            <dl class="contact-list">
              <dt>Email:</dt>
              <dd><a href="mailto:#">claramayua.cm@gmail.com</a></dd>
			        <dd><a href="mailto:#">jane45690@gmail.com</a></dd>
            </dl>
            <dl class="contact-list">
              <dt>Phones:</dt>
              <dd><a href="tel:#">+60173081545</a></dd>
			        <dd><a href="tel:#">+60142285442</a></dd>
            </dl>
          </div>
          <div class="col-md-6">
            <div class="contact-sec text-center mt-4 mb-4">
              <h2>Need a Help?</h2>
			        <p>Fill up the form below and we'll get back to you as soon as possible.</p>
            </div>
			      <div class="form-contact">
				      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
					      <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
				        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
					      <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" required>
					      <textarea class="form-control" name="message" placeholder="Message" required></textarea>
				        <input type="submit" value="Send Message" />
				      </form>
			      </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Contact -->
	
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