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
        <style>
            th {
                cursor: pointer;
            }
        </style>
    </head>
    
    <?php
        $page = 1;
        if(isset($_GET["p"])){
            $page = $_GET["p"];
        }
    ?>
    <body id="exotic">
        <?php 
            session_start();
            if(isset($_SESSION["name"])){ //In final release will have user log-in for sessions and will set the name value
                if($_SESSION["name"] == "admin"){ //vets will share an admin account, so if that account's name is on the session cookie show admin pages
                    echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="dogs.php">Dogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="cats.php">Cats</a></li>
                        <li class="nav-item active"><a class="nav-link" href="exotics.php">Exotics</a></li>
                        <li class="nav-item"><a class="nav-link" href="owners.php">Owners</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                    </div>
                    </nav>');
                }
                else{ //anyone else with a session will be an Owner, redirect them
                    header("Location: home.php");
                }
            }
            else{ //if you aren't logged in as admin or owner, redirect them
                header("Location: home.php");
            }
        ?>
        <br><br>
        <div class="container">
            <div class="d-flex justify-content-center"><h2>Exotics</h1></div>
            <table class="table table-striped table-bordered table-hover" id="table"></table>
            <div class="pages d-flex justify-content-center" id=<?php echo $page; ?>>
            <?php 
                if($page > 1){
                    echo ('
                    <div class="d-flex flex-row">
                        <button class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'exotics.php?p=' . ($page - 1) . '\'" type="button">←</button>
                        <span style="padding: 10px; font-size:18pt"> ' . $page . ' </span>
                        <button id="forward" class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'exotics.php?p=' . ($page + 1) . '\'" type="button">→</button>                    
                    </div>
                    ');
                }
                else{
                    echo ('
                    <div class="d-flex flex-row">
                        <span style="padding: 10px; font-size:18pt" class=""> ' . $page . ' </span>
                        <button id="forward" class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'exotics.php?p=' . ($page + 1) . '\'" type="button">→</button>                    
                    </div>
                    ');
                }
            ?></div>
        </div>
        <div class="modals"></div>
    </body>
</html>