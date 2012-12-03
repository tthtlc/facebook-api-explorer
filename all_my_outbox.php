<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => 'YOUR_APP_ID',
  'secret' => 'YOUR_APP_SECRET',
));

$app_id  = 'YOUR_APP_ID';
// Get User ID
$user = $facebook->getUser();
$extended_needed=0;

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $user_outbox = $facebook->api('/me/outbox');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
    $extended_needed=1;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  //$access_token = $facebook->getAccessToken();
} else {
  if ($extended_needed) {
  }
  else {
  	$loginUrl = $facebook->getLoginUrl();
   // Get permission from the user to publish to their page. 
	$my_url = 'https://apps.facebook.com/tthtlcfb/all_my_outbox.php';
    	$dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
      	. $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&scope=read_mailbox";
    echo('<script>top.location.href="' . $dialog_url . '";</script>');


  }
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
      <h3>My outbox</h3>
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
      <h3>Your Outbox (/me)</h3>
      <pre><?php print_r($user_outbox); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
  </body>
</html>
