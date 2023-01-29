<?php

require "db.php";

function create_post($array) {
    global $conn;
    // Set variables (title, body, image, user_id)
    $title = $array["title"];
    $body = $array["body"];
    $image = $array["image"];
    $user_id= $array["user_id"];
    // Query (?, ?, ?, ?)
    $query="INSERT INTO posts(title, body, img, user_id)";
    $query.="VALUES (?, ?, ?, ?)";
    // Prepare query
    $stmt=$conn->prepare($query);
    // Bind param
    $stmt->bind_param("sssi", $title, $body, $image, $user_id);
    // Execute query
    $stmt->execute();
    // check if no conn error, return insert_id
    return (!$conn->error) ? $conn->insert_id:false;
}

function getAllPosts() {
    global $conn;
    // Get post(id, title, img, body, created_at,user_id) and user(username)
    $query="SELECT * FROM posts";
    $query="SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at, posts.user_id,users.username ";
    $query.="FROM posts ";
    $query.="JOIN users ON users.id=posts.user_id";
    $result=$conn->query($query);
    // return array of associative arrays of posts
    return ($result)? $result->fetch_all(MYSQLI_ASSOC) : [];
}
 function getPostById($id){
    global $conn;
    // Get post(id, title, img, body, created_at,user_id) and user(username)
    $query="SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at,posts.user_id , users.username ";
    $query.="FROM posts ";
    $query.="JOIN users ON users.id = posts.user_id WHERE posts.id = $id";
    $result=$conn->query($query);
    // Return associative array of post
    return ($result)? $result->fetch_assoc() : [];
 }

function updatePost($array) {
    global $conn;
    // Set variables from array (title, body, image, post_id)
    $title = $array["title"];
    $body = $array["body"];
    $image = $array["image"];
    $post_id = $array["post_id"];
    // Conn Query
    $query="UPDATE posts ";
    $query.="SET title='$title', body='$body', img='$image' ";
    $query.="WHERE id=$post_id";

    $result=$conn->query($query);
    return ($result) ? true : false;
 }

function deletePost($id) {
    global $conn;
    // Conn Query
    $query="DELETE FROM posts WHERE id=$id";
    $result=$conn->query($query);
    // Return true or false (success of fail)
    return ($result) ? true : false;
}

function getAll_UserPosts($user_id)
{
    global $conn;
    $query="SELECT posts.id, posts.title, posts.img, posts.body, posts.created_at,posts.user_id , users.username ";
    $query.="FROM posts ";
    $query.="JOIN users ON users.id = posts.user_id WHERE posts.user_id = $user_id";
    $result=$conn->query($query);
    return ($result)? $result->fetch_all(MYSQLI_ASSOC) : [];
}


?>