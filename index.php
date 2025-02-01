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

<?php
// Database connection
$host = 'localhost';
$dbname = 'resort';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the database
    $stmt = $conn->prepare("SELECT * FROM rooms");
    $stmt->execute();

    // Fetch all rows
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
       <style>


         @keyframes slideFromRight {
            from {
               transform: translateX(100%); /* Start from the right (off-screen) */
               opacity: 0;
            }
            to {
               transform: translateX(0); /* Slide to the original position */
               opacity: 1;
            }
         }


         @keyframes slideFromLeft {
            from {
               transform: translateX(-100%); /* Start from the left (off-screen) */
               opacity: 0;
            }
            to {
               transform: translateX(0); /* Slide to the original position */
               opacity: 1;
            }
         }


         .contact-column {
            opacity: 0;
            transform: translateX(0);
         }
         .contact-column.right-slide {
            animation: slideFromRight 0.8s forwards;
         }

         .contact-column.left-slide {
            animation: slideFromLeft 0.8s forwards;
         }



         .contact .col-md-6 {
            opacity: 0;
            transform: translateX(0);
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


         .fade-in {
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
         }

         @keyframes fadeIn {
            0% {
               opacity: 0;
               transform: translateY(20px);
            }
            100% {
               opacity: 1;
               transform: translateY(0);
            }
         }

         @keyframes appear {
            from {
               opacity: 0;
               clip-path: inset(100% 100% 0 0);
            }
            to {
               opacity: 1;
               clip-path: inset(0 0 0 0);
            }
         }

         .block {
            opacity: 0; /* Start hidden */
            animation-timeline: view();
            animation-range: entry 0%;
            animation: appear 3s linear forwards; /* Animation duration of 1 second */
         }

         .block.hidden {
            animation: none; /* Prevent animation if not in view */
         }

         @media (prefers-reduced-motion: reduce) {
            .block {
               animation: none; /* Disable animation for accessibility */
            }
         }

         .block .room {
            transform: translateX(100%); /* Initially out of view to the right */
            opacity: 0;
            transition: transform 1s ease, opacity 1s ease;
         }

         .block.in-view .room {
            animation: slideFromRight 0.6s forwards; /* Apply sliding animation when in view */
         }
         
         @keyframes slideFromLeft {
            from {
               transform: translateX(-100%); /* Start from left, off the screen */
               opacity: 0; /* Initially hidden */
            }
            to {
               transform: translateX(0); /* Slide to original position */
               opacity: 1; /* Make it visible */
            }
         }

         .block .book_room {
            transform: translateX(-100%); /* Initially out of view */
            opacity: 0;
            transition: transform 1s ease, opacity 1s ease;
         }

         .block.in-view .book_room {
            animation: slideFromLeft 1s forwards; /* Apply sliding animation when in view */
         }

         @keyframes slideFromRight {
            from {
               transform: translateX(100%); /* Start from right, off the screen */
               opacity: 0; /* Initially hidden */
            }
            to {
               transform: translateX(0); /* Slide to original position */
               opacity: 1; /* Make it visible */
            }
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

         .gallery .gallery_img {
            transform: translateY(100%); /* Initially out of view, below the screen */
            opacity: 0;
         }

         .gallery .in-view {
            animation: slideFromBottom 0.8s forwards; /* Apply sliding animation from the bottom */
         }


       </style>
      <!-- header -->
      <header>
         <!-- header inner -->
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
                              <li class="nav-item active">
                                 <a class="nav-link" href="index.php">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="about.html">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="room.php">Our room</a>
                              </li>
                              <li class="nav-item">
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
      </header>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="first-slide" src="images/banner1.jpg" alt="First slide">
                  <div class="container">
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="second-slide" src="images/banner2.jpg" alt="Second slide">
               </div>
               <div class="carousel-item">
                  <img class="third-slide" src="images/banner3.jpg" alt="Third slide">
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
         
      </section>
      <!-- end banner -->
      <!-- about -->
      <div class="about">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>About Us</h2>
                     <p>The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum. </p>
                     <a class="read_more" href="Javascript:void(0)"> Read More</a>
                  </div>
               </div>
               <div class="col-md-7 block">
                  <div class="about_img">
                     <figure><img src="images/about.png" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->
      <!-- our_room -->
      <div  class="our_room">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Our Room</h2>
                     <p>Lorem Ipsum available, but the majority have suffered </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <?php 
               // Limit the number of rooms to 6
               $roomsToShow = array_slice($rooms, 0, 6); // Get first 6 rooms
               foreach ($roomsToShow as $room): ?>
                  <div class="col-md-4 col-sm-6 block">
                     <div id="serv_hover" class="room">
                        <div class="room_img">
                           <figure>
                              <img src="<?= htmlspecialchars($room['image_url']); ?>" alt="<?= htmlspecialchars($room['title']); ?>" />
                           </figure>
                        </div>
                        <div class="bed_room">
                           <h3><?= htmlspecialchars($room['title']); ?></h3>
                           <p><?= htmlspecialchars($room['description']); ?></p>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>

         </div>
      </div>
      <!-- end our_room -->
      <!-- gallery -->
      <div  class="gallery">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>gallery</h2>
                  </div>
               </div>
            </div>
            <div class="row">
                  <?php foreach ($images as $image): ?>
                     <div class="col-md-3 col-sm-6">
                         <div class="gallery_img">
                             <figure>
                                 <img src="<?= htmlspecialchars($image['image_url']); ?>" alt="Gallery Image"/>
                             </figure>
                         </div>
                     </div>
                  <?php endforeach; ?>
            </div>
         </div>
      </div>
      <!-- end gallery -->
      <!--  contact -->
      <div class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Contact Us</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 contact-column">
                  <form id="request" class="main_form" action="contact.php" method="POST">
                     <div class="row">
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Name" type="text" name="Name" required>
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" type="email" name="Email" required>
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" type="text" name="Phone_Number">
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Message" name="Message" required></textarea>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="send_btn">Send</button>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-md-6 contact-column">
                  <div class="map_main">
                     <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France" width="600" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- end contact -->
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
                     <li class="active"><a href="index.php">Home</a></li>
                     <li><a href="about.html">about</a></li>
                     <li><a href="room.php">Our Room</a></li>
                     <li><a href="gallery.php">Gallery</a></li>
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
               const contactColumns = document.querySelectorAll(".contact .col-md-6");

               const observer = new IntersectionObserver(
                  (entries) => {
                        entries.forEach((entry, index) => {
                           if (entry.isIntersecting) {
                              // Add left or right slide depending on the column index
                              if (index === 0) {
                                    entry.target.classList.add("left-slide"); // First column slides in from the left
                              } else if (index === 1) {
                                    entry.target.classList.add("left-slide"); // Second column slides in from the left
                              } else {
                                    entry.target.classList.add("right-slide"); // Third column slides in from the right
                              }
                           }
                        });
                  },
                  {
                        threshold: 0.1, // Trigger when 10% of the element is visible
                        rootMargin: "0px 0px -10% 0px", // Trigger animation slightly before fully visible
                  }
               );

               contactColumns.forEach((column) => observer.observe(column));
            });


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
            const blocks = document.querySelectorAll(".block");

            const observerOptions = {
               root: null,
               rootMargin: "0px",
               threshold: 0.4, // Trigger when 40% of the element is visible
            };

            const observer = new IntersectionObserver((entries, observer) => {
               entries.forEach((entry) => {
                  if (entry.isIntersecting) {
                     entry.target.classList.remove("hidden");
                     entry.target.classList.add("block");
                     observer.unobserve(entry.target); // Stop observing once animation is triggered
                  }
               });
            });

            blocks.forEach((block) => {
               block.classList.add("hidden"); // Add hidden class to start
               observer.observe(block);
            });
         });

         document.addEventListener("DOMContentLoaded", () => {
            const blocks = document.querySelectorAll(".block");

            const observer = new IntersectionObserver(
               (entries) => {
                     entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                           entry.target.classList.add("in-view"); // Trigger the animation as soon as it enters the viewport
                        }
                     });
               },
               {
                     threshold: 0.1, // Trigger when 10% of the element is visible
                     rootMargin: "0px 0px -10% 0px", // Trigger animation a bit before the element is fully visible
               }
            );

            blocks.forEach((block) => observer.observe(block));
         });

         document.addEventListener("DOMContentLoaded", () => {
            const blocks = document.querySelectorAll(".block");

            const observer = new IntersectionObserver(
               (entries) => {
                     entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                           entry.target.classList.add("in-view"); // Add the class to trigger animation
                        }
                     });
               },
               {
                     threshold: 0.4, // Trigger when 40% of the element is visible
               }
            );

            blocks.forEach((block) => observer.observe(block));
         });

         document.addEventListener("DOMContentLoaded", () => {
            const blocks = document.querySelectorAll(".block");

            const observer = new IntersectionObserver(
               (entries) => {
                     entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                           entry.target.classList.add("in-view"); // Trigger the animation as soon as it enters the viewport
                        }
                     });
               },
               {
                     threshold: 0.1, // Trigger when 10% of the element is visible
                     rootMargin: "0px 0px -10% 0px", // Trigger animation a bit before the element is fully visible
               }
            );

            blocks.forEach((block) => observer.observe(block));
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
