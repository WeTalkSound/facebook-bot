<?php

namespace App\Actors;

use App\Models\Converser;


class MenuActor extends Actor
{
    protected $menus = [
        'blog'             => BlogActor::class,
        'music'            => MusicActor::class,
        'community'        => CommunityActor::class,
        'mailing list'     => EmailActor::class
    ];

    /**
     * should talk
     */
    public static function shouldTalk(Converser $converser, string $message): bool
    {
        $conversation = $converser->conversation()->latest()->first();

        return $conversation && $conversation->actor == static::class;
    }

     /**
     * Converse
     * @return string
     */
    public function talk()
    {
        if (! in_array($this->message, array_keys($this->menus))) {
            return $this->call(SaluteActor::class);
        }

        return $this->call($this->menus[$this->message]);
    }
}