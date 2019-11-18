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
              <a class="nav-link" href="setres.php">Set Residence</a>
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

    <!-- Start View Applications -->
    <section id="section-table" class="container-fluid">
      <center><h2 class="pb-3 pt-2 border-bottoms">View Applications</h2></center>
	  <div class="table-responsive">
	  <table class="table" id="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">No</th>
			  <th scope="col">Residence ID</th>
			  <th scope="col">Name</th>
			  <th scope="col">No of Units</th>
			  <th scope="col">Monthly Rental</th>
			  <th scope="col">Applicant</th>
			  <th scope="col">Monthly Income</th>
			  <th scope="col">Required Month</th>
			  <th scope="col">Required Year</th>
			  <th scope="col">Status</th>
			</tr>
		  </thead>
		  <tbody>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">1</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">2</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">3</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">4</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">5</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">6</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">7</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">8</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
			<tr onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);"
			  data-toggle="modal" data-target="#exampleModal">
			  <th scope="row">8</th>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
		  </tbody>
		</table>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Do you want to approve the application?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				Note: If you approve, you need to Allocate Housing.
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Reject</button>
				<button type="button" class="btn btn-primary" onclick="DoNav('allocateform.php');">Approve</button>
			  </div>
			</div>
		  </div>
		</div>
		<p>
			<b>Note: Click the "New" status if you want to approve or reject the application.</b>
		</p>
		<script>
            var array = [["1","001","10 Semantan Suites","9","RM2,100","Alice","RM3,100","12 months","1 year","New"],
                         ["2","002","Twins Damansara Heights","6","RM3,000","Bruno","RM4,000","18 months","1 year 12 months","New"],
                         ["3","003","Damansara City Residency","12","RM5,100","Clint","RM6,100","18 months","1 year 12 months","New"],
                         ["4","004","Clearwater Residences","6","RM3,600","Dyrroth","RM4,600","18 months","1 year 12 months","New"],
                         ["5","005","Glomac Damansara","15","RM3,900","Eudora","RM4,900","12 months","1 year","New"],
                         ["6","006","Desa Kiara Condominium","18","RM2,100","Franco","RM3,100","12 months","1 year","New"],
                         ["7","007","D9 Luxury Condominium","3","RM7,500","Grock","RM8,500","12 months","1 year","New"],
                         ["8","008","Indah Damansara Condominium","3","RM3,600","Hylos","RM4,600","18 months","1 year 12 months","New"],
						 ["9","009","Sinaran TTDI","6","RM3,000","Irithel","RM3,000","12 months","1 year","New"]],
                table = document.getElementById("table");
        // rows
        for(var i = 1; i < table.rows.length; i++)
        {
          // cells
          for(var j = 0; j < table.rows[i].cells.length; j++)
          {
              table.rows[i].cells[j].innerHTML = array[i - 1][j];
          }
        }
		function ChangeColor(tableRow, highLight)
		{
		if (highLight)
		{
		  tableRow.style.backgroundColor = '#C0C0C0';
		}
		else
		{
		  tableRow.style.backgroundColor = '#DCDCDC';
		}
	  }

	  function DoNav(theUrl)
	  {
	  document.location.href = theUrl;
	  }
		</script>
    </section>
    <!-- End View Applications -->
      
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