
<?php

  $app_id = 'YOUR_APP_ID';
  $app_secret = 'YOUR_APP_SECRET';
  $my_url = 'YOUR_URL';
  $page_id = 'YOUR_PAGE_ID'; //User must be an admin of this Page
  $check_uid = 'USER_ID'; //Random User

  $code = $_REQUEST["code"];

  echo '<html><body>';

  if(!$code) {
    // Get permission from the user to access their Pages. 
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&scope=manage_pages";
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

