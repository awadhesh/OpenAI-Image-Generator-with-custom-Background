<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

$open_ai_key = getenv('OPENAI_API_KEY');
$open_ai_key = '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';
$open_ai = new OpenAi($open_ai_key);
$prompt =$_REQUEST['prompt'];
$background =$_REQUEST['background'];
$style =$_REQUEST['style'];
$complete = $open_ai->completion([
    'model' => 'text-davinci-003',
    'prompt' => $prompt,
    'temperature' => 0.6,
    'max_tokens' => 25,
    'frequency_penalty' => 0,
    'presence_penalty' => 0.6,
]);
if(!empty($background)) $prompt = $prompt.'on a '.$background.' background';
if(!empty($style)) $prompt = $prompt.'in the style of '.$style;
$createImage = $open_ai->image([
    'prompt' => $prompt,
    'n' => 4,
    'size' => '256x256',
    
]);
//print_r($complete);
$data = json_decode($complete, TRUE);
$dataImage = json_decode($createImage, TRUE);
//print_r($data);
//print_r($data['choices'][0]['text']);

//print_r($createImage['data'][0]['url']);
$data = array("result" => $data['choices'][0]['text'],"resultImage" => $dataImage['data'][0]['url'],"resultImage_1" => $dataImage['data'][1]['url'],"resultImage_2" => $dataImage['data'][2]['url'],"resultImage_3" => $dataImage['data'][3]['url']);

header("Content-Type: application/json");
echo json_encode($data);
