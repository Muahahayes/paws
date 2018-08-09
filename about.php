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
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="dogs.php">Dogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="cats.php">Cats</a></li>
                        <li class="nav-item"><a class="nav-link" href="exotics.php">Exotics</a></li>
                        <li class="nav-item"><a class="nav-link" href="owners.php">Owners</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                    </div>
                    </nav>');
                }
                else{ //anyone else with a session will be an Owner, so show their pets page
                    echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="pets.php">Pets</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                    </div>
                    </nav>');
                }
            }
            else{ //if you aren't logged in as admin or owner, don't show any data tables
                echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
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
                            <h1 class="display-4">Meet the Vets!</h1>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        <br>
        <div class="container-fluid">
            <section class="info">
                <p><b>Dr. Frank Truska</b></p>
                <p>Nam vitae lacus id orci pharetra iaculis eu ut mauris. 
                    Maecenas consequat blandit lacus, vel ultrices neque posuere ut. 
                    Nam rutrum, mauris sit amet iaculis iaculis, dolor urna suscipit turpis, sed scelerisque nisl massa sit amet lacus. 
                    Duis vel metus nisi. Vivamus at tristique dui. 
                    Integer porttitor risus sed nunc venenatis faucibus. 
                    Ut ac est nec nibh consequat volutpat ut ut mi. 
                    Curabitur tempus congue mi, ut faucibus urna feugiat in. 
                    Mauris non purus ornare, viverra velit sodales, elementum ex. 
                    Mauris eleifend ipsum in turpis eleifend, a tempus tellus commodo.</p>
                <br>
                <p><b>Dr. Jack Smith</b></p>
                <p>Maecenas iaculis dapibus velit in venenatis. 
                    In semper in massa at tempus. 
                    Proin lobortis ornare odio. 
                    Morbi condimentum dolor quis dolor venenatis hendrerit. 
                    Duis tincidunt commodo risus in volutpat. 
                    Pellentesque maximus malesuada felis in iaculis. 
                    Pellentesque varius urna lectus, id semper libero hendrerit et. 
                    Morbi pellentesque dui a arcu tempor vestibulum. 
                    Pellentesque venenatis sollicitudin mollis. 
                    Ut ac velit metus.</p>
                <br>
                <p><b>Dr. John Doe</b></p>
                <p>Duis dictum convallis volutpat. 
                    Sed eleifend sollicitudin odio fringilla viverra. 
                    Quisque vehicula purus gravida, pellentesque odio sed, eleifend dui. 
                    Pellentesque ut ornare dolor. 
                    Integer vitae lacus vitae eros fermentum imperdiet. 
                    Nunc sed nulla elit. 
                    Nunc molestie bibendum sem, bibendum sagittis mauris laoreet quis. 
                    Donec tincidunt lorem metus, ac ultricies augue sodales quis. 
                    Suspendisse egestas massa dolor, at tristique nunc imperdiet quis. </p>
                <br>
                <p><b>Dr. Foo Bar</b></p>
                <p>Suspendisse potenti. 
                    In aliquam semper sem in tincidunt. 
                    Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
                    Proin fermentum nibh dapibus, auctor sapien ac, molestie lectus. 
                    Fusce est lacus, commodo quis pulvinar nec, tempus vel ipsum. 
                    Vestibulum ornare, augue finibus porta tincidunt, ligula mi dignissim eros, nec tincidunt risus purus et neque. 
                    Maecenas dolor elit, ornare sed lacus ut, imperdiet fringilla nunc.</p>
                <br>
                <p><b>Dr. Jane Baz</b></p>
                <p>Nam vitae lacus non justo porta ullamcorper id vel felis. 
                    Vivamus pellentesque ipsum eu lectus rhoncus, et volutpat augue finibus. 
                    In eget dui sit amet massa volutpat cursus non faucibus felis. 
                    Vestibulum id erat vulputate, sodales erat a, interdum nisl. 
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
                    Etiam metus nibh, auctor eget mauris vel, pellentesque consectetur est. 
                    Vivamus posuere rhoncus lorem eu consequat. 
                    Quisque et consectetur est, eget commodo tortor. 
                    Curabitur in finibus tellus.</p>
                <br>
            </section>
        </div>
    </body>
</html>