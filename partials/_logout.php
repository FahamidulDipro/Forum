<?php
session_start();
echo"Logging out. Please wait...";

session_unset();
session_destroy();
header("location:/Forum/index.php");

?>