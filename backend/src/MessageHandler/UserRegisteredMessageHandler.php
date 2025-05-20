<?php

namespace App\MessageHandler;

use App\Message\UserRegisteredMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserRegisteredMessageHandler
{
    public function __invoke(UserRegisteredMessage $message)
    {
        // Tu możesz np. wysłać e-mail powitalny lub zapisać log
        file_put_contents('/app/var/log/user_registered.log', "Nowy użytkownik: " . $message->getEmail() . "\n", FILE_APPEND);
    }
}