<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
  <meta property="fb:app_id" content="YOUR_APP_ID" /> 
  <meta property="og:type"   content="object" /> 
  <meta property="og:url"    content="Put your own URL to the object here" /> 
  <meta property="og:title"  content="My Facebook Data enumeration pages." /> 
  <meta property="og:image"  content="https://s-static.ak.fbcdn.net/images/devsite/attachment_blank.png" /> 
    <!-- <script src="/javascript/track.js" type="text/javascript"></script> -->

    <title>Facebook data display - YOUR OWN DATA </title>

    <link rel="stylesheet" href="/style/demo.css">

</head>
<body>

<!-- xfbml -->

<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=YOUR_APP_ID";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="page">
    <div id="header">
        <div style="text-align: center;">

        </div>
    </div>

    <div id="content">
        <div id="menu">

        </div>
        <div id="experiment">
            <div style="text-align:center">
            </div>
        </div>
    </div>
</div>

</body>


<!--
<div class="fb-like" data-href="http://apps.facebook.com/tthtlcfb/" data-send="true" data-width="450" data-show-faces="true"></div>
-->
<a href="getting_app_access_token.php"> this is getting_app_access_token </a> <br>
<a href="getting_user_access_token.php"> this is getting_user_access_token </a> <br>
<a href="my_first_app.php"> this is my first apps </a> <br>
<a href="all_my_friends.php"> this is a list of all my friends </a> <br>
<a href="all_my_likes.php"> this is a list of all my likes </a> <br>
<a href="all_my_place.php"> this is a list of all my place </a> <br>
<a href="all_my_updates.php"> this is a list of all my updates </a> <br>
<a href="all_my_recommendations.php"> this is a list of all my recommendations </a> <br>
<a href="all_my_outbox.php"> this is a list of all my outbox (extended permission working!!)</a> <br>
<a href="all_my_payments.php"> this is a list of all my payments (not working yet)</a> <br>
<a href="all_my_interests.php"> this is a list of all my interests </a> <br>
<a href="all_my_games.php"> this is a list of all my games </a> <br>
<a href="all_my_activities.php"> this is a list of all my activities </a> <br>
<a href="all_my_checkin.php"> this is a list of all my checkin </a> <br>
<a href="all_my_comments.php"> this is a list of all my comments </a> <br>
<a href="all_my_events.php"> this is a list of all my events </a> <br>
<a href="all_my_friendlists.php"> this is a list of all my friendlists </a> <br>
<a href="all_my_groups.php"> this is a list of all my groups </a> <br>
<a href="all_my_links.php"> this is a list of all my links </a> <br>
<a href="all_my_notes.php"> this is a list of all my notes </a> <br>
<a href="all_my_permissions.php"> this is a list of all my permissions </a> <br>
<a href="all_my_photos.php"> this is a list of all my photos </a> <br>
<a href="all_my_posts.php"> this is a list of all my posts </a> <br>
<a href="all_my_questions.php"> this is a list of all my questions </a> <br>
<a href="all_my_threads.php"> this is a list of all my threads </a> <br>
<a href="all_my_videos.php"> this is a list of all my videos </a> <br>
<a href="all_my_checkins.php"> this is a list of all my checkins </a> <br>
<a href="all_my_albums.php"> this is a list of all my albums </a> <br>
<a href="all_my_feed.php"> this is a list of all my feed </a> <br>
<a href="all_my_locations.php"> this is a list of all my locations </a> <br>
<a href="all_my_movies.php"> this is a list of all my movies </a> <br>

<!--
<a href="myorig.php"> orig </a> <br>
<a href="example.php"> example </a> <br>
-->

<?php echo $user_id; ?> <br>
<?php echo $user; ?> <br>
<?php echo $_SESSION[$session_var_name]; ?> <br>

<fb:like href="http://apps.facebook.com/tthtlcfb/" send="false" layout="button_count" width="450" show_faces="false" font="arial"></fb:like>

</html>
