<?php
//Once fer hour should be fine
require_once('../keys.php');
require_once('../dg-twitter/index.php');
function get_random_quote()
{
    $quotes_url = json_decode(file_get_contents('https://saysomethingnice.today/compliments.json'), true);
    shuffle($quotes_url);
    return $quotes_url[0]['compliment'];
}
//Add more if you would like
$keywords = array('#myfirsttweet', 'cat', 'dog', 'nature');
shuffle($keywords);
$search_for = $keywords[0];
$statuses = $twitter->request('search/tweets', 'GET', [
    'count' => 20,
    'q' => $search_for,
    'result_type' => 'recent',
]);
$statuses = $statuses->statuses;
for($i = 0; $i < sizeof($statuses); $i++)
{
    $usernames = $statuses[$i]->user->screen_name;
    $quote = get_random_quote();
    $message = '@'.$usernames.': '.$quote.' ~ Someone nice.';
    $statuses = $twitter->send($message);
}
?>