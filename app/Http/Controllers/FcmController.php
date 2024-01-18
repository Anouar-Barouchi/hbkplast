<?php

namespace FleetCart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\User\Entities\User;


class FcmController extends Controller
{
    public static function notifyUsers($tokens = [], $title, $body)
    {
        if (count($tokens) == 0) {
            $tokens = User::whereNotNull('device_token')->pluck('device_token')->unique();
        }
        $deviceToken = 'dbc1qSNKSUe-qRM502S7I5:APA91bGRXYCFtEtDjFT5zgaM3fg4UDQsuggfDbeBICRLJ1Sz0cRqxVjUtSYVKzxl511hHCdsnQnaVAKuPrsZdQXoJP9TNndWrByP141nIl8qUdqAGwmHZUdcjYXAamRlKXsiFA8Kcb93';
        $serverKey = 'AAAAPPRYGLo:APA91bEM4pF3DvNqrXnNwYIFANpidUUttayzXqUVj5zyejj386oR4s75mCH0KdsJBGVINymyHIdl7_unHHVEMgoyWiJIZytxn87FlMsi8vMx8aVPG1E7p9em0YFk4PgILm8d5Q9Tgs5L';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=' . $serverKey,
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $deviceToken,
            'notification' => [
                'body' => 'Enjoy with hbk plast',
                'OrganizationId' => '2',
                'content_available' => true,
                'priority' => 'high',
                'subtitle' => 'Elementary School',
                'title' => 'Bonjour a tous',
            ],
        ]);

        return;
    }
}
