<?php
$error=''; //Variable to Store error message;
if(isset($_POST['submit'])){
 if(empty($_POST['user']) || empty($_POST['pass'])){
 $error = "Username or Password is Invalid";
 }
 else
 {
 //Define $user and $pass
 $user=$_POST['user'];
 $pass=$_POST['pass'];
 //Establishing Connection with server by passing server_name, user_id and pass as a patameter
 $conn = mysqli_connect("localhost", "prodalum_admin", "m3nd1gO5Ol4nO", "prodalum_w3");
 //Selecting Database
 $db = mysqli_select_db($conn, "test");
 //sql query to fetch information of registerd user and finds user match.
 $query = mysqli_query($conn, "SELECT * FROM admin WHERE password='$pass' AND correo='$user'");
 
 $_SESSION['MM_Username'] = $user;
 $_SESSION['MM_Password'] = $pass;	      
 $_SESSION['MM_idAdmin'] = $query["id"];	      

 
 $rows = mysqli_num_rows($query);
 if($rows == 1){
 header("Location: index.php"); // Redirecting to other page
 }
 else
 {
 $error = "Username of Password is Invalid";
 }
 mysqli_close($conn); // Closing connection
 }
}

?>