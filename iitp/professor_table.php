<?php
    $link = mysqli_connect("localhost","root","","professor");

    $tabl = "CREATE TABLE proftable (
        id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_link_token VARCHAR(255),
        exp_date DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    if(mysqli_query($link,$tabl))
    {
        echo "Table created";
    }
    else
    {
        echo "Error: ". mysqli_error($link);
    }

    mysqli_close($link);
?>