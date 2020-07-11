<?php

namespace App\Actors;

use App\Models\Converser;
use App\Models\Conversation;
use App\Contracts\Actor as ActorContract;

abstract class Actor implements ActorContract
{
    /**
     * @var Converser
     */
    protected $converser;

    /**
     * @var string
     */
    protected $message;

    public function __construct($converser, $message)
    {
        $this->converser = $converser;
        $this->message = $message;
    }

    /**
     * Call Actor from within an actor
     * @param string $actor
     * @param mixed $data
     * @return string $convo
     */
    protected function call(string $actor)
    {
        $actor = new $actor($this->converser, $this->message);
        return $actor->talk();
    }

    public function getConverser(): Converser
    {
        return $this->converser;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function endConversation()
    {
        $this->converser->conversation->delete();
    }

    public function getQuickReplyMenu($message)
    {
        $this->createMenuConversation();

        return [ 
            $message => [ 
                [
                    "content_type" => "text",
                    "title" => "Blog",
                    "payload" => 'blog'
                ], [
                    "content_type" => "text",
                    "title" => "Music",
                    "payload" => 'music'
                ], [

                    "content_type" => "text",
                    "title" => "Community",
                    "payload" => 'community'
                ],
                    [

                    "content_type" => "text",
                    "title" => "Mailing List",
                    "payload" => 'email'
                    ]
                ]
            ];
    }

    public function createMenuConversation()
    {
        $this->createConversation(MenuActor::class);
    }

    public function createConversation($actor)
    {
        Conversation::updateOrCreate(['converser_id' => $this->converser->id],[
            'actor' => $actor,
            'refering_actor' => static::class
        ]);
    }
}