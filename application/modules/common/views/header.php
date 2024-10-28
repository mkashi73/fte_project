<!DOCTYPE html>
    <html lang="en">
        <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        

        <title>
        <?php 
          
          
          if ( isset( $headerData['pageName'] ) ) 
          {
            echo $headerData['pageName'] . ' | ';
          }
          if ( isset( $headerData['companyName'] ) ) 
          {
            echo $headerData['companyName']; 
          }
        ?>
        </title>
        <!-- vendor css -->
        <link href="<?= base_url(); ?>assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link rel="shortcut icon" href="https://www.fte.com.pk/wp-content/themes/logipro/favico.gif" />

        <link href="<?= base_url(); ?>assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
        
        <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">  

        <!-- Select 2 CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->

        <link href="<?= base_url(); ?>assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
        <!-- Custom Css -->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/template/common/css/style.css">
        <!-- sweet alert 2 css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/lib/sweetAlert2/sweetalert2.min.css">
        <!-- Slim CSS -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/slim.css">
        <!-- Dropzone CSS -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/lib/dropzone/dropzone.min.css">
        <!-- Icons CSS -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/lib/icons-plugin/css/fontawesome-iconpicker.min.css">
        <!-- Input Tags CSS -->
        <link href="<?= base_url(); ?>assets/lib/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/lib/SpinKit/css/spinkit.css" rel="stylesheet">

        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P26RTTN');</script>
        <!-- End Google Tag Manager -->

        <script type='text/javascript'>
          
            goog_snippet_vars = function() {
              var w = window;
              /* <![CDATA[ */
              w.google_conversion_id = 'UA-143011071-1';
              w.google_conversion_label = '';
              w.google_remarketing_only = false;
              /* ]]> */
            }
        
          goog_report_conversion = function(url) {
            goog_snippet_vars();
            window.google_conversion_format = '3';
            var opt = new Object();
            opt.onload_callback = function() {
              if (typeof(url) != 'undefined') {
                window.location = url;
              }
            }
            var conv_handler = window['google_trackConversion'];
            if (typeof(conv_handler) == 'function') {
              conv_handler(opt);
            }
          }
        
        </script> 
        </head>
      <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P26RTTN"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div class="slim-header with-sidebar">
          <div class="container-fluid">
            <div class="slim-header-left">
              <h2 class="slim-logo"><a href="<?= base_url(); ?>welcome"><img src="<?= base_url(); ?>assets/img/fte-company-logo.png" width="70%"></a></h2>
              <a href="" id="slimSidebarMenu" class="slim-sidebar-menu"><span></span></a>
              <div class="search-box">
                <input type="text" class="form-control" placeholder="Search">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div><!-- search-box -->
            </div><!-- slim-header-left -->
            <div class="slim-header-right">
              <div class="dropdown dropdown-c">
                <a href="#" class="logged-user" data-toggle="dropdown">
                  <img src="http://via.placeholder.com/500x500" alt="">
                  <span><?= $token['full_name']; ?></span>
                  <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <nav class="nav">
                    <a href="page-profile.html" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                    <a href="page-edit-profile.html" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
                    <a href="<?= base_url('logout'); ?>" class="nav-link"><i class="icon ion-forward"></i> Sign Out</a>
                  </nav>
                </div><!-- dropdown-menu -->
              </div><!-- dropdown -->
            </div><!-- header-right -->
          </div><!-- container-fluid -->
        </div><!-- slim-header -->

