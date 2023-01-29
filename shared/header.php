<?php
    if(!isset($_SESSION))
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/blog/css/header.css">
    <link rel="stylesheet" href="/blog/css/home.css">
    <link rel="stylesheet" href="/blog/css/card.css">
    <link rel="stylesheet" href="/blog/css/alert.css">
    <link rel="stylesheet" href="/blog/css/auth.css">
    <link rel="stylesheet" href="/blog/css/post.css">
    <link rel="stylesheet" href="/blog/css/create.css">
    <link rel="stylesheet" href="/blog/css/edit.css">
    <link rel="stylesheet" href="/blog/css/myposts.css">
    <title>eBlog</title>

    <!-- fonts -->
    <link 
        rel="preconnect"
        href="https://fonts.googleapis.com"
    />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com" crossorigin 
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <script defer src="../../../blog/app.js"></script>
  </head>
  <body>

    <!-- page header  -->
    <div class="header">
      <div class="nav-container">
        <?php if(!isset($_SESSION["current_user"])) { ?>
        <a href="/blog/">
          <span class="logo">
              e<span>B</span>log
          </span>
        </a>
        <span>
            <a href="/blog/pages/auth/signup.php" class="signup">SignUp</a>
            <a href="/blog/pages/auth/login.php" class="login">Login</a>
        </span>
        <?php } else { ?>
          <div class="left-side">
            <a href="/blog/">
              <span class="logo"> e<span>B</span>log </span>
            </a>
            <button id="create-post">Create Post</button>
            <a href="/blog/pages/posts/myposts.php"><button id="create-post">My posts</button></a>
          </div>
          <span>
              <span style="color: #fff; padding: 0 15px"><?= "Hello, " . $_SESSION["current_user"]["username"] ?></span>
              <a href="/blog/control/auth/logout.php" class="logout">Logout</a>
          </span>
        <?php } ?>
      </div>  
    </div>  

    <!-- create post window  -->
    <div class="create-modal modal-container">
      <div class="create-modal modal-header">
        <button class="close-btn" id="create-close-btn">&times;</button>
      </div>
      <div class="create-modal modal-body">
        <form action="/blog/control/posts/post.php" method="POST">
          <!-- title -->
          <label for="title">
            Title
            <span style="color: red">*</span>
          </label>
          <input
            type="text"
            id="title"
            placeholder="type the post title.."
            name="title"
          />
          <!-- image -->
          <label for="image">
            Image
            <span style="color: red">*</span>
          </label>
          <input
            type="text"
            id="image"
            placeholder="pick an img number from 1-11"
            name="image"
          />
          <!-- body  -->
          <label for="body">
            Body
            <span style="color: red">*</span>
          </label>
          <textarea
            type="text"
            id="text-body"
            placeholder="type the post body.."
            name="body"
          ></textarea>
          <!-- buttons -->
          <input
            type="submit"
            value="Create"
            id="submit-button"
            class="buttons"
            name="post-create-form"
          />
        </form>
      </div>
    </div>

    <!-- page alerts   -->
    <?php foreach($_SESSION["messages"] as $msg) { ?>
      <div class="alert-msg">
        <button class="close-btn">&times;</button>
        <p><?= $msg ?></p>
      </div>
    <?php } $_SESSION["messages"] = []; ?> 
