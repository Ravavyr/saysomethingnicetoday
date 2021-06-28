<?php
require_once('OAuth.php');
require_once('Twitter.php');
use DG\Twitter\Twitter;
$twitter = new Twitter($apiKey, $apiSecret, $accessToken, $accessTokenSecret);
?>