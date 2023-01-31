<?php

require_once "../../shared/header.php";
require "../../helper/validator.php";
require "../../database/post.php";
global $conn;

$id = $_GET["id"];

$post = getPostById($id);
if(!$post) {
    header("HTTP/1.1 404 Not Found", true, 404);
    header("location: /blog/404.php");
}

$user_id = $post["user_id"];
$logged_user_id = $_SESSION["user"]["id"] ?? -1;

?>

      <!-- page background  -->
      <div class="img-bg"></div>

      <!-- page post  -->
      <div class="img-container">
        <div class="img">
          <img src="<?="/blog/assets/".$post['img']?>" alt="" />
        </div>
      </div>

      <div class="post-title">
        <h3><?= $post["title"] ?></h3>
        <div class="user">
          <img src="/blog/assets/bx-user-circle.svg" alt="" />
          <p><?= $post["username"] ?></p>
        </div>
      </div>

      <div class="post-body">
        <p><?= $post["body"] ?></p>
      </div>

      <!-- post buttons  -->
      <?php if($user_id == $logged_user_id) { ?>
        <div class="buttons">
          <div class="buttons-container">
            <button class="Edit" id="edit-post">Edit</button>
            <button form="fname" type="submit" class="Delete" name="post-delete-form" value="DELETE">Delete</button>
              <form action="/blog/control/posts/post.php" method="POST" id="fname">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="id" value="<?= $post["id"] ?>">
              </form>
          </div>
        </div>
      <?php } ?>

      <!-- edit post form -->
      <div class="edit-modal modal-container">
        <div class="edit-modal modal-header">
          <button class="close-btn" id="edit-close-btn">&times;</button>
        </div>
        <div class="edit-modal modal-body">
          <form action="/blog/control/posts/post.php" method="POST">
            <!-- title -->
            <label for="title">
              Title 
            </label>
            <input
              type="text"
              id="title"
              placeholder="type the post title.."
              name="title"
              value="<?= $post["title"] ?>"
            />
            <!-- image -->
            <label for="image">
              Image
            </label>
            <input
              type="text"
              id="image"
              placeholder="type the post img number.."
              name="image"
              value="<?= $post["img"] ?>"
            />
            <!-- body  -->
            <label for="body">
              Body
            </label>
            <textarea
              type="text"
              id="body"
              placeholder="type the post body.."
              name="body"
            > <?= $post["body"] ?> </textarea>
            <!-- post id that will be used to update the post (post identifier) -->
            <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
            <!-- buttons -->
            <input
              type="submit"
              value="Edit"
              id="submit-button"
              class="buttons"
              name="post-update-form"
            />
          </form>
        </div>
      </div>

    <div class="create-modal overlay"></div> 
    <div class="edit-modal overlay"></div> 

  </body>
</html>
