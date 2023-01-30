<?php

if(!isset($_SESSION))
    session_start();

include_once "../../helper/validator.php";
require "../../database/db_connection.php";
require "../../database/post.php";

if(isset($_POST["post-create-form"])) {
    $data_is_valid = checkForm($_POST, ["title", "body"]);
    if($data_is_valid) 
    {
        $title = $_POST["title"];
        $body = $_POST["body"];
        $image = $_FILES["image"];
        $_POST["image"] = $image["name"];
        $oldpath = $image["tmp_name"];
        $newpath = "../../assets/" . $image["name"];
        move_uploaded_file($oldpath, $newpath);
        
        if(checkLength($title, 100, 5) && checkImg($image['type'])) 
        {
            $user_id = $_SESSION["user"]["id"];
            $post_info = [
                "title" => $title, 
                "body" => $body, 
                "image" => $image["name"],
                "user_id" => $user_id
            ];
            $post_id = createPost($post_info);
            if($post_id)
            {
                array_push($_SESSION["messages"], "Post created successfully.");
                header("location: /blog/pages/posts/post.php?id=$post_id");
            }
            else
            {
                array_push($_SESSION["messages"], "Error creating post");
                header("location: /blog/");
            }
        }
        else 
        {
            if(!checkLength($title, 100, 5)) 
            {
                array_push($_SESSION["messages"], "Title length must be betwewen [5, 100] characters");
                header("location: /blog/");
            }
            else
            {
                array_push($_SESSION["messages"], "Image type not supported");
                header("location: /blog/");
            }
        }
    }
    else
    {
        array_push($_SESSION["messages"], "Post is invalid, please try again");
        header("location: /blog/");
    }
}


if(isset($_POST["post-update-form"])) {
     $data_is_valid = checkForm($_POST, ["title", "body", "image", "post_id"]);
    
     if($data_is_valid && isset($_SESSION["user"])) 
     {
         $title = $_POST["title"];
         $body = $_POST["body"];
         $image = $_POST["image"];
         $post_id = $_POST["post_id"];

         if(checkLength($title, 100, 5)) 
         {
             $post = getPostById($post_id);
             if($post["user_id"] == $_SESSION["user"]["id"])
             {
                $_POST["post_id"] = $post_id;
                $updated_post = updatePost($_POST);
                if($updated_post)
                {
                    array_push($_SESSION["messages"], "Post updated successfully.");
                    header("location: /blog/pages/posts/post.php?id=$post_id");
                }
                else
                    array_push($_SESSION["messages"], "Error Updating post.");
             }
             else
                header("HTTP/1.1 401 Unauthorized", true, 401);
         }
         else 
         {
             array_push($_SESSION["messages"], "Title length must be betwewen [5, 100] characters");
             header("location: /blog/pages/posts/post.php?id=" . $_POST["id"]);
         }
     }
     else 
     {
         array_push($_SESSION["messages"], "Post is invalid, please try again!");
         header("location: /blog/pages/posts/post.php?id=" . $_POST["id"]);
     }   
}

if(isset($_POST["post-delete-form"])) {
    $data_is_valid = checkForm($_POST, ["post-delete-form", "id", "_method"]);
    if($data_is_valid && $_POST["_method"] == "DELETE") {
        $post_id = $_POST["id"];

        $post = getPostById($post_id);
        if($post) {
            deletePost($post_id);
            array_push($_SESSION["messages"], "Post DELETED successfully.");
            header("location: /blog/");
        }
        else {
            array_push($_SESSION["messages"], "Post is not Found");
            header("location: /blog/");
        }
    }
}

?>