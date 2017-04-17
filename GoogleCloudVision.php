<?php
require_once('./CurlRequest.php');

class GoogleCloudVision
{
    private $uri = 'https://vision.googleapis.com/v1/images:annotate';
    function __construct($key)
    {
        $this->key = $key;
    }

    public function request($image_url)
    {
        $parameters = array(
            'key' => $this->key
        );

        $header = array(
            'Content-Type: application/json'
        );

        $body = array(
            'requests' => array(
                array(
                    'image' => array(
                        'content' => base64_encode(file_get_contents($image_url)),
                    ),
                    'features' => array(
                        array(
                            'type' => 'TEXT_DETECTION',
                            'maxResults' => '10',
                        ),
                    ),
                ),
            ),
        );

        $opt = array(
            //curl options
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_VERBOSE => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($body)
        );

        $client = new CurlRequest($this->uri);
        return $client->request($parameters, $opt);
    }
}

 ?>
