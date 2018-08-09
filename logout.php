<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Paws to Care</title>
</head>
<?php 
    session_start();
    session_destroy();
    header("Location: home.php");
?>
<body>
    <h1>Logging Out</h1>
</body>