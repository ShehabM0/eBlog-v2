<?php

require "db.php";


function create_user($username, $email, $password) {
    global $conn;
    // Hash password
    $password_hashed = password_hash($password, null);
    // Query
    $query = "INSERT INTO users(username, email, password) ";
    $query .= "VALUES (?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password_hashed);
    $stmt->execute();

    return (!$conn->error) ? $conn->insert_id : 0;
}

function getUserByEmail($email) {
    global $conn;
    // Query
    $query="SELECT id,username,email,password ";
    $query.="FROM users ";
    $query.="WHERE email = ?";

    // Prepare, Bind_param, Execute
    $stmt= $conn->prepare($query);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    // return the first fetch of the result
    return (!$conn->error) ? $result->fetch_assoc() : [];
}


?>