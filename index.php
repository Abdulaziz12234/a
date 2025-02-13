<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

  if (isset($_COOKIE['user_logged_in']) && $_COOKIE['user_logged_in'] === 'true') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        header("Location: login_register.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sunset Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/superfish.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="Initial H Letter Real Estate Logo Design.png" type="image/x-icon">
  </head>
  <body>
    <div id="fh5co-wrapper">
      <div id="fh5co-page">
        <div id="fh5co-header">
          <header id="fh5co-header-section">
            <div class="container">
              <div class="nav-header">
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
                <h1 id="fh5co-logo"><a href="index.php">Sunset Hotel</a></h1>
                <nav id="fh5co-menu-wrap" role="navigation">
                  <ul class="sf-menu" id="fh5co-primary-menu">
                    <li class="active"><a href="index.php">Home</a></li>
                    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                      <li><a href="register.html">Register</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                      <li><a href="logout.php">Logout</a></li>
                      <li><a href="your_logs.php">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</a></li>

                    <?php endif; ?>
                  </ul>
                </nav>
              </div>
            </div>
          </header>
        </div>

        <div class="fh5co-hero">
          <div class="fh5co-overlay"></div>
          <div class="fh5co-cover text-center" data-stellar-background-ratio="0.5" style="background-image: url(https://cf.bstatic.com/xdata/images/hotel/max1024x768/76526205.jpg?k=92fc8281dd5bad6e06474ba61f01f00a29dcce5470db9af5bd081a9bc41b5ffe&o=&hp=1);">
          <div class="desc animate-box">
  <h2>Rooms designed for you</h2>
  <span><a class="btn btn-primary btn-lg" href="reservation.php">Book now</a></span>
</div>

          </div>
        </div>

        <div class="fh5co-listing">
          <div class="container">
            <div class="row">
               <!-- First row -->
               <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://www.amsterdamforesthotel.com/images/rooms/single/single-room-amsterdam-forest-hotel-1.jpg" alt="Single Room" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Single Room</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>

              <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://www.twahotel.com/sites/default/files/2019-07/standard-king-large.jpg" alt="Standard Room" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Standard Room</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>

              <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://www.mulberrynepal.com/wp-content/uploads/2017/04/business-suite-7.jpg" alt="Business Suite" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Business Suite</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>
            </div>

            <div class="row">
              <!-- Second row -->
              <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://cdn.webhotelier.net/photos/w=1920/michel-presfp/L722887.jpg" alt="Junior Suite" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Junior Suite</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>

              <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://focus.independent.ie/thumbor/501JuQ4mUx2AQD4FnYXHl-5-FoA=/0x17:1700x954/960x640/prod-mh-ireland/0c86e7a0-aa0a-11ed-9c83-0210609a3fe2.jpeg" alt="Family Room" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Family Room</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>

              <div class="col-md-4 col-sm-4 fh5co-item-wrap">
                <a class="fh5co-listing-item" href="reservation.php">
                  <img src="https://res.cloudinary.com/traveltripperweb/image/upload/c_limit,f_auto,h_2500,q_auto,w_2500/v1580455406/vahre6fc9gt8ygcdmkuu.jpg" alt="Double Room" class="img-responsive">
                  <div class="fh5co-listing-copy">
                    <h2>Double Room</h2>
                    <span class="icon">
                      <i class="icon-chevron-right"></i>
                    </span>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

		

        <div class="fh5co-section">
          <div class="container">
            <div class="row">
              <div class="col-md-6 fh5co-news">
				<h3>Hotel Updates</h3>
<ul>
  <li><a href="#top">
    <span class="fh5co-date">Jan. 5, 2025</span>
    <h3>Renovated Rooms</h3>
    <p>We've recently renovated our rooms, featuring modern decor and upgraded amenities. Experience luxury and comfort during your stay!</p>
  </a></li>
</ul>
<ul>
	<li><a href="#top">
	  <span class="fh5co-date">Jan. 10, 2025</span>
	  <h3>Enhanced Health and Safety Measures</h3>
	  <p>We care about your health! Our hotel has implemented new cleaning and sanitation protocols to ensure your safety during your stay with us.</p>
	</a></li>
  </ul>
				
              </div>
              <div class="col-md-6 fh5co-testimonial">
                <img src="https://img.freepik.com/premium-photo/apartment-renovation-empty-room-before-after-refurbishment-restoration_933790-1511.jpg" alt="Before and after" class="img-responsive mb20">
                <img src="https://ireward.superghs.com/resource/microtelmonticello/page/safety_measures.jpg" alt="Safety and Health" class="img-responsive">
              </div>
            </div>
          </div>
        </div>

        
                </div>
              </div>
            </div>
          </div>
        <!-- Footer -->
        <footer>
          <div id="footer">
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center">
                  <p style="font-size: 14px; line-height: 1.6;">
                             <a href="#" style="font-size: 18px; font-weight: bold; color:rgb(144, 200, 238);">Sunset Hotel</a>
                  <span style="font-size: 14px; color: #ffffff;">All Rights Reserved.</span><br>
                    <span style="font-size: 14px; color: #ffffff;">Made by UQU Students</span><br><br>
                    <span style="font-size: 14px; color: #ffffff;">Contact with us</span><br>
                    <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
                    <span style="font-size: 14px; color: #ffffff;"> S444002968@uqu.edu.sa</span>
					<i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
					<span style="font-size: 14px; color: #ffffff;"> S444008038@uqu.edu.sa </span>
					<br>
					<i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
					<span style="font-size: 14px; color: #ffffff;"> S444005537@uqu.edu.sa </span>
					<i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
					<span style="font-size: 14px; color: #ffffff;"> S444006563@uqu.edu.sa </span>
					<br>
					<i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
					<span style="font-size: 14px; color: #ffffff;"> S444007503@uqu.edu.sa</span>
					
                  </p>
                </div>
              </div>
            </div>
          </div>
        </footer>

      </div>
    </div>
  </body>
</html>
