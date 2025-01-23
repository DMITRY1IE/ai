<?php

namespace App\Services;

use OpenAI;
class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.api_key'));
    }

    public function askQuestionWithContext(array $history): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $history,
        ]);

        return $response['choices'][0]['message']['content'];
    }
}
