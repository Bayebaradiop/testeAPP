<?php

namespace App\Service;

use App\Core\Singleton;
use Twilio\Rest\Client;

class SmsService
{
    use Singleton;

    public function sendSms(string $destinationNumber, string $message): void
    {
        $sid    = TWILIO_SID;
        $token  = TWILIO_TOKEN;
        $twilio = new Client($sid, $token);

        if (substr($destinationNumber, 0, 4) !== '+221') {
            $destinationNumber = '+221' . ltrim($destinationNumber, '0');
        }

        try {
            $twilio->messages->create(
                $destinationNumber,
                [
                    'from' => TWILIO_FROM,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            // Gestion d'erreur éventuelle
        }
    }
}
