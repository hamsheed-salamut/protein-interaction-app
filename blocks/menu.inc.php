		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(https://scontent.fmru3-1.fna.fbcdn.net/v/t31.0-1/p160x160/22256430_1737531686289293_2895101787620640035_o.jpg?_nc_cat=106&_nc_ohc=5e5Ti8iENjMAX8PpT2p&_nc_ht=scontent.fmru3-1.fna&_nc_tp=1002&oh=06d59de1a864d43152e6d1c50918baf2&oe=5ED1DBE7);"></a>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
	            <a href="dashboard.php">Home</a>
	          </li>
	          <li>
	              <a href="#">Search</a>
	          </li>
	          <li>
				 <a href="#">Browse</a>
	          </li>
  	          <li>
				 <a href="#">Download</a>
	          </li>
  	          <li>
				 <a href="#">Statistics</a>
	          </li>
  	          <li>
				 <a href="#">Help</a>
	          </li>
	          <li>
              <a href="#">About</a>
	          </li>
	          <li>
              <a href="#">Contact</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made <i class="icon-heart" aria-hidden="true"></i> by <a href="#" target="_blank">Kejilen</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            	<?php 
            		if ($_SERVER['REQUEST_URI'] == '/results.php') { ?>
	          	    <div class="col-sm-3 col-md-3">
				        <form class="navbar-form" action="results.php" method="post" role="search">
				        <div class="input-group">
				            <input type="text" class="form-control" name="id" placeholder="Search a Gene ID">
							<input type="hidden" name="type" value="gene">
				            <div class="input-group-btn">
				                <button class="btn btn-default btn-search" type="submit">&#xe003;</button>
				            </div>
				        </div>
				        </form>
				    </div>
            	<?php	}	?>
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Download</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Statistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>