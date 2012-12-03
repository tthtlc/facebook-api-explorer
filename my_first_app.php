<?php

/**
 * This sample app is provided to kickstart your experience using Facebook's
 * resources for developers.  This sample app provides examples of several
 * key concepts, including authentication, the Graph API, and FQL (Facebook
 * Query Language). Please visit the docs at 'developers.facebook.com/docs'
 * to learn more about the resources available to you
 */

// Provides access to app specific values such as your app id and app secret.
// Defined in 'AppInfo.php'
require_once('AppInfo.php');

// Enforce https on production
if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
  header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}

// This provides access to helper functions defined in 'utils.php'
require_once('utils.php');


/*****************************************************************************
 *
 * The content below provides examples of how to fetch Facebook data using the
 * Graph API and FQL.  It uses the helper functions defined in 'utils.php' to
 * do so.  You should change this section so that it prepares all of the
 * information that you want to display to the user.
 *
 ****************************************************************************/

require_once('facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
));

$user_id = $facebook->getUser();
if ($user_id) {
  try {
    // Fetch the viewer's basic information
    $basic = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    // If the call fails we check if we still have a user. The user will be
    // cleared if the error is because of an invalid accesstoken
    if (!$facebook->getUser()) {
      header('Location: '. AppInfo::getUrl($_SERVER['REQUEST_URI']));
      exit();
    }
  }

  // This fetches some things that you like . 'limit=*" only returns * values.
  // To see the format of the data you are retrieving, use the "Graph API
  // Explorer" which is at https://developers.facebook.com/tools/explorer/
  $likes = idx($facebook->api('/me/likes?limit=4'), 'data', array());

  // This fetches 4 of your friends.
  $friends = idx($facebook->api('/me/friends?limit=4'), 'data', array());

  // And this returns 16 of your photos.
  $photos = idx($facebook->api('/me/photos?limit=16'), 'data', array());

  // Here is an example of a FQL call that fetches all of your friends that are
  // using this app
  $app_using_friends = $facebook->api(array(
    'method' => 'fql.query',
    'query' => 'SELECT uid, name FROM user WHERE uid IN(SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1'
  ));
}

// Fetch the basic info of the app that they are using
$app_info = $facebook->api('/'. AppInfo::appID());

$app_name = idx($app_info, 'name', '');

?>
<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
  <meta property="fb:app_id" content="YOUR_APP_ID" /> 
  <meta property="og:type"   content="object" /> 
  <meta property="og:url"    content="Put your own URL to the object here" /> 
  <meta property="og:title"  content="Sample Object" /> 
  <meta property="og:image"  content="https://s-static.ak.fbcdn.net/images/devsite/attachment_blank.png" /> 
    <!-- <script src="/javascript/track.js" type="text/javascript"></script> -->

    <title>my first page </title>

    <link rel="stylesheet" href="/style/demo.css">

</head>
<body>

<!-- xfbml -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
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

<script type="text/javascript" src="/javascript/menu.js"></script>
<script type="text/javascript" src="/javascript/build/caat.js"></script>
<script type="text/javascript" src="/javascript/startup-wo-splash/template.js"></script>

<script type="text/javascript">
    /**
     * @license
     *
     * The MIT License
     * Copyright (c) 2010-2011 Ibon Tolosana, Hyperandroid || http://labs.hyperandroid.com/

     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:

     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.

     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     *
     */
    (function() {
        /**
         * Startup it all up when the document is ready.
         * Change for your favorite frameworks initialization code.
         */
        CAAT.DEBUG=1;
        window.addEventListener(
                'load',
                function() {
                    CAAT.modules.initialization.init(
                            800, 500,
                            'experiment-holder',
                            [
                                {id:'fish', url:'/images/img/anim2.png'},
                                {id:'score', url: "/images/img/numerospuntos.png"}
                            ],
                            __scene1
                            );
                },
                false);

        /**
         * Create an Actor for every available interpolator/easing function built in CAAT.
         * This Actors are indeed InterpolatorActor, an out-of-the-box scene actor which draws
         * a function.
         * Interpolators will be laid out in a OSX Dock fashion. To do so, there's an special
         * CAAT.Dock actor. This Docking element allows to define its direction, whether
         * horizontal or vertical, and the direction to anchor its contained elements zoom.
         *
         * @param director {CAAT.Director}
         * @param scene {CAAT.Scene}
         * @param pathBehavior {CAAT.PathBehavior} The path to modify traverse speed for.
         */
        function generateInterpolators(director, scene, pathBehavior) {

            var lerps = CAAT.Interpolator.prototype.enumerateInterpolators();

            /**
             * Lay interpolators out on 20 rows, and construct as much as Dock
             * elements to hold the whole collection of interpolators.
             */
            var cols = 20;
            var j = 0, i = 0;
            var rows = lerps.length / 2 / cols;
            var min = 20;
            var max = 45;
            var selectedInterpolatorActor = null;

            // generate interpolator actors.
            for (j = 0; j < rows; j++) {

                var root = new CAAT.Dock().
                        initialize(scene).
                        setBounds(
                            director.canvas.width - (j + 1) * max,
                            0,
                            max,
                            director.canvas.height).
                        setSizes(min, max).
                        setApplicationRange(3).
                        setLayoutOp(CAAT.Dock.prototype.OP_LAYOUT_RIGHT);

                scene.addChild(root);

                for (i = 0; i < cols; i++) {

                    if (j * cols + i >= lerps.length) {
                        break;
                    }

                    var actor = new CAAT.InterpolatorActor().
                            setInterpolator(lerps[(j * cols + i) * 2]).
                            setBounds(0, 0, min, min).
                            setStrokeStyle('blue');

                    actor.mouseExit = function(mouseEvent) {
                        if (this != selectedInterpolatorActor) {
                            this.setFillStyle(null);
                        }
                    }
                    actor.mouseEnter = function(mouseEvent) {
                        if (this != selectedInterpolatorActor) {
                            this.setFillStyle('#f0f0f0');
                        }
                    }
                    actor.mouseClick = function(mouseEvent) {
                        if (null != selectedInterpolatorActor) {
                            selectedInterpolatorActor.setFillStyle(null);
                        }
                        selectedInterpolatorActor = mouseEvent.source;
                        this.setFillStyle('#00ff00');
                        selectedInterpolatorActor = mouseEvent.source;

                        pathBehavior.setInterpolator(mouseEvent.source.getInterpolator());
                    }

                    root.addChild(actor);
                }

                root.layout();
            }
        }

        function __scene1(director) {

            var scene = director.createScene();

            var dw= director.width;
            var dh= director.height;


            var i;
            var R= (Math.min( dw,dh ) - 40)/2;
            var pp= [];
            var angle;
            var NP=7;
            for( i=0; i<NP; i++ ) {
                angle= i*Math.PI/(NP);

                pp.push( new CAAT.Point(
                        dw/2 + R*Math.cos(angle + (Math.PI*(i%2)) ) ,
                        dh/2 + R*Math.sin(angle + (Math.PI*(i%2))) ) );

            }

            var path= new CAAT.Path().
                setCatmullRom(
                    pp,
                    true
                ).
                endPath();

            var pa= new CAAT.PathActor().
                    setSize( director.width, director.height ).
                    setPath( path ).
                    setInteractive(true).
                    setOnUpdateCallback( function(path) {
                        var np = path.flatten(200, true);
                        text2.setPath(
                                np,
                                new CAAT.Interpolator().createLinearInterpolator(false),
                                20000)
                    });

            var fontScore= new CAAT.SpriteImage().
                initializeAsMonoTypeFontMap(
                    director.getImage("score"),
                    "0123456789,p/*-"
                );
            var text2 = new CAAT.TextActor().
                setFont( fontScore ).
                setText( "0123456789" ).
                setTextAlign("left").
                setTextBaseline("top").
                setPath(
                    path,
                    new CAAT.Interpolator().createLinearInterpolator(false),
                    20000).
                setPathTraverseDirection( CAAT.TextActor.TRAVERSE_PATH_BACKWARD );
            scene.addChild(text2);


            /**
             * Create a fish which will traverse the path.
             */
            var fish = new CAAT.Actor().
                    setBackgroundImage(
                            new CAAT.SpriteImage().
                                    initialize(director.getImage('fish'), 1, 3),
                            true).
                    setAnimationImageIndex([0,1,2,1]).
                    setChangeFPS(300).
                    enableEvents(false).
                    setId(111);

            fish.setPositionAnchor(.5, .5);

            // path measurer behaviour
            var pb = new CAAT.PathBehavior().
                    setPath(path).
                    setFrameTime(0, 20000).
                    setCycle(true).
                    setAutoRotate(true, CAAT.PathBehavior.autorotate.LEFT_TO_RIGHT);

            fish.addBehavior(pb);


            scene.addChild(pa);
            addDescription(director, scene);
            scene.addChild(fish);

            generateInterpolators(director, scene, pb);

            return scene;
        }

        function addDescription(director, scene) {
            var cc1 = new CAAT.ActorContainer().
                    setBounds(140, 80, 280, 110).
                    enableEvents(false);
            cc1.setPositionAnchor(.5,.5);
            scene.addChild(cc1);

            cc1.addBehavior(
                    new CAAT.RotateBehavior().
                            setCycle(true).
                            setFrameTime(0, 4000).
                            setValues(-Math.PI / 8, Math.PI / 8, .50, 0).    // anchor at 50%, 0%
                            setInterpolator(
                            new CAAT.Interpolator().createExponentialInOutInterpolator(3, true))
                    );

            var gradient = director.crc.createLinearGradient(0, 0, 0, 30);
            gradient.addColorStop(0, '#00ff00');
            gradient.addColorStop(0.5, 'red');
            gradient.addColorStop(1, 'blue');

            var text = new CAAT.TextActor().
                    setFont("20px sans-serif").
                    setText("Magdalene").
                    calcTextSize(director).
                    setTextFillStyle(gradient).
                    setOutline(true).
                    cacheAsBitmap();
            cc1.addChild(text.setLocation((cc1.width - text.textWidth) / 2, 0) );

            var text2 = new CAAT.TextActor().
                setFont("20px sans-serif").
                setText("Claire").
                calcTextSize(director).
                setTextFillStyle(gradient).
                setOutline(true).
                cacheAsBitmap();

            cc1.addChild(text2.setLocation((cc1.width - text2.textWidth) / 2, 20));

            var text4 = new CAAT.TextActor().
                    setFont("20px sans-serif").
                    setText("Terese").
                    calcTextSize(director).
                    setTextFillStyle(gradient).
                    setOutline(true).
                    cacheAsBitmap();
            cc1.addChild( text4.setLocation((cc1.width - text4.textWidth) / 2, 50) );

            var text3 = new CAAT.TextActor().
                    setFont("20px sans-serif").
                    setText("Jerome").
                    calcTextSize(director).
                    setTextFillStyle(gradient).
                    setOutline(true).
                    cacheAsBitmap();
            cc1.addChild(text3.setLocation((cc1.width - text3.textWidth) / 2, 70));
        };

    })();


</script>

<!--
<div class="fb-like" data-href="http://apps.facebook.com/tthtlcfb/" data-send="true" data-width="450" data-show-faces="true"></div>
-->

<fb:like href="http://apps.facebook.com/tthtlcfb/" send="false" layout="button_count" width="450" show_faces="false" font="arial"></fb:like>

The code for CAAT is extracted from Opensource software "Hyperandroid - CAAT": <br>

<a href="http://hyperandroid.github.com/CAAT/documentation/demos/demo1/path_org.html"> http://hyperandroid.github.com/CAAT/documentation/demos/demo1/path_org.html </a>

<!--
<a href="<?php echo $app_info; ?>">app_info</a>
<a href="<?php echo $user_id; ?>">user_id</a>
-->

</html>
