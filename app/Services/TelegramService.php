<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Send a document to a Telegram user via the Bot API
     *
     * @param string $botToken The Telegram bot token
     * @param string $userId The Telegram user ID to send the document to
     * @param string $filePath The full filesystem path to the file
     * @param string|null $caption Optional caption for the document
     * @return bool Returns true if successful, false otherwise
     */
    public static function sendDocument(string $botToken, string $userId, string $filePath, ?string $caption = null): bool
    {
        try {
            $url = "https://api.telegram.org/bot{$botToken}/sendDocument";

            $response = Http::attach(
                'document',
                file_get_contents($filePath),
                basename($filePath)
            )->post($url, [
                'chat_id' => $userId,
                'caption' => $caption ?? 'Sales Report',
            ]);

            if ($response->successful() && $response->json('ok')) {
                return true;
            }

            Log::error('Telegram API Error', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Telegram Send Document Exception', [
                'message' => $e->getMessage(),
                'file' => $filePath,
            ]);

            return false;
        }
    }
}
