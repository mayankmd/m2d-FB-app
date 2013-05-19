<?php

//----------------------------------------------------------------------------------------------------------
//this script reads a POST data stream sent from sketch.js and save it to a png file
//----------------------------------------------------------------------------------------------------------

// reads a input data stream posted by a page using POST method
	$fg = file_get_contents("php://input");
	
// for this app we get base64 encoded png image as a string with "data:image/png;base64" text in it
// so we remove this "data:image/png;base64" using ltrim() -- trims string from left side
	
	$tr=ltrim($fg,"data:image/png;base64");
	
// decode the remaining string in base64

	$data = base64_decode($tr);
	
// save this data into a specified file
	$rand = rand(1, 99999); 
	$file = $rand.'.png';//UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	echo $success ? $file : 'Unable to save the file.';	
	
//----------------------------------------------------------------------------------------------------------
// this script uploads a photo to a user's facbook wall
//----------------------------------------------------------------------------------------------------------


// location of facebook php sdk.
require 'src/facebook.php'; 

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
/* Login or logout url will be needed depending on current user state.
if ($user) 
	{
	  $logoutUrl = $facebook->getLogoutUrl();
	} 
else 
	{
	  $loginUrl = $facebook->getLoginUrl();
	}
*/


// if there is no logged in user or user is not authenticated, it will redirect the user to facebook for authentication.
if ( is_null($me) ) 
	{
	  $auth_url = $facebook->getLoginUrl(array('scope' => 'publish_stream,photo_upload'));

	  header("Location: $auth_url");
	}

// upload photo to a user's facebook account.	
try 
	{
        $facebook->setFileUploadSupport(true);
        $response = $facebook->api('/me/photos?privacy={"value":"ALL_FRIENDS"}','post', // privacy parameter set for all friends
          array(
            'message' => 'this app is working',
            'source' => '@'.$file // @-sign must be the first character
          )
        );
		print_r($response); // provides the id of new post and image.
    }
	
catch (FacebookApiException $e) 
	
	{
		error_log('Could not post image to Facebook.');
		print_r($e);
	}
?>