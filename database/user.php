<?php

require "db_connection.php";

function createUser($username, $email, $password) {
    global $conn;

    $password_hashed = password_hash($password, null);

    // Prepare, Bind_param, Execute
    $query = "INSERT INTO users(username, email, password) ";
    $query .= "VALUES (?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password_hashed);
    $stmt->execute();

    return (!$conn->error) ? $conn->insert_id : 0;
}

function getUserByEmail($email) {
    global $conn;

    // Prepare, Bind_param, Execute
    $query="SELECT id,username,email,password ";
    $query.="FROM users ";
    $query.="WHERE email = ?";

    $stmt= $conn->prepare($query);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    // returning the first fetch of the result
    return (!$conn->error) ? $result->fetch_assoc() : [];
}

?>