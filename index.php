<?php

require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

/*
* CONFIGURATION
*/
$key = 'YOUR_API_KEY';
$fromName = 'SparkPost';
$fromEmailAddress = 'from@sparkpostbox.com';
$recipientName = 'Your name';
$recipientEmailAddress = 'you@email.com';
$subject = 'First Mailing From PHP';
$html = '<html><body><h1>Congratulations, {{name}}!</h1><p>You just sent your very first mailing!</p></body></html>';
$text = 'Congratulations, {{name}}!! You just sent your very first mailing!';
$name = 'YOUR FIRST NAME';

$httpAdapter = new Guzzle6HttpAdapter(new Client());
$sparky = new SparkPost($httpAdapter, ['key' => $key]);

try {
    $results = $sparky->transmission->send([
        'from' => $fromName . ' <' . $fromEmailAddress . '>',
        'html' => $html,
        'text' => $text,
        'substitutionData' => ['name' => $name],
        'subject' => $subject,
        'recipients' => [
            [
                'address' => [
                    'name' => $recipientName,
                    'email' => $recipientEmailAddress
                ]
            ]
        ]
    ]);
    echo 'Woohoo! You just sent your first mailing!';
} catch (\Exception $err) {
    echo 'Whoops! Something went wrong';
    var_dump($err);
}