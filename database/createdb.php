<?php

$conn = new mysqli("localhost", "root","","blog");
if($conn->connect_error)
    echo "FAILED to connect to DB!!";
else {
    $query = "CREATE DATABASE IF NOT EXISTS blog ";
    $result = $conn->query($query);
    if($result)
        echo "DATABASE IS CREATED.";
    else   
        echo "FAILED TO CREATE DATABASE!!";

    $query = "CREATE TABLE IF NOT EXISTS users  (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(121),
        email VARCHAR(121),
        password VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
    )";
    $result = $conn->query($query);
    if($result)
        echo "TABLE USERS CREATED";
    else
        echo "TABLE USERS CREATION FAILED";

    $query = "CREATE TABLE IF NOT EXISTS posts (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(121),
        body VARCHAR(121),
        img VARCHAR(121),
        user_id INT UNSIGNED,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $result = $conn->query($query);
    if($result)
        echo "TABLE POSTS CREATED";
    else
        echo "TABLE POSTS CREATION FAILED";
}

?>