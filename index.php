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


    <?php
    include "partials/_header.php";
    include "partials/_dbconnect.php";
    ?>
    <!-- <div class="container my-3">
    <h1>Welcome to <strong>ForumBest</strong> - discussing Forum</h1>
    </div> -->
    <!-- Carousel -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/1200x700/?laptop" height="800px" width="1200px" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1200x700/?smartphone" height="800px" width="1200px" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1200x700/?book" height="800px" width="1200px" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
    <style>
        .me-2 {
            margin-right: .5rem !important;
            width: 20%;
        }

        .btn-success {
            background-color: #009c39;
        }

        .card {
            height: 450px !important;
        }

        .card-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300ch;
        }

        .glider-slide img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
    <div class="container my-3">
        <form class="d-flex justify-content-end" action="search.php" method="GET">
            <input class="form-control me-2 w-50" type="search" name="search" placeholder="Search Threads" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

    </div>
    <!-- Fetch all the catagories -->

    <!-- Use a for loop to iterate through catagories -->

    <!-- Catagory Container starts here -->

    <div class="container my-3">

        <h2 class="mt-5"><strong>Select Catagories</strong></h2>
        <hr>
        <div class="row">
            <!-- Use For loop to itereate through catagories -->

            <?php
            // Image Upload
            if (isset($_POST['submit'])) {
                $file = $_FILES['file'];
                $tempFile = $file['tmp_name'];
                $fileName = $file['name'];
                $fileExt = explode('.', $fileName);
                $fileCheck = strtolower(end($fileExt));
                $store = array('jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf');
                if (in_array($fileCheck, $store)) {
                    $destFile = "Images/" . $fileName;
                    move_uploaded_file($tempFile, $destFile);
                } else {
                    $target = null;
                    echo "Problem inserting image";
                    // echo "<br>No Image was uploaded";
                }
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!isset($_REQUEST['save_change'])) {
                    $cat_tit = $_POST['catagoryName'];
                    $cat_desc = $_POST['catagoryDesc'];
                    $added_by = $_SESSION['username'];

                    // Security
                    $cat_tit = str_replace("'", "`", "$cat_tit");
                    $cat_tit = str_replace(">", "&gt;", "$cat_tit");
                    $cat_tit = str_replace("<", "&lt;", "$cat_tit");
                    $cat_desc = str_replace("'", "`", "$cat_desc");
                    $cat_desc = str_replace(">", "&gt;", "$cat_desc");
                    $cat_desc = str_replace("<", "&lt;", "$cat_desc");
                    $sql = "INSERT INTO `catagories` (`photo`, `catagory_name`, `catagory_desc`,`added_by`,`date`) VALUES ( '$destFile','$cat_tit', '$cat_desc','$added_by',current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                } else {

                    $editTitle = $_REQUEST['edit_title'];
                    $editDesc = $_REQUEST['edit_desc'];
                    $editSerial = $_REQUEST['edit_serial'];

                    // Security
                    $editTitle = str_replace("'", "`", "$editTitle");
                    $editTitle = str_replace(">", "&gt;", "$editTitle");
                    $editTitle = str_replace("<", "&lt;", "$editTitle");
                    $editDesc = str_replace("'", "`", "$editDesc");
                    $editDesc = str_replace(">", "&gt;", "$editDesc");
                    $editDesc = str_replace("<", "&lt;", "$editDesc");
                    $sql = "UPDATE `catagories` SET `catagory_name` = '$editTitle', `catagory_desc` = '$editDesc' WHERE `catagories`.`catagory_id` = '$editSerial'";
                    $result = mysqli_query($conn, $sql);
                }
            }

            $delete = false;
            if (isset($_GET['delete'])) {
                $delete = true;
                $sno = $_GET['delete'];
                $sql = "DELETE FROM `catagories` WHERE `catagory_id` = '$sno'";
                $result = mysqli_query($conn, $sql);
            } else {
                // echo "Error";
            }
            if ($delete) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your post has been deleted successfully!</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }


            ?>

            <?php

            $sql = "SELECT * FROM `catagories` ";
            $result = mysqli_query($conn, $sql);
            ?>





            <!-- Glider Starts -->
            <style>
                .wrapperForDemo {
                    width: 300px;
                    max-width: 80%;
                    margin: 0 auto;
                }

                @-moz-document url-prefix() {
                    .glider-track {
                        margin-bottom: 17px;
                    }

                    .glider-wrap {
                        overflow: hidden !important;
                    }
                }

                .glider {
                    overflow-x: hidden;
                }

                .glider-slide {
                    margin: 20px;
                }
            </style>

            <div class="container">
                <div class="glider-contain">
                    <div class="glider">
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            $cat = $row['catagory_name'] . "laptop,computer,iphone,android,programming";
                            $id = $row['catagory_id'];
                            $cat_tit = $row['catagory_name'];
                            $cat_desc = $row['catagory_desc'];
                            $cat_pic = $row['photo'];
                            echo ' 
            <div class="card" style="width: 18rem;">
                <img src="' . $cat_pic . '" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong><a href="threadlist.php?catid=' . $id . '">' . $cat_tit . '</a></strong></h5>
                    <p class="card-text">' . $cat_desc . '</p>
                    <p class="" style="font-size:12px;">Catagory added by <strong>' . $row['added_by'] . '</strong> at ' . $row['date'] . '</p>
                    <div class="text-center pt-5"><a href="threadlist.php?catid=' . $id . '" class="btn btn-success">View Threads</a>
                    <a class="btn edit btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#editModal" id="' . $row['catagory_id'] . '">Edit</a>
                    <a href="#" class="btn btn-danger delete" id=d' . $row['catagory_id'] . '>Delete </a></div>
                </div>
            </div>';
                        }

                        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                            echo '<style>.delete,.edit{ display:none;}</style>';
                        }
                        ?>
                    </div>
                    <button role="button" aria-label="Previous" class="glider-prev">«</button>
                    <button role="button" aria-label="Next" class="glider-next">»</button>
                    <div role="tablist" class="dots"></div>
                </div>

                <!-- Glider Ends -->

                <hr>

                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '     <form action="index.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Choose Photo</label>
                    <input type="file" name="file" id="file" class="form-control">
                    </div>
                <div class="mb-3">
                    <label for="catagoryName" class="form-label">Give a Catagory Name</label>
                    <input type="text" name="catagoryName" class="form-control" id="catagoryName" required>
                </div>
                <div class="mb-3">
                    <label for="catagoryDesc" class="form-label">Write a brief description</label>
                    <textarea type="catagoryDesc" name="catagoryDesc" class="form-control" id="catagoryDesc" ></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Add Catagory</button>
            </form>';
                } else {
                    echo '<h3 class="text-center d-flex justify-content-center">Please <strong><a class="nav-link active pt-0" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></strong>to add catagories</h3>';
                }


                ?>


            </div>



        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="POST">
                        <input type="hidden" id="edit_serial" name="edit_serial">
                        <div class="mb-3">

                            <label for="exampleInputEmail1" class="form-label">Edit Title</label>
                            <input type="text" name="edit_title" class="form-control" id="edit_title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Edit Description</label>
                            <textarea name="edit_desc" id="edit_desc" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="save_change" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
    <script>
        new Glider(document.querySelector('.glider'), {
            slidesToShow: 1,
            draggable: true,
            itemWidth: 100,
            arrows: {
                prev: '.glider-prev',
                next: '.glider-next'
            },
            dots: '.dots',
            responsive: [{
                // screens greater than >= 775px
                breakpoint: 775,
                settings: {
                    // Set to `auto` and provide item width to adjust to viewport
                    slidesToShow: 3,
                    draggable: true,
                    slidesToScroll: 'auto',
                    itemWidth: 150,

                }
            }, ]
        })
    </script>
    <?php
    // if(isset($_REQUEST['save_change'])){

    // }

    ?>

    <script>
        var edit = document.querySelectorAll('.edit');
        // edit.addEventListener('click',()=>{
        //     console.log("Hellow!");
        // })
        Array.from(edit).forEach((element) => {
            element.addEventListener('click', (e) => {
                var title = e.target.parentNode.parentNode.querySelector('.card-title').innerText;
                var desc = e.target.parentNode.parentNode.querySelector('.card-text').innerText;
                console.log(title);
                console.log(desc);
                document.querySelector('#edit_title').value = title;
                document.querySelector('#edit_desc').value = desc;
                document.querySelector('#edit_serial').value = e.target.id;
            })
        })

        var del = document.querySelectorAll('.delete');
        Array.from(del).forEach((element) => {
            element.addEventListener('click', (e) => {
                var sno = e.target.id.substr(1, );
                if (confirm("Are you sure you want to delete this post?")) {
                    window.location = `index.php?delete=${sno}`;

                }
            })
        })
    </script>
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