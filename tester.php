<?php 
    $email = $_POST['email'];
    $password = $_POST['password'];


    $conn = new mysqli('localhost','root','','tester');
    if($conn->connect_error){
        die('Connection failed :'.$conn->connect_error);
        
    }else{
        $stmt = $conn->prepare("insert into registration(email, password) values(?,?)");
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute();
        echo "Erfolgreich registriert...";
        $stmt->close();
        $conn->close();
    }   

    

?>

