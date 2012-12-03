<?php

require 'facebook.php';

$facebook = new Facebook(array(
  'appId'  => 'YOUR_APP_ID',
  'secret' => 'YOUR_APP_SECRET',
));

  $app_id = 'YOUR_APP_ID';
  $app_secret = 'YOUR_APP_SECRET';
  $my_url = 'http://graph.facebook.com/me/outbox';
  ///$page_id = 'YOUR_PAGE_ID'; //User must be an admin of this Page
  $check_uid = '1322642795';

  $code = $_REQUEST["code"];

  echo '<html><body>';

  if(!$code) {
    // Get permission from the user to access their Pages. 
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&scope=read_mailbox";
    echo('<script>top.location.href="' . $dialog_url . '";</script>');
  } else {

    // Get access token for the user with manage_pages permision, 
    //   so we can GET /me/accounts
    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&client_secret=" . $app_secret
      . "&code=" . $code;
    $access_token = file_get_contents($token_url);

    $page_access_token_url = "https://graph.facebook.com/" . $page_id 
      . "?fields=access_token&" . $access_token;

    echo '<pre>';
    print_r($page_access_token_url);
    echo '</pre>';

    $page_access_token = file_get_contents($page_access_token_url);
    $page_access_token = json_decode($page_access_token, true);

    echo '<pre>';
    print_r($page_access_token);
    echo '</pre>';

    //check that the check_uid is an admin of the Page
    $is_admin_url = "https://graph.facebook.com/" . $page_id 
      . "/admins/" . $check_uid . "?access_token=" 
      . $page_access_token[access_token];

    echo '<pre>';
    print_r($is_admin_url);
    echo '</pre>';

    $response = file_get_contents($is_admin_url);
    $response_obj = json_decode($response, true);

    echo '<pre>';
    print_r($response_obj);
    echo '</pre>';

    echo '<pre>';
    echo $response_obj[data][0][name];
    echo '</pre>';

    if(empty($response_obj[data][0][name])) {
      echo 'This user is not an admin.';    
    } else {
      echo 'This user is an admin.';
    }
  }
  echo '</body></html>';
?>





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
  $loginUrl = $facebook->getLoginUrl();
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
