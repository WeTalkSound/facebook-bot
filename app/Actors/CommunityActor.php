<?php

namespace App\Actors;

use App\Models\Converser;


class CommunityActor extends Actor
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
        return with("t.me/wetalksound", [$this, "getQuickReplyMenu"]);
    }
}