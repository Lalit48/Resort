<?php
// Database connection
$host = 'localhost';
$dbname = 'resort';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the `gallery` table
    $stmt = $conn->prepare("SELECT * FROM gallery");
    $stmt->execute();

    // Fetch all rows
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>keto</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>

   <style>
      @keyframes slideFromBottom {
    from {
        transform: translateY(100%); /* Start from below the screen */
        opacity: 0; /* Initially hidden */
    }
    to {
        transform: translateY(0); /* Slide to its original position */
        opacity: 1; /* Make it visible */
    }
}

.gallery .gallery_img {
    transform: translateY(100%); /* Initially out of view, below the screen */
    opacity: 0;
}

.gallery .in-view {
    animation: slideFromBottom 0.8s forwards; /* Apply sliding animation from the bottom */
}

@keyframes slideFromBottom {
    from {
        transform: translateY(100%); /* Start from below the screen */
        opacity: 0; /* Initially hidden */
    }
    to {
        transform: translateY(0); /* Slide to its original position */
        opacity: 1; /* Make it visible */
    }
}

.contact-section, .menu-section, .social-section {
    transform: translateY(100%); /* Initially out of view, below the screen */
    opacity: 0;
}

.contact-section.in-view, .menu-section.in-view, .social-section.in-view {
    animation: slideFromBottom 0.8s forwards; /* Apply sliding animation from the bottom */
}


   </style>

   <!-- body -->
   <body class="main-layout inner_page">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.php"><img src="images/logo.png" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item ">
                                 <a class="nav-link" href="index.php">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="about.html">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="room.php">Our room</a>
                              </li>
                              <li class="nav-item active">
                                 <a class="nav-link" href="gallery.php">Gallery</a>
                              </li>
                              
                              <li class="nav-item">
                                 <a class="nav-link" href="contact.html">Contact Us</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      <!-- end header inner -->
      <!-- end header -->
      <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                    <h2>gallery</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- gallery -->
      <div  class="gallery">
         <div class="container">
           
            <div class="row">
               <?php foreach ($images as $image): ?>
                   <div class="col-md-3 col-sm-6">
                       <div class="gallery_img">
                           <figure>
                               <img src="<?= htmlspecialchars($image['image_urls']); ?>" alt="Gallery Image"/>
                           </figure>
                       </div>
                   </div>
               <?php endforeach; ?>
           </div>
         </div>
      </div>
      <!-- end gallery -->
    
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                    <div class="col-md-4 contact-section">
                        <h3>Contact US</h3>
                        <ul class="conta">
                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> Address</li>
                            <li><i class="fa fa-mobile" aria-hidden="true"></i> +01 1234569540</li>
                            <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#"> demo@gmail.com</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4 menu-section">
                        <h3>Menu Link</h3>
                        <ul class="link_menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.html">about</a></li>
                            <li><a href="room.php">Our Room</a></li>
                            <li class="active"><a href="gallery.php">Gallery</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4 social-section">
                        <h3>Follow Us</h3>
                        <ul class="social_icon">
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>

               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <script>

            document.addEventListener("DOMContentLoaded", () => {
                const contactSection = document.querySelectorAll(".contact-section");
                const menuSection = document.querySelectorAll(".menu-section");
                const socialSection = document.querySelectorAll(".social-section");

                const observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add("in-view"); // Trigger the animation when the element enters the viewport
                            }
                        });
                    },
                    {
                        threshold: 0.1, // Trigger when 10% of the element is visible
                        rootMargin: "0px 0px -10% 0px", // Trigger animation slightly before the element is fully visible
                    }
                );

                contactSection.forEach((item) => observer.observe(item));
                menuSection.forEach((item) => observer.observe(item));
                socialSection.forEach((item) => observer.observe(item));
            });

                document.addEventListener("DOMContentLoaded", () => {
                const galleryItems = document.querySelectorAll(".gallery_img");

                const observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add("in-view"); // Trigger the animation when the element enters the viewport
                            }
                        });
                    },
                    {
                        threshold: 0.1, // Trigger when 10% of the element is visible
                        rootMargin: "0px 0px -10% 0px", // Trigger animation slightly before the element is fully visible
                    }
                );

                galleryItems.forEach((item) => observer.observe(item));
            });


      </script>

      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>
