<?php

namespace App\Actors;

use App\Models\Converser;
use App\Models\Conversation;


class SaluteActor extends Actor
{
    /**
     * should talk
     */
    public static function shouldTalk(Converser $converser, string $message): bool
    {
        return $converser->conversation == null;
    }

     /**
     * Converse
     * @return string
     */
    public function talk()
    {
        return with("Heyyy! Welcome to WeTalkSound. How are you today?", 
            [$this, "getQuickReplyMenu"]
        );
    }
}