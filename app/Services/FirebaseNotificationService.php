<?php
namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use Google_Client as GoogleClient;
use Illuminate\Support\Facades\Log;
use Exception;

class FirebaseNotificationService
{
    // protected $credentialsPath;

    // public function __construct()
    // {
    //     $this->credentialsPath = storage_path('app/dentil-dinar.json');
    // }

    // /**
    //  * Send a notification to Firebase using FCM
    //  *
    //  * @param string $title
    //  * @param string $body
    //  * @return void
    //  * @throws Exception
    //  */
    // public function sendNotification($title, $body)
    // {
    //     if (!file_exists($this->credentialsPath)) {
    //         Log::error('Firebase credentials file missing', ['path' => $this->credentialsPath]);
    //         throw new Exception(trans('dashboard.firebase_credentials_missing'));
    //     }

    //     try {
         
    //         $client = new GoogleClient();
    //         $client->setAuthConfig($this->credentialsPath);
    //         $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    //         // Authenticate and get access token
    //         $client->refreshTokenWithAssertion();
    //         $accessToken = $client->getAccessToken();

    //         if (empty($accessToken['access_token'])) {
    //             throw new Exception(trans('dashboard.firebase_token_missing'));
    //         }

     
    //         $payload = [
    //             'message' => [
    //                 'topic' => 'test',
    //                 'notification' => [
    //                     'title' => $title,
    //                     'body' => $body,
    //                 ],
    //                 'android' => [
    //                     'priority' => 'high',
    //                 ],
    //                 'apns' => [
    //                     'payload' => [
    //                         'aps' => [
    //                             'category' => 'new_notification',
    //                         ],
    //                     ],
    //                 ],
    //             ],
    //         ];

    //         // Send the request
    //         $httpClient = new GuzzleClient();
    //         $response = $httpClient->post('https://fcm.googleapis.com/v1/projects/test/messages:send', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $accessToken['access_token'],
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => $payload,
    //         ]);

    //         // Log success response
    //         Log::info('Firebase Notification Sent Successfully', [
    //             'title' => $title,
    //             'response' => json_decode($response->getBody()->getContents(), true),
    //         ]);
    //     } catch (Exception $e) {
    //         // Log error details
    //         Log::error('Firebase Notification Error: ' . $e->getMessage(), [
    //             'title' => $title,
    //             'body' => $body,
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         throw $e;
    //     }
    // }
}
