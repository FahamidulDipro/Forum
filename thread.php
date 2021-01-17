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

        .btn-success {
            background-color: #009c39;
        }
    </style>
    <?php
    include "partials/_header.php";
    include "partials/_dbconnect.php";
    ?>

    <?php
    $showAlert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $comment = $_POST['comment'];
            $comment = str_replace("'", "`", "$comment");
            $comment = str_replace(">", "&gt;", "$comment");
            $comment = str_replace("<", "&lt;", "$comment");
            $sn = $_POST['sn'];
            $id = $_GET['serial'];
            // $desc = $_POST['threadDesc'];
            $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment','$id', '$sn', current_timestamp()); ";
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
            <strong>Your comment added!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container">
        <?php

        $id = $_GET['serial'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id` = '$id' ";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['thread_id'];
            $threadTitle = $row['thread_title'];
            $threadDesc = $row['thread_desc'];

            $threadUserId = $row['thread_user_id'];
            $sql2 = "SELECT username FROM `users` WHERE `Serial No.` = '$threadUserId'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $row2['username'];

            echo '<div class="jumbotron my-5 p-5 rounded-3">
     <h1 class="display-4">' . $threadTitle . '</h1>
     <p class="lead">Posted By <strong>' . $row2['username'] . '</strong> at    <span>' . $row['timestamp'] . '</span></p>
     <hr class="my-4">
     <p>' . $threadDesc . '</p>
  
  
   </div>';
        }


        ?>

    </div>

    <div class="container my-3 border-bottom py-3">
        <h2 class="">Discussion</h2>
        <hr>
        <?php
        $id = $_GET['serial'];
        $sql = "SELECT * FROM `comments` WHERE `thread_id` = '$id' ";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['comment_id'];
            $comment = $row['comment_content'];
            $time = $row['comment_time'];
            $commentBy = $row['comment_by'];
            $sql2 = "SELECT username,photo FROM `users` WHERE `Serial No.` = '$commentBy'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $row2['username'];
            $row2['photo'];

            echo '<div class="media d-flex my-3">
          <img src="partials/' . $row2['photo'] . '" style="height:50px;width:50px;border-radius:50%;object-fit:cover;" class="mr-3" alt="...">
          <div class="media-body mx-3 my-0">
            <h5 class="mt-0"><strong>' . $row2['username'] . '</strong> <span style="font-size:15px;">at ' . $time . '</span></h5>
            ' . $comment . '
          </div>
        </div>';
        }
        ?>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo ' <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <div class="mb-3">
                <label for="threadDesc" class="form-label">Write your comment</label>
                <textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
                <input type="hidden" name="sn" value="' . $_SESSION['sn'] . '">
                <button type="submit" class="btn btn-success my-3" name="submit">Post Comment</button>
            </div>
        </form>';
        } else {
            echo '<h3 class="text-center d-flex justify-content-center">Please <strong><a class="nav-link active pt-0" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></strong>to comment</h3>';
        }


        ?>



    </div>
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