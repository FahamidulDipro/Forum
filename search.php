<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">

    <title>ForumBest</title>
</head>

<body>
    <style>
        .jumbotron {
            background-color: #ededc0;
        }
    </style>

    <?php
    include "partials/_header.php";
    include "partials/_dbconnect.php";
    ?>


    <!-- Search Results -->
    <div class="container">
        <div class="search_results my-3">
            <h1>Search results for <strong>"<?php echo $_GET['search']; ?>"</strong></h1>
            <?php
            $noResult = true;
            $query = $_GET['search'];
            $sql = "SELECT * FROM threads WHERE MATCH (thread_title,thread_desc) AGAINST ('$query')";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $url =  "thread.php?serial=" . $thread_id;
                $noResult = false;
                echo '  <div class="result">
            <a href="' . $url . '">
                <h3 class="text-dark mt-3">Cannot Install ' . $title . '</h3>
            </a>
            <p>' . $desc . '</p>

        </div>';
            }

            if ($noResult) {
                echo '  <div class="jumbotron jumbotron-fluid  p-5 rounded-3 mb-3">
                <div class="container">
                    <h1 class="display-4">No Result Found</h1>
                    <p class="lead"><strong>Your search did not match any documents</strong></p>
                </div>
            </div>
';
            }
            ?>

        </div>
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