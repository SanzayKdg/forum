<!-- PHP Project:Creating An Online Forum In php From Scratch  -->

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Programming Language Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>

    <?php include 'partials/_header.php';?>

    <?php
    $id = $_GET['catid'];
     $sql = "SELECT * FROM `categories` WHERE `category_id` = '$id'";
     $result = mysqli_query($conn, $sql);
     while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $desc = $row['category_description'];
     }
    ?>


    <!-- submitting a form -->
    <?php
            $showAlert = false;
            $method = $_SERVER['REQUEST_METHOD'];
            if( $method == 'POST'){
                // insert thread into db
                $thread_title = $_POST['title'];
                $thread_desc = $_POST['desc'];
                $userid = $_POST['userid'];

                $title = str_replace("<", "&lt;" , $title);
                $title = str_replace(">", "&gt;" , $title);

                $desc = str_replace("<", "&lt;" , $desc);
                $desc = str_replace(">", "&gt;" , $desc);

                $sql = "INSERT INTO `threads` ( `thread_name`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) 
                        VALUES ( '$thread_title', '$thread_desc', '$id', '$userid', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                $showAlert = true; 
                if($showAlert){
                    echo 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your question has been submitted sucessfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
           
?>


    <!-- category container starts form here -->
    <div class="container my-4 text-center">
        <div class="jumbotron bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-4 fw-bold">Welcome to <?php echo $catname; ?> Forums</h1>
                <p class="lead"><?php echo $desc; ?></p>
                <hr class="my-4">
                <p>This is a peer to peer forum for sharing knowledge</p>

                <button class="btn btn-primary btn-lg" type="button">Learn More</button>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h6>Disclaimer:</h6>
                <ul>
                    <li> No Spam / Advertising / Self-promote in the forums.</li>
                    <li> Do not post copyright-infringing material.</li>
                    <li> Do not post “offensive” posts, links or images.</li>
                    <li> Do not cross post questions.</li>
                    <li> Do not PM users asking for help.</li>
                    <li> Remain respectful of other members at all times.</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container py-3">
        <h1 class="py-2">Browse Questions</h1>
        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $id";
            $result = mysqli_query($conn, $sql);
            $questions = true;


            while($row = mysqli_fetch_assoc($result)){
                    $questions = false;
                   
                    $title = $row['thread_name'];
                    $desc = $row['thread_desc'];
                    $id = $row['thread_id'];
                    $thread_time = $row['timestamp'];
                    $thread_user_id = $row['thread_user_id'];
                    $sql2 = "SELECT `user_email` FROM `users` WHERE `user_id` = '$thread_user_id'";
                    
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 =  mysqli_fetch_assoc($result2);
                   

                    echo '  <div class="container">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="/forum/partials/img/userdefault.png" width="55px" alt="..." style="border-radius:360px;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="font-weight-bold"><b>'.$row2['user_email'].'</b></p>
                            <h5 class="mt-0"> <a href = "thread.php?threadid='.$id.' ">'. $title .'</a></h5>
                            '.$desc.'
                            <p class="font-weight-light"><i>[Posted-on: '.$thread_time.']</i></p>
        
                        </div>
                    </div>
                </div>
            </div>';
            }
            // echo var_dump($questions);
            if($questions){
                echo '<div class="jumbotron jumbotron-fluid ">
                            <div class="container">
                                <h4>No questions asked yet!</h4>
                                    <p class="lead"> Be the first one to ask questions.</p>
                            </div>
                      </div>';
            }
        ?>
        <?php
        if(isset($_SESSION['loggedin']) &&  ($_SESSION['loggedin']) == true ){
       
             echo '
                <div class="container my-5" style="min-height: 520px">
                    <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
                            <h6>Tell us your problem.</h6>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Description:</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                            </div>
                    <input type="hidden" name="userid" value = "'.$_SESSION['userid'].'">

                            <button type="submit" class="btn btn-primary">Post your question</button>
                    </form>
                </div>
                </div>';
            }
                else{
                        echo ' <div class="container my-3" style="min-height: 520px">
                        <p class = "my-3 mx-4 h4"  >Please log in to post questions.</p>
                    </div>';
                }

                ?>







        <?php include 'partials/_footer.php';?>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>