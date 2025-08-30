<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Http;

class TelegramLogger extends AbstractProcessingHandler
{
    protected $botToken;
    protected $chatId;

    public function __construct($level = Logger::ERROR, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    protected function write(LogRecord $record): void
    {
        $message = "*Laravel Error Log*\n";
        $message .= "*Level:* {$record->level->name}\n";
        $message .= "*Message:* " . $record->message . "\n";

        if (!empty($record->context)) {
            $message .= "*Context:* " . json_encode($record->context, JSON_PRETTY_PRINT) . "\n";
        }

        $message .= "*Time:* " . $record->datetime->format('Y-m-d H:i:s');

        Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);
    }
}
