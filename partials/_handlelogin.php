<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    include '_dbconnect.php';
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];


    $sql = "SELECT * FROM users WHERE `user_email` = '$loginEmail'";
    $result = mysqli_query($conn, $sql);

    $numrows = mysqli_num_rows($result);

    if($numrows==1){
        $row = mysqli_fetch_assoc($result);
            if(password_verify($loginPassword, $row['user_password'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $row['user_id'];
                $_SESSION['useremail'] = $loginEmail;
                echo "logged in". $loginEmail;
                header("location: /forum/index.php");
                
            }
           
        }
        header("location: /forum/index.php");
    }






?>