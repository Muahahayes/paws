<!DOCTYPE html>
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
        label {
            width: 10%;
            display: inline-block;
            text-align: right;
            margin-right: 8px;
        }
        input[type=text], input[type=password], select {
            width: 30%;
            padding: 10px;
            margin: 6px 0;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 20%;
            background-color: #09f;
            color: white;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #07d;
        }
    </style>
</head>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        session_start();

        $name = $_POST["username"];
        $pass = $_POST["password"];

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
        $result = $con->query('SELECT * FROM owners');

        while($row = $result->fetch_row()){
            if($row[8] == $name){
                if($row[9] == $pass){
                    $_SESSION["name"] = $name;
                    header("Location: home.php");
                    die;
                }
                else{
                    echo "<h1>Incorrect username or password</h1>";
                }
            }
        }
        echo "<h1>Incorrect username or password</h1>";
    }
?>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <h1 class="display-8">Log-in</h1>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <form method="POST" action="login.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" autofocus>
            </div>
            <br>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <br>
            <input type="submit" class="btn" value="Login">
        </form>
    </div>
</body>