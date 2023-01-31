<?php
    require_once "../../shared/header.php";
    require "../../database/post.php";
    if(!isset($_SESSION))
        session_start();
    $user_id = $_SESSION["user"]["id"];
    $posts = getAllUserPosts($user_id);
?>

        <!-- loading user posts -->
        <div class="mypost-container">
        <?php
            foreach($posts as $post) 
            {
        ?>
                    <a href="/blog/pages/posts/post.php?id=<?= $post["id"] ?>" id="post-link">
                        <div class="mypost">
                            <img src="<?="/blog/uploads/".$post["img"]?>" alt="">
                            <h3><?= $post["title"] ?></h3>
                            <p><?= $post["body"] ?></p>
                            <div class="post-user">
                                <img src="/blog/assets/bx-user-circle.svg" alt="">
                                <p><?= $post["username"] ?></p>
                            </div>
                        </div>
                    </a>
        <?php } ?>

        <!-- user has no posts -->
        <?php if(count($posts) == 0) { ?>
            <p id="no-post">You don't have any posts yet.</p>
        <?php } ?>
            
        <!-- create-post window overlay -->
        <div class="create-modal overlay"></div>
    </body>
</html>
