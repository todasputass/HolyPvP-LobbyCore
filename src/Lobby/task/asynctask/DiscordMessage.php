<?php

namespace Lobby\task\asynctask;

use pocketmine\scheduler\AsyncTask;

class DiscordMessage extends AsyncTask
{

    /** @var String */
    protected string $webhook;

    /** @var String */
    protected string $username;

    /** @var String */
    protected string $message;

    /**
     * DiscordMessage Constructor.
     *
     * @param String $webhook
     * @param String $username
     * @param String $message
     */
    public function __construct(string $webhook, string $message, string $username)
    {
        $this->webhook = $webhook;
        $this->message = $message;
        $this->username = $username;
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function onRun(): void
    {
        $discord = curl_init();
        curl_setopt($discord, CURLOPT_URL, $this->webhook);
        curl_setopt($discord, CURLOPT_POSTFIELDS, json_encode(["content" => $this->message, "username" => $this->username], JSON_THROW_ON_ERROR));
        curl_setopt($discord, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($discord, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($discord, CURLOPT_SSL_VERIFYPEER, true);
        curl_exec($discord);
    }
}