<?php
chdir('..');
include('vendor/autoload.php');
?>
<!doctype html>
<html>
<head>
  <title>Connect Facebook to the Photo Booth</title>
  <link rel="stylesheet" href="/assets/styles.css">
  <script src="/assets/jquery.js"></script>
</head>
<body>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?= Config::$appID ?>',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.5' // use graph api version 2.5
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      console.log(response);
      if(response.status == "connected") {
        $("#login-button").append("<p>Connected!</p>");
        $.post("/token.php", {
          token: response.authResponse.accessToken,
          expires_in: response.authResponse.expiresIn
        });
      }
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

</script>

<div style="width: 200px; margin: 100px auto;" id="login-button">
  <fb:login-button scope="public_profile,publish_pages,manage_pages" onlogin="checkLoginState();"></fb:login-button>  
</div>

</body>
</html>