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
    <link rel="shortcut icon" href="https://www.fte.com.pk/wp-content/themes/logipro/favico.gif" />
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
            <a class="nav-link" href="https://www.fte.com.pk/">
              <i class="icon ion-ios-home-outline"></i>
              <span>FTE Website</span>
            </a>
            
          </li>
		  <li class="nav-item" style="padding-top: 15px;">
            <a class="nav-link" href="<?= base_url() ?>product/tracking">
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

			<div class="section-wrapper mb-4">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div id="accordion" class="accordion-one stage-status-update" role="tablist" aria-multiselectable="true">
					</div>
					<h2 class="signin-title-primary">Track your Parcel</h2>
					<form id="searchProduct">
						<div class="form-group">
						  <input type="text" name="CNNumber" class="form-control" placeholder="Enter your Tracking Number">
						</div><!-- form-group -->
						<button type="submit" class="btn btn-success btn-block search-product-btn">Search</button>
					</form>
				</div>
				
			</div>
			<div id="searchResult"></div>
		</div>

        
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <div class="slim-footer">
      <div class="container">
        <p>Copyright <?= date('Y') ?> &copy; All Rights Reserved.</p>
        <p>Developed &amp; Designed by: Salman Bukhari &amp; Muhammad Kashif</p>
      </div><!-- container -->
    </div><!-- slim-footer -->

    <script src="<?= base_url() ?>assets/lib/jquery/js/jquery.js"></script>
    <script src="<?= base_url() ?>assets/lib/popper.js/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/lib/bootstrap/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="<?= base_url() ?>assets/lib/chartist/js/chartist.js"></script>
    <script src="<?= base_url() ?>assets/lib/d3/js/d3.js"></script>
    <script src="<?= base_url() ?>assets/lib/jquery.sparkline.bower/js/jquery.sparkline.min.js"></script>

    <script src="<?= base_url() ?>assets/js/ResizeSensor.js"></script>
    <script src="<?= base_url() ?>assets/js/slim.js"></script>
    <script type="text/javascript">
    	var base_url = "<?= base_url(); ?>"


    	$(document).ready(function (){
    		$('#searchProduct').on('submit', function (e) {
    			e.preventDefault()

    			$.ajax({
				    url : base_url + "product/tracking/search",
				    
				    method : "POST",

				    data : $(this).serializeArray(),
				    
				    beforeSend : function() {
				    	$('.search-product-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
				    },
				    
				    success : function ( res ) 
				    {
				    	let data = JSON.parse( res )

				    	$('.search-product-btn').html('Search Product')

				    	console.log(data)
				    	
				    	// return

				    	if ( data.code == 200 ) 
				    	{
				    		$('#searchResult').html(data.ProductTrackingData.productInformation)

				    		$('.stage-status-update').html('')
				    	}
				    	else
				    	{
							$('.stage-status-update').html(
														'<div class="alert alert-danger">' 
														+ data.ProductTrackingData + 
														'</div>'
													)
							$('#searchResult').html('')
				    	}
				    } 
			  	});
    		})
    	});
    </script>
  </body>
</html>
