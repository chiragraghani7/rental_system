<?php

$conn = mysqli_connect("localhost:3306","root","Act1v@9015","rental_management_system");
if(!$conn){
 die("connection cancelled".mysqli_connect_error());

}else{
    echo "connection eastablished";
}

$query = "SELECT * FROM branch";

$stmt = mysqli_query($conn,$query);

while($row = mysqli_fetch_array($stmt,MYSQLI_ASSOC)){
    echo $row['street'].'<br>';
}

?>