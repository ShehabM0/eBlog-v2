<?php
require_once "../../shared/header.php";

// post-create-form validation //
function checkForm($array, $keys) {
  foreach($keys as $key)
      if(!isset($array["$key"]) || empty($array["$key"]))
          return false;
  return true;
}


// post and user authorization //
function getUsername($post)
{
  $user_id = $post["user_id"];
  $user = array_values($_SESSION["users"])[$user_id - 1];
  return $user["username"];
}

$post_arr_id = $_GET["id"] - 1; // minus 1 as zero indexed array
$post = $_SESSION["posts"][$post_arr_id] ?? null;
$post_user_id = $_SESSION["posts"][$post_arr_id]["user_id"];

// if current_user not the post owner,
// then definitely he can't edit the post he currently visiting
$valid_edit_post = true;

if(!isset($_SESSION["current_user"]))
  $valid_edit_post = false;
else
  $current_user_id = $_SESSION["current_user"]["id"];

// geeting username of the post creator
$username = getUsername($post);

// post is not found
if($post == null) {
  header("Error404 Not Found", true, 404);
  header("location: /blog/404.php");
}

// The user who is trying to edit, is NOT the post creator
if($post_user_id != $current_user_id)
{
  $valid_edit_post = false;
}
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
          <p><?= $username ?></p>
        </div>
      </div>

      <div class="post-body">
        <p><?= $post["body"] ?></p>
      </div>

      <!-- post buttons  -->
      <?php if($valid_edit_post) { ?>
        <div class="buttons">
          <div class="buttons-container">
            <button class="Edit" id="edit-post">Edit</button>
            <button form="fname" type="submit" class="Delete" name="post-delete-form" value="DELETE">Delete</button>
              <form action="/blog/control/posts/post.php" method="POST" id="fname">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="id" value="<?= $post_arr_id ?>">
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
