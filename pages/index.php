<?php
  require("database/post.php");
  if(!isset($_SESSION))
      session_start();
  $posts = getAllPosts();
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
      ?>
      <a href="/blog/pages/posts/post.php?id=<?= $post["id"] ?>" id="post-link">
        <div class="post">
          <img src="<?="/blog/uploads/".$post['img']?>" alt="">
          <h3><?= $post["title"] ?></h3>
          <p><?= $post["body"] ?></p>
          <div class="user">
            <img src="assets/bx-user-circle.svg" alt="">
            <p><?= $post["username"] ?></p>
          </div>
        </div>
      </a>
      <?php } ?>
    </div>


    <?php 
      if(count($posts) == 0)
      {
          $message="There are no posts available";
          array_push($_SESSION['messages'],$message);
      }
    ?>

    <!-- create post window background -->
    <div class="create-modal overlay"></div>

  </body>
</html>
