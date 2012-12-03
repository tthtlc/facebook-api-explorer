<?php
  $app_id = 'YOUR_APP_ID';
  $app_secret = 'YOUR_APP_SECRET';
  $my_url = 'http://apps.facebook.com/tthtlcfb/';

  $code = $_REQUEST["code"];

  echo '<html><body>';

  if(!$code) {
    // Get permission from the user to publish to their page. 
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&scope=read_requests";
    echo('<script>top.location.href="' . $dialog_url . '";</script>');
  } else {
    // Get access token for the user
    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&client_secret=" . $app_secret
      . "&code=" . $code;
    $access_token = file_get_contents($token_url);

    $notifications = "https://graph.facebook.com/me/friendrequests?" 
      . $access_token;
    $response = file_get_contents($notifications);

    $resp_obj = json_decode($response,true);

    echo '<pre>';
    print_r($resp_obj);
    echo '</pre>';
  }
  echo '</body></html>';
?>
