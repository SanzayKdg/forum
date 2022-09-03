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
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id` = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
                $title = $row['thread_name'];
                $desc = $row['thread_desc'];
                $commented_by = $row['thread_user_id'];
    
                    // query the user table to find out the original poster
                $sql2 = "SELECT `user_email` FROM `users` WHERE `user_id` = '$commented_by'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 =  mysqli_fetch_assoc($result2);
                $posted_by =  $row2['user_email'];
               
     }
    ?>
    <?php
            $showAlert = false;
            $method = $_SERVER['REQUEST_METHOD'];
            if( $method == 'POST'){
                // insert comment into db
                $userid = $_POST['userid'];
                $comment = $_POST['comment'];
                $comment = str_replace("<", "&lt;" , $comment);
                $comment = str_replace(">", "&gt;" , $comment);
               
                $sql = "INSERT INTO `comments` (`comment_by`, `comment_content`, `thread_id`, `comment_time`)
                 VALUES ('$userid', '$comment', '$id', current_timestamp());";
                $result = mysqli_query($conn, $sql);
                $showAlert = true; 
                if($showAlert){
                    echo 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your answer has been submitted sucessfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
           
?>

    <!-- category container starts form here -->
    <div class="container my-4">
        <div class="jumbotron bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-4 fw-bold"><?php echo $title?></h1>
                <p class="lead"><?php echo $desc ?></p>
                <hr class="my-4">
                <p>This is a peer to peer forum for sharing knowledge</p>

                <p class="text-left"> Posted by - <em> <?php echo $posted_by; ?></em></p>
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



    <div class="container">
        <h1 class="py-2">Discussions</h1>
        <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE `thread_id` = $id";
            $result = mysqli_query($conn, $sql);
            $discussions = true;

            while($row = mysqli_fetch_assoc($result)){
                    $discussions = false;
                    $comment_time = $row['comment_time'];
                    $comment = $row['comment_content'];
                    $id = $row['comment_id'];
                    $thread_user_id = $row['comment_by'];
                    
                    $sql2 = "SELECT `user_email` FROM `users` WHERE `user_id` = '$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 =  mysqli_fetch_assoc($result2);
                    $showUserName = $row2['user_email'];

                    echo '  <div class="container my-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="/forum/partials/img/userdefault.png" width="55px" alt="..." style="border-radius:360px;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                       <p class="font-weight-bold"><b>'.$showUserName.'</b></p>
                       <p class="font-weight-light"><i>[Posted-on: '.$comment_time.']</i></p>
                        '.$comment.'
                        </div>
                    </div>
                </div>
            </div>';
            }
            if($discussions){
                echo '<div class="jumbotron jumbotron-fluid ">
                            <div class="container">
                                <h4>No answer posted yet!</h4>
                                    <p class="lead"> Be the first person to answer this question.</p>
                            </div>
                      </div>';
            }
        ?>

        <?php
if(isset($_SESSION['loggedin']) &&  ($_SESSION['loggedin']) == true ){
       
       echo ' <div class="container my-4 " style="min-height:400px;">
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                <h6>Your Answer</h6>
                <!-- <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                </div> -->
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Description:</label>
                    <textarea class="form-control" id="desc" name="comment" rows="3"></textarea>
                    <input type="hidden" name="userid" value = "'.$_SESSION['userid'].'">
               
                    </div>
                <button type="submit" class="btn btn-primary">Post your answer</button>
            </form>
        </div>
    </div>';
} else{
    echo ' <div class="container my-3" style="min-height: 520px">
    <p class = "my-3 mx-4 h4"  >Please log in to post comments.</p>
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