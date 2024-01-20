<?php
use FleetCart\Device;
use Illuminate\Support\Facades\Http;
use Modules\User\Entities\User;

if (! function_exists('permission_value')) {
    /**
     * Get the integer representation value of the permission.
     *
     * @param array $permissions
     * @param string $permission
     * @return int
     */
    function permission_value(array $permissions, $permission)
    {
        $value = array_get($permissions, $permission);

        if (is_null($value)) {
            return 0;
        } elseif ($value) {
            return 1;
        } elseif (! $value) {
            return -1;
        }
    }
}


if (! function_exists('notify_users')) {
    function notify_users($title, $body, $tokens = [])
    {
        if (count($tokens) == 0) {
            $tokens = Device::pluck('device_token')->merge(User::whereNotNull('device_token')->pluck('device_token'))->unique();
        }
        
        foreach ($tokens as $token) {
            $serverKey = env('FCM_SERVER_KEY');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'key=' . $serverKey,
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $token,
                'notification' => [
                    'body' => $body,
                    'OrganizationId' => '2',
                    'content_available' => true,
                    'priority' => 'high',
                    'title' => $title,
                ],
            ]);
        }

        return;
    }
}
