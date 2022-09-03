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
    <style>
    .container {
        min-height: 100vh;
    }
    .noresult{
        min-height: 30vh;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <!-- search results starts from here -->
    <div class="container my-4">
        <h1>Search results for <em>"<?php echo $_GET['search'];  ?>"</em></h1>
        
        <?php
        $noresult = true;
            $query = $_GET['search'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (`thread_name`, `thread_desc`) against ('$query') LIMIT 0, 25";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;

                    $title = $row['thread_name'];
                    $desc = $row['thread_desc'];
                    $thread_id = $row['thread_id'];
                    $url = "thread.php?threadid=".$thread_id;
                    // display search results
                    echo '<div class="result">
                    <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                    <p>'.$desc.'</p>
                </div>';
                }

                if($noresult){
                        echo '
                        <div class="jumbotron-fluid " style  = "background-color:#d3d3d3">
                                <div class = "container noresult py-5">
                                 <h4 class = "">No results found!!!</h4>
                                    <p>Your search  did not match any documents.
                                        <ul><b>Suggestions:</b>
                                            <li>Make sure that all words are spelled correctly.</li>
                                            <li>Try different keywords.</li>
                                            <li>Try more general keywords.</li>
                                        </ul>
                                    <p>
                                </div>
                         </div>
                        ';
                }
        ?>


        
    </div>



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