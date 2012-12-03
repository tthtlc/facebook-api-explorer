
<?php

	$app_id = 'YOUR_APP_ID';
	$app_secret = 'YOUR_APP_SECRET';
  $ban_user = 'USER_ID';

  // Get an App Access Token
  $app_token_url = 'https://graph.facebook.com/oauth/access_token?'
    . 'client_id=' . $app_id
    . '&client_secret=' . $app_secret
    . '&grant_type=client_credentials';

  echo '<pre>';
  echo $app_token_url;
  echo '</pre>';
 
  $app_access_token = file_get_contents($app_token_url);
 
  echo '<pre>';
  echo $app_access_token;
  echo '</pre>';

  // Ban a user
  $ban_user_url = 'https://graph.facebook.com/'
    . $app_id . '/banned?uid=' . $ban_user . "&"
    . $app_access_token . '&method=post';

  $ban_user_result = file_get_contents($ban_user_url);
  echo '<pre>';
  echo 'Ban user result: ' . $ban_user_result;
  echo '</pre>';

  // Get banned users
  $banned_users_url = 'https://graph.facebook.com/'
    . $app_id . '/banned?' . $app_access_token;
  $banned_users = file_get_contents($banned_users_url);
  $banned_users_obj = json_decode($banned_users, true);
  
  echo '<pre>';
  echo 'Getting list of banned users:<br />';
  print_r($banned_users_obj);
  echo '</pre>';

  // Un-ban user
  $unban_user_url = 'https://graph.facebook.com/'
    . $app_id . '/banned/' . $ban_user . "&method=delete?"
    . $app_access_token;
  $unban_user_result = file_get_contents($unban_user_url);

  echo '<pre>';
  echo 'Unban user result: ' . $unban_user_result;
  echo '</pre>';

  // Check to see that specific user is banned
  $check_ban_user_url = 'https://graph.facebook.com/'
    . $app_id . '/banned/' . $ban_user . "?"
    . $app_access_token;
  $check_ban_user_result = file_get_contents($check_ban_user_url);
  $check_ban_user_obj=json_decode($check_ban_user_result, true);

  echo '<pre>';
  echo 'Check for banned user result: <br />';
  print_r($check_ban_user_obj);
  echo '</pre>';
?>


