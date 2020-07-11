<?php

namespace App\Actors;

use App\Models\Converser;


class MusicActor extends Actor
{
    /**
     * should talk
     */
    public static function shouldTalk(Converser $converser, string $message): bool
    {
        return false;
    }

     /**
     * Converse
     * @return string
     */
    public function talk()
    {
        return with("fanlink.to/LOFN3", [$this, "getQuickReplyMenu"]);
    }
}