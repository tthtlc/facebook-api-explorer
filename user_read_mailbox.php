<?php

require 'facebook.php';

$facebook = new Facebook(array(
  'appId'  => 'YOUR_APP_ID',
  'secret' => 'YOUR_APP_SECRET',
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
    $access_token = $facebook->getAccessToken();
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}


// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $user_info="https://graph.facebook.com/me?fields=id,name" . '&access_token=' . $access_token;
} else {
  // $loginUrl = $facebook->getLoginUrl();
  $params = array(
  //scope => 'read_stream, friends_likes',
  scope => 'read_mailbox',
  redirect_uri => 'https://graph.facebook.com/me/outbox'
  );
  $loginUrl = $facebook->getLoginUrl($params);

}

?>
<!doctype html>
<html>
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>My payments</h3>
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
      <h3>Your Info (/me)</h3>
      <pre><a href="<?php print_r($user_info); ?>"> <?php print_r($user_info); ?> </pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
  </body>
</html>
