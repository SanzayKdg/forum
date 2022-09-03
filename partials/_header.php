<?php
$showAlert = false;
  session_start();
 
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
    <div class="container-fluid ">
      <a class="navbar-brand" href="index.php">Programming Fourm</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About Us</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Top Categories
            </a>
            <ul class="dropdown-menu  bg-dark " aria-labelledby="navbarDropdown">';

              $sql = "SELECT `category_name`, `category_id` FROM `categories` LIMIT 3";
              $result = mysqli_query($conn, $sql);
              
  
  
              while($rows = mysqli_fetch_assoc($result)){
                    echo'
              <li><a class="dropdown-item text-light"  href="threadlists.php?catid='.$rows['category_id'].'">'.$rows['category_name'].'</a></li>';
           
              }
            echo ' 
            </ul>
          </li>
          <li class="nav-item" >
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>';
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true  ){
              echo ' <form class="d-flex" action = "search.php" method = "get">
              <input class="form-control me-2" type="search" name = "search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-light bg-primary" type="submit">Search</button>
              <p class = "text-light my-0 mx-2">Welcome, '.$_SESSION['useremail'].'</p></form>
            <a href = "partials/_logout.php" class="btn btn-outline-light bg-danger">Log out</a>
          ';
              
        }else{
            echo ' <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light bg-primary" type="submit">Search</button>
            
            </form>
          <div class="mx-2">
          <button class="btn btn-outline-light bg-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
          <button class="btn btn-outline-light bg-danger " data-bs-toggle="modal" data-bs-target="#signupModal">Register</button>
          </div>';

        }
       
     
     echo' </div>
    </div>
  </nav>';

    include 'partials/_loginModal.php';
    include 'partials/_signupModal.php';
 
    if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
      echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
      <strong>Success!</strong> You can now login.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    // }else{
      
    }

?>