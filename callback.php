<?php
/**
* Copyright 2016 LINE Corporation
*
* LINE Corporation licenses this file to you under the Apache License,
* version 2.0 (the "License"); you may not use this file except in compliance
* with the License. You may obtain a copy of the License at:
*
*   https://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations
* under the License.
*/

require_once('./LINEBotTiny.php');
require_once('./GoogleCloudVision.php');
require_once('./Binary.php');

const LINE_CHANNEL_ACCESS_TOKEN = "your LINE channel acces token";  //LINE's Channel Access Token
const LINE_CHANNEL_SECRET = "your LINE secret";  //LINE's Channel Secret
const Google_Cloud_Vision_Key = "your Google Cloud Vision's key";  //Google Cloud Vision's key

$client = new LINEBotTiny(LINE_CHANNEL_ACCESS_TOKEN, LINE_CHANNEL_SECRET);

foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
        $message = $event['message'];
        switch ($message['type']) {
            case 'text':
            $client->replyMessage(text_message($event['replyToken'], $message['text'] . 'www'));
            break;

            case 'image':
            $image_binary = $client->get_content($event['message']['id']);
            Binary::save($image_binary, './', 'tmp.jpg');

            $gcv = new GoogleCloudVision(Google_Cloud_Vision_Key);
            $result = json_decode($gcv->request('./tmp.jpg'), true);

            $client->replyMessage(text_message($event['replyToken'], $result["responses"][0]["textAnnotations"][0]["description"]));
            break;


            default:
            error_log("Unsupporeted message type: " . $message['type']);
            break;
        }
        break;
        default:
        error_log("Unsupporeted event type: " . $event['type']);
        break;
    }
};

function text_message ($replyToken, $text)
{
    $array = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
    return $array;
}


?>
