<?php

    $conn = mysqli_connect("remotemysql.com:3306", "Hj1sZCDP0i", "UqUKa8bo96", "Hj1sZCDP0i");
	//$conn=mysqli_connect("db4free.net", "ppisample", "S$68NT45LPW9Vs7", "ppisample");
    if (mysqli_connect_errno()) {
        echo "Failed to established a connection: " . mysqli_connect_error();
        exit();
    }
?>