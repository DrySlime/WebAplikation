<?php

require_once "header.php";
require_once "includes/admin_functions_inc.php";
global $conn;
?>
<head>
    <link rel="stylesheet" href="CSS/orderedProducts.css">
    <title></title>

</head>
<body>
<div><br><br><br><br></div>

<div class="orderedProductList">
    <form action="userList_admin.php" method="post">
        <label>
            <input type="text" name="search" placeholder="UserID/Username" required>
        </label>
        <button type="submit">Suche</button>
        <a href="userList_admin.php"><button formnovalidate>Reset</button></a>
    </form>
</div>
<?php

if(isset($_POST["search"])&&$_POST["search"]!=null){

    $userid=$_POST["search"];
    if(strlen($userid)>3){
        $userid=getUserID($conn,$userid);
    }
    $userArray=getAllFromUser($conn,$userid);
    echo"
                
                <table>
                    <tr>
                        <th>id </th>
                        <th>Firstname </th>
                        <th>Lastname </th>
                        <th>Email </th>
                        <th>Username</th>
                        <th>Adressline</th>
                        <th>Street Number</th>
                        <th>City</th>
                        <th>Postal Code</th>
                    </tr>
            
                    ";
    if($userArray!=null){
        for($i=0;$i<count($userArray);$i++) {

            echo "
                        <tr>
                                <td > ".$userArray[$i]["id"]." </td >
                                <td > ".$userArray[$i]["firstname"]." </td >
                                <td > ".$userArray[$i]["lastname"]." </td >
                                <td > ".$userArray[$i]["email"]."Euro </td >
                                <td > ".$userArray[$i]["username"]." </td >                                             
                            ";
            $address=getAdressFromUserID($conn,$userArray[$i]["id"]);
            if($address!=null){
                echo"
                                <td > ".$address[0]["address_line"]." </td >
                                <td > ".$address[0]["street_number"]." </td >                                   
                                <td > ".$address[0]["city"]." </td >  
                                <td > ".$address[0]["postal_code"]." </td >  
                    ";
            }else{
                echo"
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                
                    ";
            }
            echo"        </tr >";
        }

    }else{

        echo "<h1>Keinen Nutzer unter dieser ID/Username</h1>";
    }


}else{
    $userArray=getAllUser($conn);

    echo"
                <h1>Alle Nutzer</h1>
                <table>
                    <tr>
                        <th>id </th>
                        <th>Firstname </th>
                        <th>Lastname </th>
                        <th>Email </th>
                        <th>Username</th>
                        <th>Adressline</th>
                        <th>Street Number</th>
                        <th>City</th>
                        <th>Postal Code</th>
                    </tr>
            
                    ";
    if($userArray!=null){
        for($i=0;$i<count($userArray);$i++) {

            echo "
                        <tr>
                                <td > ".$userArray[$i]["id"]." </td >
                                <td > ".$userArray[$i]["firstname"]." </td >
                                <td > ".$userArray[$i]["lastname"]." </td >
                                <td > ".$userArray[$i]["email"]."Euro </td >
                                <td > ".$userArray[$i]["username"]." </td >                                             
                            ";
            $address=getAdressFromUserID($conn,$userArray[$i]["id"]);
            if($address!=null){
                echo"
                                <td > ".$address[0]["address_line"]." </td >
                                <td > ".$address[0]["street_number"]." </td >                                   
                                <td > ".$address[0]["city"]." </td >  
                                <td > ".$address[0]["postal_code"]." </td >  
                    ";
            }else{
                echo"
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                <td > Not Given </td >  
                                
                    ";
            }
            echo"        </tr >";
        }

    }

}

?>


</body>

