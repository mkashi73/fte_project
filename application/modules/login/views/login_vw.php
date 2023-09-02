<div class="d-md-flex flex-row-reverse">
  <div class="signin-right">

    <div class="signin-box">
      <h2 class="signin-title-primary">Welcome back!</h2>
      <h3 class="signin-title-secondary">Sign in to continue.</h3>

        <form id="login-form">
          <div id="login-form-error" class="alert alert-danger"></div>
          <div class="form-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email">
          </div><!-- form-group -->
          <div class="form-group mg-b-50">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
          </div><!-- form-group -->
          <input type="hidden" id="tid" name="tid" id="tid" value="<?= TEN_ID ?>" />

          <button type="submit" class="btn btn-primary btn-block btn-signin" id="login-button">Sign In</button>

          <p class="mg-b-0">Don't have an account? <a href="page-signup2.html">Sign Up</a></p>
      </form>
    </div>

  </div><!-- signin-right -->
  <div class="signin-left">
    <div class="signin-box">
    <h2 class="slim-logo">
        <a href="index.html">
            <?= isset( $companyName ) ? $companyName . ' | ' : ''; ?> <span>Login Page</span>
        </a>
    </h2>

      <p>We are excited to launch our new company and product Slim. After being featured in too many magazines to mention and having created an online stir, we know that ThemePixels is going to be big. We also hope to win Startup Fictional Business of the Year this year.</p>

      <p>Browse our site and see for yourself why you need Slim.</p>

      <p><a href="" class="btn btn-outline-secondary pd-x-25">Learn More</a></p>

      <p class="tx-12">&copy; Copyright <?= date('Y'); ?>. All Rights Reserved.</p>
    </div>
  </div><!-- signin-left -->
</div><!-- d-flex -->
    