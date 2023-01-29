<?php
    if(!isset($_SESSION))
        session_start();
$posts = $_SESSION["posts"];
?>
    <div class="middle">
        <div class="text-container">
          <div class="hidden">
            <h1>Welcome To Our eBlog</h1>
            <h6>The Way Of Your Knowladge</h6>
          </div>
        </div>
    </div>

    <div class="post-container">
      <?php
          foreach($posts as $post) {
              $users = array_values($_SESSION["users"]);
              $user_id = $post["user_id"];
              $user = $users[$user_id-1];
      ?>
      <a href="/blog/pages/posts/post.php?id=<?= $post["id"] ?>" id="post-link">
        <div class="post">
          <img src="<?="/blog/assets/".$post['img']?>" alt="">
          <h3><?= $post["title"] ?></h3>
          <p><?= $post["body"] ?></p>
          <div class="user">
            <img src="assets/bx-user-circle.svg" alt="">
            <p><?= $user["username"] ?></p>
          </div>
        </div>
      </a>
      <?php } ?>
    </div>


    <?php 
      if(empty($_SESSION['posts']))
      {
          $message="There are no posts available";
          array_push($_SESSION['messages'],$message);
      }
    ?>

    <!-- create post window background -->
    <div class="create-modal overlay"></div>

  </body>
</html>
