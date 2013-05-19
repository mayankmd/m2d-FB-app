<?php 
/* 
 This script is written by mayank mohan dass.
 Github- mayankmd
 Feel free to use it the way you want.
 Please mention me if you use this script as it is in your application
 This script utilizes Sketch.js for drawing purpose.
*/
?>
<html>
<head>
    <title>Sketch.js - Simple Canvas-based Drawing for jQuery</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="sketch.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Yellowtail|Open+Sans:400italic,700italic,400,700" rel="stylesheet" type="text/css">

    <style type="text/css">
	body { font-family: "Open Sans", sans-serif; color: #444; }

	#wrapper { width: 800px; margin: 0 auto; }

	#message {
		font-size:20px;
		font-color:gray;
	}

	article canvas { border: 2px solid #ccc;}

	pre.source {
		background: #e5eeee;
		padding: 10px 20px;
		width: 760px;
		overflow-x: auto;
		border: 1px solid #acc;
	}

	code { background: #cff; }

	.tools { margin-bottom: 10px; }
	
	.tools a {
		font-size:12px;
		border: 1px solid black; 
		height: 30px; line-height: 30px; 
		padding: 0 10px; vertical-align: middle; 
		text-align: center; 
		text-decoration: none; 
		display: inline-block; 
		color: black; 
		font-weight: bold;
      }
    </style>
  <script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>
  <script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>
  <script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>
  <script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>
 </head>
<body>
	<div id="wrapper">
		<div id="message">
		<h5>Draw something on this Canvas using provided tools and publish it to your facebook wall</h5>
		</div>
		<article class="example">
			<div class="demo" id="colors_demo">
				<div class="tools">
					<a href="#colors_sketch" data-download="png" style="float: right; width: 100px;background: #222; color:white">Publish</a>
					<a href="#colors_sketch" data-size="2" data-tool="eraser" style='background: #222; color:white'>Eraser</a>
					<a href="#colors_sketch" data-size="5" data-tool="eraser" style='background: #eee'>1x</a>
					<a href="#colors_sketch" data-size="25" data-tool="eraser"style='background: #eee'>5x</a>
					<a href="#colors_sketch" data-size="1" data-tool="marker" style='background: #222; color:white'>Pen</a>
				</div>
				<canvas id="colors_sketch" width="800" height="300"></canvas>
				<script type="text/javascript">
					$(function() {
					$.each(['3x', '5x', '10x', '15x'], function() {
					$('#colors_demo .tools').append("<a href='#colors_sketch' data-size='" + this + "' data-tool='marker' style='background: #eee'>" + this + "</a> ");
					});
					$.each(['#f00', '#ff0', '#0f0', '#0ff', '#00f', '#f0f', '#000', '#fff'], function() {
					$('#colors_demo .tools').append("<a href='#colors_sketch' data-color='" + this + "' data-tool='marker' style='width: 10px; background: " + this + ";'></a> ");
					});
					$('#colors_sketch').sketch();
					$('#colors_sketch').sketch({defaultColor: '#ff0'});
					});
				</script>
			</div>
		</article>
	</div>
	<div>
		<?php
			require 'src/facebook.php'; // location of facebook php sdk - set it.

			// Create our Application instance (replace this with your appId and secret).

			$facebook = new Facebook(array('appId'  => '603591609651395','secret' => '74858ba23f4c6c24e72a1b24803f5b0a',));

			//--------------------------------------------------------------------------

			// Get User ID
			$user=$facebook->getUser(); 

			// We may or may not have this data based on whether the user is logged in.
			//
			// If we have a $user id here, it means we know the user is logged into
			// Facebook, but we don't know if the access token is valid. An access
			// token is invalid if the user logged out of Facebook.

			if ($user) 
				{
					try 
						{
						// Proceed knowing you have a logged in user who's authenticated.
							$me = $facebook->api('/me');
						}
					catch (FacebookApiException $e) 
						{
							$me = NULL;
						}
				}
			// Login or logout url will be needed depending on current user state.
			if ($user)
				{
				  $logoutUrl = $facebook->getLogoutUrl();
				  //echo '<div><a href="'.$logoutUrl.'">Logout</a></div>';
				} 
			else 
				{
				  $loginUrl = $facebook->getLoginUrl();
				  echo '<div><a href="'.$loginUrl.'">Login with Facebook</a></div>';
				}

			// if there is no logged in user or user is not authenticated, it will redirect the user to facebook for authentication.
			if ( is_null($me) ) 
				{
				  $auth_url = $facebook->getLoginUrl(array('scope' => 'publish_actions,read_stream,publish_stream,user_photos,photo_upload'));

				  header("Location: $auth_url");
				}
		?>
	</diV>
</body>
</html>