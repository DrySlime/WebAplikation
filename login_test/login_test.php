<?php
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Database verbindung
    $conn = new mysqli("localhost","root","","tester");
    if($conn->connect_error){
        die('Connection failed :'.$conn->connect_error);
        
    }else{
        $stmt = $conn->prepare("select * from login where email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            if($data['password']=== $password){
                echo"<h2>login success</h2>";
            }else{
                echo"<h2>Email oder Passwort inkorrekt</h2>";
            }
        }else{
            echo "<h2>Email oder Passwort inkorrekt</h2>";
        }
        $stmt->close();
        $conn->close();
    }   
?>