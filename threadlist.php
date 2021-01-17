<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>ForumBest</title>
</head>

<body>
    <style>
        .jumbotron {
            background-color: #ededc0;
        }
        .btn-success{
            background-color: #009c39;
        }
    </style>

    <?php
    
    include "partials/_header.php";
    include "partials/_dbconnect.php";
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `catagories` WHERE `catagory_id` = '$id' ";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catName = $row['catagory_name'];
        $catDesc = $row['catagory_desc'];
    }


    ?>
    <?php
    $showAlert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {;
        $title = $_POST['threadTitle'];
        $desc = $_POST['threadDesc'];
        $sn = $_POST['sn'];
        $title = str_replace("'","`","$title");
        $title = str_replace(">","&gt;","$title");
        $title = str_replace("<","&lt;","$title");
        $desc = str_replace("'","`","$desc");
        $desc = str_replace(">","&gt;","$desc");
        $desc = str_replace("<","&lt;","$desc");
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`,  `thread_cat_id`,`thread_user_id`,`timestamp`) VALUES ( '$title', '$desc','$id', '$sn',current_timestamp())";
        $result = mysqli_query($conn, $sql);
        echo '<script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        </script>';
        $showAlert = true;
    }

    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Thread Added!</strong> Please wait while someone in the community responds. 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }



    ?>




    <!-- <div class="container my-3">
    <h1>Welcome to <strong>ForumBest</strong> - discussing Forum</h1>
    </div> -->
    <!-- Carousel -->

    <!-- Fetch all the catagories -->

    <!-- Use a for loop to iterate through catagories -->

    <!-- Catagory Container starts here -->

    <div class="container my-5">
        <div class="jumbotron  my-5 p-5 rounded-3">
            <h1 class="display-4">Welcome to <strong><?php echo $catName; ?></strong> forum</h1>
            <p class="lead"><?php echo $catDesc; ?></p>
            <hr class="my-4">
            <p>This is a forum where we can share our knowledge with each other</p>
            <h2>Forum Rules</h2>
            <ul>
                <li>No Spam / Advertising / Self-promote in the forums</li>
                <li>Do not post copyright-infringing material</li>
                <li>Do not post “offensive” posts, links or images</li>
                <li>Do not cross post questions</li>
                <li>Do not PM users asking for help</li>
                <li>Remain respectful of other members at all times.</li>
            </ul>
            <a class="btn btn-success btn-lg" href="about.php" role="button">Learn more</a>
        </div>


    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'   <div class="container mt-5">

        <h2>Start Discussion</h2>
    
        <form action=" '.$_SERVER['REQUEST_URI'] .'" method="POST">
            <div class="mb-3">
                <label for="threadTitle" class="form-label mt-3">Problem Title</label>
                <input type="text" name="threadTitle" class="form-control" id="threadTitle">
                <div id="emailHelp" class="form-text">Keep your title as short as possible</div>
                <input type="hidden" name="sn" value="'.$_SESSION['sn'].'">
            </div>
            <div class="mb-3">
                <label for="threadDesc" class="form-label">Explain your problem</label>
                <textarea name="threadDesc" class="form-control" id="threadDesc" rows="3"></textarea>
                <button type="submit" class="btn btn-success my-3" name="submit">Submit</button>
            </div>
        </form>
    </div>';

    }
    else{
        echo'<h3 class="text-center d-flex justify-content-center">Please <strong><a class="nav-link active pt-0" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></strong>to join a discussion</h3>';
    }
   
    
    
    
    ?>
 


    <div class="container">
        <h1 class="pb-3">Browse Questions</h1>

        <?php
        $noResult = true;
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = '$id' ";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['thread_id'];
            $threadTitle = $row['thread_title'];
            $threadDesc = $row['thread_desc'];
            $threadTime = $row['timestamp'];
            $threadUserId = $row['thread_user_id'];
            $sql2 = "SELECT username,photo FROM `users` WHERE `Serial No.` = '$threadUserId'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $row2['username'];
            $row2['photo'];
            $noResult = false;
            echo '<div class="media d-flex my-3">
            <img src="partials/'.$row2['photo'].'"  style="height:50px;width:50px;border-radius:50%;object-fit:cover;" class="mr-3" alt="...">
            <div class="media-body" style="margin-left:10px;">
               
                <h5 class="mt-0"><a href="thread.php?serial=' . $id . '" class="text-dark">' . $threadTitle . '</a></h5>
                <p>' . $threadDesc . '</p>
                <p class="" style="font-size:12px;">Asked by <strong>' .$row2['username'] .'</strong> at '.$threadTime.'</p>
            </div>
        </div>';
        }
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid  p-5 rounded-3 mb-3">
           <div class="container">
             <h1 class="display-4">No Question Found</h1>
             <p class="lead"><strong>Be the first person to ask a question </strong></p>
           </div>
         </div>';
        }

        ?>



        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
        <?php include "partials/_footer.php"; ?>
</body>

</html>