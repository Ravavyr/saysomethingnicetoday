<?php
error_reporting(0);
//https://github.com/dg/twitter-php/
require_once('dg-twitter/index.php');
//Insert API and access keys here.
require_once('keys.php');
use DG\Twitter\Twitter;
$twitter = new Twitter($apiKey, $apiSecret, $accessToken, $accessTokenSecret);
//Handling quotes.
$quotes_url = json_decode(file_get_contents('https://saysomethingnice.today/compliments.json'), true);
$response = array();
$_POST = json_decode(file_get_contents('php://input'), true);
if(isset($_POST['username']) && isset($_POST['compliment']))
{
    if(empty($_POST['username']))
    {
        $response[] = 'No twitter username';
    }
    if(empty($_POST['compliment']))
    {
        $response[] = 'No compliment added';
    }
    $compliment = $_POST['compliment'];
    //Check if the compliment is in the json
    for($i = 0; $i < sizeof($quotes_url); $i++)
    {
        if($quotes_url[$i]['id'] == $compliment)
        {
            $compliment_msg = $quotes_url[$i]['compliment'];
            break;
        }
    }
    if(!isset($compliment_msg))
    {
        $response[] = 'Compliment not found';
    }
    $tw_username = $_POST['username'];
    if(substr($tw_username, 0,1) !== '@')
    {
        $tw_username = '@'.$tw_username;
    }
    //remove extra from username
    $tw_username = explode(' ', $tw_username);
    $tw_username = $tw_username[0];
    //validate username
    try
    {
        $twitter->loadUserInfo($tw_username);
    }
    catch (DG\Twitter\Exception $e)
    {
        $response[] = 'Invalid twitter username';
    }
    //end validation
    if(sizeof($response) > 0)
    {
        echo json_encode($response);
    }
    else
    {
        //All okay send tweet.
        $full_message = 'Someone wanted to say something nice to you today '.$tw_username.': "'.$compliment_msg.'"';
        if(strlen($full_message) > 280)
        {
            $full_message = ''.$tw_username.': "'.$compliment_msg.'"';
        }
        try
        {
            $statuses = $twitter->send($full_message);
            $response[] = 'Success';
            http_response_code(200);
            echo json_encode($response);
        }
        catch (DG\Twitter\Exception $e)
        {
            http_response_code(400);
            echo "Error: ", $e->getMessage();
        }
    }
}
else
{
    $response[] = 'Required form fields not received.';
    echo json_encode($response);
}
?>