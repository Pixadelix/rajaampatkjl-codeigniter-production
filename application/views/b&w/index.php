<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ucwords( strtolower ( PROJECT_NAME ) ); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap and Font Awesome css-->
    <!-- we use cdn but you can also include local files located in css directory-->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Google fonts - Montserrat for headings, Cardo for copy-->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,700|Cardo:400,400italic,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/assets/static/b&w/css/style.default.css" id="theme-stylesheet">
    <!-- ekko lightbox-->
    <link rel="stylesheet" href="/assets/static/b&w/css/ekko-lightbox.css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/assets/static/b&w/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
    .content {
      top: 25%;
      /*transform: translate(0, -20%);*/
    }
    .logo-wrapper {
      background-color: rgba( 45, 51, 142, 0.8);
      padding: 48px;
      box-shadow: 4px 4px 8px rgba(0,0,0,.5);
      position: relative;
      z-index: 99;
    }
    .logo-papua-barat {
      min-height: 120px;
      background-image: url('/assets/static/img/logo-papua-barat.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center center;
    }
    .logo-uptd-raja-ampat {
      min-height: 120px;
      background-image: url('/assets/static/img/logo-uptd-raja-ampat.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center center;
    }
    .logo-kab-raja-ampat {
      min-height: 120px;
      background-image: url('/assets/static/img/logo-kab-raja-ampat.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center center;
    }

    @media only screen and (max-width: 600px) {
      .content {
        top: 0;
      }
      .logo-papua-barat, .logo-uptd-raja-ampat, .logo-kab-raja-ampat {
        min-height: 80px;
      }
      .logo-papua-barat {
        background-position: left center;
      }
      .logo-kab-raja-ampat {
        background-position: right center;
      }
    }
    </style>
  </head>
  <body data-spy="scroll" data-target="#navigation" data-offset="120">
    <!-- intro-->
    <section id="intro" style="background-image: url('<?php echo COVER_WELCOME_PAGE; ?>');" class="intro">      
      <div class="overlay"></div>
      <div class="row logo-wrapper">
        <div class="col-xs-4 logo-papua-barat"></div>
        <div class="col-xs-4 logo-uptd-raja-ampat"></div>
        <div class="col-xs-4 logo-kab-raja-ampat"></div>
      </div>
      <div class="content">
        <div class="container clearfix">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
              <p class="italic">Oh, hello, nice to meet you from</p>
              <h1><?php echo ucwords( strtolower ( PROJECT_NAME ) ); ?></h1>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- intro end-->
    <!-- Javascript files-->
    <!-- jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/assets/static/b&w/js/jquery-1.11.0.min.js"><\/script>')</script>
    <!-- Bootstrap CDN-->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- jQuery Cookie - For Demo Purpose-->
    <script src="/assets/static/b&w/js/jquery.cookie.js"></script>
    <!-- Lightbox-->
    <script src="/assets/static/b&w/js/ekko-lightbox.js"> </script>
    <!-- Sticky + Scroll To scripts for navbar-->
    <script src="/assets/static/b&w/js/jquery.sticky.js"></script>
    <script src="/assets/static/b&w/js/jquery.scrollTo.min.js"></script>
    <!-- main script-->
    <script src="/assets/static/b&w/js/front.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      //ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
  </body>
</html>