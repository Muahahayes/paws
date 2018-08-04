<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
            crossorigin="anonymous">        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
        <script src="paws.js"></script>
        <title>Paws to Care</title>
    </head>
    <body>
        <?php 
            session_start();
            if(isset($_SESSION["name"])){ //In final release will have user log-in for sessions and will set the name value
                if($_SESSION["name"] == "admin"){ //vets will share an admin account, so if that account's name is on the session cookie show admin pages
                    echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="dogs.php">Dogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="cats.php">Cats</a></li>
                        <li class="nav-item"><a class="nav-link" href="exotics.php">Exotics</a></li>
                    </ul>
                    </div>
                    </nav>');
                }
                else{ //anyone else with a session will be an Owner, so show their pets page
                    echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="pets.php">Pets</a></li>
                    </ul>
                    </div>
                    </nav>');
                }
            }
            else{ //if you aren't logged in as admin or owner, don't show any data tables
                echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    </ul>
                    </div>
                    </nav>');
            }
        ?>
        <div class="jumbotron jumbotron-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <h1 class="display-4">Paws to Care</h1>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <p>We strive to keep your pets healthy and happy!</p>
            <p><b>Paws to Care</b> is your #1 ally in protecting your furry friends and helping them live their life to the fullest!</p>
            <p>Call us at <i>(555) 666-0000</i> to schedule an appointment with one of our skilled Veterinarians!</p>
        </div>
        <br>
        <div class="container-fluid">
            <p>
                Nunc laoreet velit nulla, sit amet scelerisque elit tincidunt non. 
                Nullam non tortor tempus, cursus nisl sed, scelerisque dui. 
                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
                Nam ut vehicula neque, placerat facilisis ex. 
                Sed iaculis, velit et vestibulum aliquam, tellus leo pulvinar ante, id imperdiet sapien ipsum semper arcu. 
                Mauris quis dignissim sapien. 
                Cras ut odio viverra turpis suscipit efficitur eu elementum nulla. 
                Aliquam luctus auctor sem, id pulvinar tortor suscipit at. Sed nunc erat, varius ut augue vitae, lobortis ornare ipsum. 
                Vivamus tincidunt turpis non gravida consequat. 
                In sit amet leo condimentum, convallis dolor sit amet, faucibus massa. 
                Aenean scelerisque orci id quam dictum sodales. 
                Vestibulum a cursus nunc. 
                Vestibulum imperdiet mollis pulvinar. 
                Quisque elit tellus, faucibus eget purus at, rutrum feugiat nisl. 
                Suspendisse ac nibh non ante faucibus consectetur a a ex.
            </p>
            <p>
                Morbi ac ex tortor. 
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. 
                Nullam bibendum fringilla massa a ullamcorper. 
                Quisque auctor at velit nec fringilla. 
                Nulla vitae mi porttitor, rhoncus sapien in, luctus quam. 
                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
                Mauris et nisi felis. Duis hendrerit orci et tempor sodales. 
                Fusce tincidunt nisi eget nunc posuere porttitor. 
                Aliquam quis lobortis augue, nec feugiat arcu. 
                Sed nibh enim, blandit bibendum ipsum sed, ultrices molestie lectus. 
                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
                Nunc fringilla magna nec odio euismod lobortis. 
                Nulla id auctor dolor. 
                Aliquam urna leo, aliquet ac odio pretium, feugiat sodales elit. 
                Nam tincidunt, lacus sit amet rutrum blandit, lorem nisl porttitor lorem, id ornare ante metus sed urna.
            </p>
        </div>
    </body>
</html>