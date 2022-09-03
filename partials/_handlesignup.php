<?php
$showAlert = false;
$showError = "false";
if($_SERVER['REQUEST_METHOD']=="POST"){

    include '_dbconnect.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // check whtehter this email exists

    $existSQL = "SELECT * FROM `users` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn, $existSQL);
    $numrows = mysqli_num_rows($result);

    if($numrows>0){
        $showError = 'User Already Exists!';
        
    } else{
        if($password == $repassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_password`, `date`) 
            VALUES ('$email', '$hash', current_timestamp())";

            $result = mysqli_query($conn, $sql);

            if($result){
                $showAlert = true;
                header("location: /forum/index.php?signupsuccess=true");
                exit;
            }
        }
        else{
           
            $showError = 'Password didnot matched';
           

    }
    header("location: /forum/index.php?signupsuccess=false&error=$showError ");
    
}

}
       
           
        

?>