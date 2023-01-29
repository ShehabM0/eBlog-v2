<?php
    require_once "../../shared/header.php";
    if(!isset($_SESSION))
        session_start();

    // if current user is a visitor (not logged-in)
    // then obviously he doens't have any posts.
    if(!isset($_SESSION["current_user"]))
    {
        header("Error404 Not Found", true, 404);
        header("location: /blog/404.php");
    }

    $posts = $_SESSION["posts"];
    $user_id = $_SESSION["current_user"]["id"];
    $no_posts = true;
?>

        <!-- loading user posts -->
        <div class="mypost-container">
        <?php
            foreach($posts as $post) 
            {
                if($user_id === $post["user_id"])
                {
                    $no_posts = false;
        ?>
                    <a href="/blog/pages/posts/post.php?id=<?= $post["id"] ?>" id="post-link">
                        <div class="mypost">
                            <img src="<?="/blog/assets/".$post["img"]?>" alt="">
                            <h3><?= $post["title"] ?></h3>
                            <p><?= $post["body"] ?></p>
                            <div class="post-user">
                                <img src="/blog/assets/bx-user-circle.svg" alt="">
                                <p><?= $_SESSION["current_user"]["username"] ?></p>
                            </div>
                        </div>
                    </a>
            <?php } ?>
        <?php } ?>

        <!-- user has no posts -->
        <?php if($no_posts) { ?>
            <p id="no-post">You don't have any posts yet.</p>
        <?php } ?>
            
        <!-- create-post window overlay -->
        <div class="create-modal overlay"></div>
    </body>
</html>
