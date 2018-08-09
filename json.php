<?php 
    if(isset($_GET["s"])){
        $petTypes = $_GET["s"];
        $petType = $petTypes;
        $petTypes .= 's';
        if($petTypes == "cats" || $petTypes == "dogs" || $petTypes == "exotics"){
            // ------------------------------ //
            // ------------------------------ //
            $host="localhost";
            $port=3306;
            $socket="MySQL";
            $username="root";
            $password="";
            $dbname="paws";
            // ------------------------------ //
            // ------------------------------ //
            $con = new mysqli($host, $username, $password, $dbname, $port, $socket);
            if ($con->connect_errno) {
                die("Failed to connect to MySQL: ($con->connect_errno) $con->connect_error");
            }
            if(isset($_GET["p"]) && $_GET["p"] > 0){
                $page = $_GET["p"] * 10 - 10;
                
                $result = $con->query("select * from " . $petTypes . " limit 11 offset " . $page);
                $data = array();
                while($row = mysqli_fetch_assoc($result)){
                    $owners = array();
                    $ownerQ = $con->query("select o.fname,o.lname 
                                from owners as o
                                inner join " . $petTypes . "owners as po
                                on o.id=po.ownersFk
                                where po." . $petTypes . "Fk='" . $row["id"] . "'");
                    while($owner = mysqli_fetch_assoc($ownerQ)){
                        array_push($owners, $owner);
                    }
                    $row["owners"] = $owners;

                    $notes = array();
                    $noteQ = $con->query("select n.vetName,n.date,n.note
                                from " . $petType . "notes as n
                                where n." . $petTypes . "Fk='" . $row["id"] . "'");
                    while($note = mysqli_fetch_assoc($noteQ)){
                        array_push($notes, $note);
                    }
                    $row["notes"] = $notes;

                    array_push($data, $row);
                }


                header("Content-Type: application/json");
                echo json_encode($data);
            }
            else{
                $result = $con->query("select * from " . $petTypes . " limit 11");
                $data = array();
                while($row = mysqli_fetch_assoc($result)){
                    $owners = array();
                    $ownerQ = $con->query("select o.fname,o.lname 
                                from owners as o
                                inner join " . $petTypes . "owners as po
                                on o.id=po.ownersFk
                                where po." . $petTypes . "Fk='" . $row["id"] . "'");
                    while($owner = mysqli_fetch_assoc($ownerQ)){
                        array_push($owners, $owner);
                    }
                    $row["owners"] = $owners;

                    $notes = array();
                    $noteQ = $con->query("select n.vetName,n.date,n.note
                                from " . $petType . "notes as n
                                where n." . $petTypes . "Fk='" . $row["id"] . "'");
                    while($note = mysqli_fetch_assoc($noteQ)){
                        array_push($notes, $note);
                    }
                    $row["notes"] = $notes;
                    
                    array_push($data, $row);
                }


                header("Content-Type: application/json");
                echo json_encode($data);
            }
        }
        else{
            echo "Can only produce json from cats, dogs, or exotics!";
            
        }

    }
    else{
        echo "<div>
        <h1>Oops!</h1> <br>
        <h2>You shouldn't see this page, this page is for generating and returning a json file.</h2>
        </div>";
    }
?>