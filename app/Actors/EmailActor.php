<?php

namespace App\Actors;

use App\Models\Converser;
use Illuminate\Support\Facades\Validator;


class EmailActor extends Actor
{
    /**
     * should talk
     */
    public static function shouldTalk(Converser $converser, string $message): bool
    {
        $conversation = $converser->conversation;

        return $conversation && $conversation->actor == static::class;
    }

     /**
     * Converse
     * @return $message
     */
    public function talk()
    {
        if (static::shouldTalk($this->converser, $this->message)) {
            $message = $this->saveEmail();

            return with($message, [$this, "getQuickReplyMenu"]);
        }

        $this->createConversation(static::class);
        return "What's your email?";
    }

    protected function isValidEmail()
    {
        $validator = Validator::make(
            ['email' => $this->message], 
            ['email' => 'email']
        );

        return $validator->passes();
    }

    protected function saveEmail()
    {
        if (! $this->isValidEmail()) {
            return "Hmmm... This doesnt seem like a valid email!";
        }

        $this->converser->update(['name' => $this->message]);
        return "That's awesome! I've saved your email";
    }
}