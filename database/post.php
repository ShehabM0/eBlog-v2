<?php

require "db_connection.php";

function createPost($array) {
    global $conn;

    $title = $array["title"];
    $body = $array["body"];
    $image = $array["image"];
    $user_id = $array["user_id"];

    $query= "INSERT INTO posts(title, body, img, user_id)";
    $query.= "VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $body, $image, $user_id);
    $stmt->execute();

    return (!$conn->error) ? $conn->insert_id : false;
}

function getAllPosts() {
    global $conn;
    
    $query = "SELECT * FROM posts";
    $query = "SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at, posts.user_id,users.username ";
    $query.= "FROM posts ";
    $query.= "JOIN users ON users.id = posts.user_id";

    $result = $conn->query($query);
    // returning array of associative arrays of posts
    return ($result)? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getPostById($id) {
    global $conn;
    
    $query = "SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at,posts.user_id , users.username ";
    $query.= "FROM posts ";
    $query.= "JOIN users ON users.id = posts.user_id ";
    $query.= "WHERE posts.id = $id";

    $result = $conn->query($query);
    // returning associative array of post
    return ($result)? $result->fetch_assoc() : [];
}

function updatePost($array) {
    global $conn;
    
    $title = $array["title"];
    $body = $array["body"];
    $image = $array["image"];
    $post_id = $array["post_id"];
    
    $query = "UPDATE posts ";
    $query.= "SET title='$title', body='$body', img='$image' ";
    $query.= "WHERE id=$post_id";

    $result = $conn->query($query);
    return ($result) ? true : false;
}

function deletePost($id) {
    global $conn;
    
    $query = "DELETE FROM posts WHERE id=$id";

    $result = $conn->query($query);
    return ($result) ? true : false;
}

function getAllUserPosts($user_id) {
    global $conn;

    $query = "SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at, posts.user_id, users.username ";
    $query.= "FROM posts ";
    $query.= "JOIN users ON users.id = posts.user_id WHERE posts.user_id = $user_id";

    $result = $conn->query($query);
    // returning array of associative arrays of posts
    return ($result)? $result->fetch_all(MYSQLI_ASSOC) : [];
}

?>