<?php
require_once "../../shared/header.php";
?>

      <div class="container">
        <div class="auth-img-container">
          <div class="img">
            <img src="/blog/assets/11.jpg" alt="" />
          </div>
        </div>
        <div class="form-container">
          <form action="/blog/control/auth/auth.php" method="POST">
            <h2>Hi, Welcome Back!</h2>
            <input
              type="email"
              placeholder="Email"
              required="required"
              name="email"
            />
            <input
              type="password"
              placeholder="Password"
              required="required"
              name="password"
            />
            <div class="p-class">
              <input
                type="submit"
                id="submit-btn"
                value="Log In"
                name="loginform"
              />
              <p>Don't have an account?</p><a href="/blog/pages/auth/signup.php">SignUp</a>
            </div>
          </form>
          <!-- <div class="p-class">
            <p>Don't have an account?</p><a href="/blog/pages/auth/signup.php">SignUp</a>
          </div> -->
        </div>
      </div>
    </body>
</html>
