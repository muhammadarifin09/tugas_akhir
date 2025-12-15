<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppMetaService
{
    protected $client;
    protected $phoneNumberId;
    protected $token;
    protected $graphVersion;

    public function __construct()
    {
        $this->graphVersion = env('META_GRAPH_VERSION', 'v17.0');
        $this->phoneNumberId = env('META_PHONE_NUMBER_ID');
        $this->token = env('META_ACCESS_TOKEN');

        $this->client = new Client([
            'base_uri' => "https://graph.facebook.com/{$this->graphVersion}/",
            'timeout' => 30,
        ]);
    }

    public function uploadMedia($filePath, $mime = 'image/png')
    {
        try {
            $response = $this->client->post("{$this->phoneNumberId}/media", [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}"
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => basename($filePath),
                        'headers' => ['Content-Type' => $mime]
                    ],
                ],
                'query' => ['access_token' => $this->token]
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body['id'] ?? null;
        } catch (\Exception $e) {
            Log::error('WA upload media error: '.$e->getMessage());
            return null;
        }
    }

    public function sendImageMessage($toPhone, $mediaId, $caption = null)
    {
        try {
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => ltrim($toPhone, '+'),
                'type' => 'image',
                'image' => ['id' => $mediaId]
            ];
            if ($caption) $payload['image']['caption'] = $caption;

            $response = $this->client->post("{$this->phoneNumberId}/messages", [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload,
                'query' => ['access_token' => $this->token]
            ]);

            return json_decode((string)$response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('WA send message error: '.$e->getMessage());
            return null;
        }
    }
}
