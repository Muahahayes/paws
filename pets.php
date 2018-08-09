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
    <div>
    <?php 
        session_start();
        if(isset($_SESSION["name"])){
            if($_SESSION["name"] == "admin"){ //vets will share an admin account, so if that account's name is on the session cookie show admin pages
                header("Location: home.php"); //redirect admin, there aren't pets for them as an owner
            }
            else{ //anyone else with a session will be an Owner, so show their pets page
                echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item active"><a class="nav-link" href="pets.php">Pets</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
                </div>
                </nav>');
            }
        }
        else{ //if you aren't logged in as admin or owner, redirect them
            header("Location: home.php");
        }

        $host="localhost";
        $port=3306;
        $socket="MySQL";
        $username="root";
        $password="";
        $dbname="paws";

        $con = new mysqli($host, $username, $password, $dbname, $port, $socket);
        if ($con->connect_errno) {
            die("Failed to connect to MySQL: ($con->connect_errno) $con->connect_error");
        }
        $result = $con->query("select * from owners where username='" . $_SESSION["name"] . "'");
        $row = mysqli_fetch_assoc($result);
        $ownerID = $row["id"];
        //dog stuff starts here
        $pets = $con->query("
            SELECT d.name,d.breed,d.sex,d.shots,d.licensed,d.neutered,d.birthdate,d.weight FROM dogs as d
            INNER JOIN dogsowners as do
            on d.id=do.dogsFk
            where do.ownersFk='" . $ownerID . "'");

        $dogs = array();
        while($row = mysqli_fetch_assoc($pets)){
            array_push($dogs, $row);
        }

        echo('<br>
            <div class="container">');
        if(isset($dogs[0])){
            echo('<div class="d-flex justify-content-center"><h2>Dogs</h1></div>
            <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th id="name">Name</th>
                    <th id="breed">Breed</th>
                    <th id="sex">Sex</th>
                    <th id="shots" class="numbers">Shots</th>
                    <th id="age" class="numbers">Age</th>
                    <th id="weight" class="numbers">Size</th>
                    <th id="licensed" class="numbers">Licensed</th>
                    <th id="neutered" class="numbers">Neutered</th>
                </tr>
            </thead><tbody>');
            $dogAge = 0;
            $now = time();
            foreach($dogs as $dog){
                $dogAge = floor((($now - strtotime($dog["birthdate"]))/86400)/365.25);
                echo('
                <tr class="tdRow"><td>'. $dog["name"] .'</td>
                <td>' . $dog["breed"] . '</td>
                <td>' . $dog["sex"] . '</td>
                <td>');
                echo(($dog["shots"] == 1)?'Yes':'No');
                echo('</td>
                <td>' . $dogAge . '</td>');
                if($dog["weight"] < 20){
                    echo('<td>S</td>');
                }
                else if($dog["weight"] < 50){
                    echo('<td>M</td>');
                }
                else if($dog["weight"] < 100){
                    echo('<td>L</td>');
                }
                else{
                    echo('<td>G</td>');
                }
                echo(($dog["licensed"] == 1)?'<td>Yes</td>':'<td>No</td>');
                echo(($dog["neutered"] == 1)?'<td>Yes</td>':'<td>No</td>');
                echo('</tr>');
            }
            unset($dog);
            echo('</tbody></table>');
        }
        //cat stuff starts here
        $pets = $con->query("
            SELECT c.name,c.breed,c.sex,c.shots,c.neutered,c.birthdate,c.declawed FROM cats as c
            INNER JOIN catsowners as co
            on c.id=co.catsFk
            where co.ownersFk='" . $ownerID . "'");

        $cats = array();
        while($row = mysqli_fetch_assoc($pets)){
            array_push($cats, $row);
        }
        if(isset($cats[0])){
            echo('<br><div class="d-flex justify-content-center"><h2>Cats</h1></div>
                <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th id="name">Name</th>
                        <th id="breed">Breed</th>
                        <th id="sex">Sex</th>
                        <th id="shots" class="numbers">Shots</th>
                        <th id="age" class="numbers">Age</th>
                        <th id="licensed" class="numbers">Declawed</th>
                        <th id="neutered" class="numbers">Neutered</th>
                    </tr>
                </thead><tbody>');
            $catAge = 0;
            $now = time();
            foreach($cats as $cat){
                $catAge = floor((($now - strtotime($cat["birthdate"]))/86400)/365.25);
                echo('
                <tr class="tdRow"><td>'. $cat["name"] .'</td>
                <td>' . $cat["breed"] . '</td>
                <td>' . $cat["sex"] . '</td>
                <td>');
                echo(($cat["shots"] == 1)?'Yes':'No');
                echo('</td>
                <td>' . $catAge . '</td>');
                echo(($cat["declawed"] == 1)?'<td>Yes</td>':'<td>No</td>');
                echo(($cat["neutered"] == 1)?'<td>Yes</td>':'<td>No</td>');
                echo('</tr>');
            }
            unset($cat);
            echo('</tbody></table>');
        }

        //exotic stuff starts here
        $pets = $con->query("
            SELECT e.name,e.species,e.sex,e.neutered,e.birthdate FROM exotics as e
            INNER JOIN exoticsowners as eo
            on e.id=eo.exoticsFk
            where eo.ownersFk='" . $ownerID . "'");

        $exotics = array();
        while($row = mysqli_fetch_assoc($pets)){
            array_push($exotics, $row);
        }
        if(isset($exotics[0])){
            echo('<br><div class="d-flex justify-content-center"><h2>Other</h1></div>
                <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th id="name">Name</th>
                        <th id="breed">Species</th>
                        <th id="sex">Sex</th>
                        <th id="age" class="numbers">Age</th>
                        <th id="neutered" class="numbers">Neutered</th>
                    </tr>
                </thead><tbody>');
            $exoticAge = 0;
            $now = time();
            foreach($exotics as $exotic){
                $exoticAge = floor((($now - strtotime($exotic["birthdate"]))/86400)/365.25);
                echo('
                <tr class="tdRow"><td>'. $exotic["name"] .'</td>
                <td>' . $exotic["species"] . '</td>
                <td>' . $exotic["sex"] . '</td>
                <td>' . $exoticAge . '</td>');
                echo(($exotic["neutered"] == 1)?'<td>Yes</td>':'<td>No</td>');
                echo('</tr>');
            }
            unset($exotic);
            echo('</tbody></table>');
        }
        
    ?>
    </div>
</body>
</html>