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
        http_response_code(400);
        $response['status'] = '400';
        $response['message'] = 'Twitter Username missing';
    }
    if(empty($_POST['compliment']))
    {
        http_response_code(400);
        $response['status'] = '400';
        $response['message'] = 'Compliment missing';
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
        http_response_code(400);
        $response['status'] = '400';
        $response['message'] = 'Compliment not found';
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
        header('HTTP/1.1 400 Invalid twitter username');
        $response['message'] = 'Invalid twitter username'+print_r($e,true);
    }
    //end validation
    if(sizeof($response) > 0)
    {
        echo json_encode($response);
        exit;
    }
    else
    {
        //All okay send tweet.
        $full_message = $tw_username.': "'.$compliment_msg.'" ~ Someone Nice';
        if(strlen($full_message) > 280)
        {
            $full_message = ''.$tw_username.': "'.$compliment_msg.'"';
        }
        try
        {
            $statuses = $twitter->send($full_message);
            http_response_code(200);
            $response['status'] = '200';
            $response['message'] = 'Success';
        }
        catch (DG\Twitter\Exception $e)
        {
            http_response_code(400);
            $response['status'] = '400';
            $response['message'] = $e->getMessage();
        }
    }
}
else
{
    $response['message'] = 'Required form fields not received.';
}
echo json_encode($response);
exit;
?>