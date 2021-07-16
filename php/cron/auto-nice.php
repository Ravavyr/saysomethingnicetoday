<?php
//Automated messages sent with random time gap in between.
ini_set('max_execution_time', 0);
set_time_limit(0);

require_once('../keys.php');
require_once('../dg-twitter/index.php');
$quotes_url = json_decode(file_get_contents('https://saysomethingnice.today/compliments.json'), true);
function get_random_quote($quotes_url)
{
    shuffle($quotes_url);
    return $quotes_url[0]['compliment'];
}
//Add more if you would like
$keywords = array('#myfirsttweet', 'cat', 'dog', 'nature');
shuffle($keywords);
$search_for = $keywords[0];
$statuses = $twitter->request('search/tweets', 'GET', [
    'count' => 10,
    'q' => $search_for,
    'result_type' => 'recent',
]);
$statuses = $statuses->statuses;
for($i = 0; $i < sizeof($statuses); $i++)
{
    sleep(rand(12,5400));
    $username = $statuses[$i]->user->screen_name;
    $quote = get_random_quote($quotes_url);
    $message = '@'.$username.': '.$quote.' ~ Someone nice.';
    $statuses = $twitter->send($message);
}
?>