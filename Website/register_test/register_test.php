<?php 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $adress = $_POST['adress'];



    $conn = new mysqli('localhost','root','','registration');
    if($conn->connect_error){
        die('Connection failed :'.$conn->connect_error);
        
    }else{
        $stmt = $conn->prepare("insert into reg(firstname, lastname, adress, email, password) values(?,?,?,?,?)");
        $stmt->bind_param("sssss",$firstname,$lastname,$adress,$email,$password);
        $stmt->execute();
        echo "Erfolgreich registriert...";
        $stmt->close();
        $conn->close();
    }   

    

?>

