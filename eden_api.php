<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// Your Eden AI API key
$apiKey = '';

// Get the text input from the POST request
$text = $_POST['prompt'] ?? '';

if (!empty($text)) {
    try {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.edenai.run/v2/image/generation', [
            'body' => json_encode([
                'response_as_dict' => true,
                'attributes_as_list' => false,
                'show_original_response' => false,
                'resolution' => '512x512',
                'num_images' => 2,
                'providers' => 'openai,deepai,stabilityai',
                'text' => $text,
            ]),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $apiKey,
                'content-type' => 'application/json',
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        $deepaiItems = $responseData['deepai']['items'];
        $imageURL = $deepaiItems[0]['image_resource_url'];

        // Prepare the response data
        $responseData = [
            'status' => 'success',
            'imageURL' => $imageURL
        ];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
        
    } catch (RequestException $e) {
        $error = $e->getMessage();

        // Prepare the error response
        $responseData = [
            'status' => 'error',
            'error' => $error
        ];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
    }
} else {
    // Prepare the error response
    $responseData = [
        'status' => 'error',
        'error' => 'Text input is empty.'
    ];

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
}
?>