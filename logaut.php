<?php
session_start();
session_destroy();
header("location: halduse_leht.php");
?>