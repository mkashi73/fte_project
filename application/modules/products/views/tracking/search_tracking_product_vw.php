<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Slim">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/slim/img/slim-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/slim">
    <meta property="og:title" content="Slim">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title><?= $headerData['pageName'] ?></title>

    <!-- vendor css -->
    <link href="<?= base_url() ?>assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/lib/chartist/css/chartist.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/lib/rickshaw/css/rickshaw.min.css" rel="stylesheet">

    <!-- Slim CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/slim.css">

  </head>
  <body>
    
    <div class="slim-navbar" >
      <div class="container">
        <ul class="nav">
			<li>
				<h2 class="slim-logo">
          <a href="#">
            <img  src="<?= base_url(); ?>assets/img/fte-company-logo.png" width="35%">
          </a>
        </h2>
			</li>
          <li class="nav-item" style="padding-top: 15px;">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>FTE Website</span>
            </a>
            
          </li>
		  <li class="nav-item" style="padding-top: 15px;">
            <a class="nav-link" href="SearhTracking.html">
              <i class="icon ion-ios-home-outline"></i>
              <span>Search CN</span>
            </a>
            
          </li>
        </ul>
      </div><!-- container -->
    </div><!-- slim-navbar -->

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <h6 class="slim-pagetitle"><?= $headerData['pageName'] ?></h6>
        </div><!-- slim-pageheader -->
		
		<div class="section-wrapper row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<h2 class="signin-title-primary">Track your Parcel</h2>
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Enter your Tracking Number">
				</div><!-- form-group -->
				<button class="btn btn-primary btn-block btn-signin">Search</button>
			</div>
		</div>

        
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <div class="slim-footer">
      <div class="container">
        <p>Copyright 2018 &copy; All Rights Reserved. Slim Dashboard Template</p>
        <p>Designed by: <a href="">ThemePixels</a></p>
      </div><!-- container -->
    </div><!-- slim-footer -->

    <script src="<?= base_url() ?>assets/lib/jquery/js/jquery.js"></script>
    <script src="<?= base_url() ?>assets/lib/popper.js/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/lib/bootstrap/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="<?= base_url() ?>assets/lib/chartist/js/chartist.js"></script>
    <script src="<?= base_url() ?>assets/lib/d3/js/d3.js"></script>
    <script src="<?= base_url() ?>assets/lib/rickshaw/js/rickshaw.min.js"></script>
    <script src="<?= base_url() ?>assets/lib/jquery.sparkline.bower/js/jquery.sparkline.min.js"></script>

    <script src="<?= base_url() ?>assets/js/ResizeSensor.js"></script>
    <script src="<?= base_url() ?>assets/js/dashboard.js"></script>
    <script src="<?= base_url() ?>assets/js/slim.js"></script>
  </body>
</html>
