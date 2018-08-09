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
            echo('<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                    <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="dogs.php">Dogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="cats.php">Cats</a></li>
                        <li class="nav-item"><a class="nav-link" href="exotics.php">Exotics</a></li>
                        <li class="nav-item active"><a class="nav-link" href="owners.php">Owners</a></li>
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
    $sql = "SELECT * FROM owners LIMIT 10 OFFSET ?"; //  WHERE ? LIKE ? ORDER BY ? ?
    $page = 1;
    $filterType = 'fname';
    $filterLike = "^a";
    $sortBy = 'fname';
    $sortAD = 'asc';
    if(isset($_GET["p"])){
        if($_GET["p"]>0){
            $page = ($_GET["p"] * 10) + 1;
        }
    }
    if(isset($_GET["ft"])){
        $filterType = $_GET["ft"];
    }
    if(isset($_GET["fl"])){
        $filterLike = $_GET["fl"];
    }
    if(isset($_GET["sb"])){
        $sortBy = $_GET["sb"];
    }
    if(isset($_GET["sa"])){
        $sortAD = $_GET["sa"];
    }
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i",$page); //,$filterType,$filterLike,$sortBy,$sortAD
    $stmt->execute();
    $result = $stmt->get_result();
    

    $owners = array();
    while($row = mysqli_fetch_assoc($result)){
        $dogs = array();
        $dogQ = $con->query("select d.name, d.breed
                    from dogs as d
                    inner join dogsowners as do
                    on d.id=do.dogsFk
                    where do.ownersFk='" . $row["id"] . "'
                ");
            while($dog = mysqli_fetch_assoc($dogQ)){
                array_push($dogs, $dog);
            }
        $row["dogs"] = $dogs;
        array_push($owners, $row);
    }
    $stmt->close();
    $con->close();

    echo('<br><div class="container">
        <div class="d-flex justify-content-center"><h2>Owners</h1></div>
            <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th id="fname">First Name</th>
                    <th id="lname">Last Name</th>
                    <th id="add1">Address</th>
                    <th id="add2">Address 2</th>
                    <th id="city">City</th>
                    <th id="st">State</th>
                    <th id="zip">Zip Code</th>
                    <th id="pets">Pets</th>
                </tr>
            </thead><tbody>');

    foreach($owners as $owner){
        $dogPets = '';
        foreach($owner["dogs"]as $dogP){
            $dogPets .= '<p>' . $dogP["name"] . '</p>';
        }
        echo('<tr class="td-row">
        <td>' . $owner["fname"] . '</td>
        <td>' . $owner["lname"] . '</td>
        <td>' . $owner["add1"] . '</td>
        <td>' . $owner["add2"] . '</td>
        <td>' . $owner["city"] . '</td>
        <td>' . $owner["st"] . '</td>
        <td>' . $owner["zip"] . '</td>
        <td>' . $dogPets . '</td>
        </tr>');

    }
    echo('</tbody></table></div>');
    ?>
    </div>
    <div class="pages d-flex justify-content-center">
            <?php 
                if(isset($_GET["p"]) && $_GET["p"] > 0){
                    $pg = $_GET["p"];
                    echo ('
                    <div class="d-flex flex-row">
                        <button class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'owners.php?p=' . ($pg - 1) . '\'" type="button">←</button>
                        <span style="padding: 10px; font-size:18pt"> ' . ($pg + 1) . ' </span>
                        <button id="forward" class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'owners.php?p=' . ($pg + 1) . '\'" type="button">→</button>                    
                    </div>
                    ');
                }
                else{
                    echo ('
                    <div class="d-flex flex-row">
                        <span style="padding: 10px; font-size:18pt" class=""> 1 </span>
                        <button id="forward" class="btn btn-primary" style="font-size:18pt" onclick="location.href=\'owners.php?p=1\'" type="button">→</button>                    
                    </div>
                    ');
                }
            ?></div>
</body>
</html>