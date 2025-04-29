<?php
$enable_pixel = $_settings->info('enable_pixel');
$facebook_access_token = $_settings->info('facebook_access_token');
$facebook_pixel_id = $_settings->info('facebook_pixel_id');
$enable_hide_numbers = $_settings->info('enable_hide_numbers');

function sendConversionEvent($event_name, $event_id, $event_time, $user_data, $custom_data) {
    global $facebook_pixel_id, $facebook_access_token;

    $url = "https://graph.facebook.com/v12.0/$facebook_pixel_id/events";

    $data = [
        'data' => [
            [
                'event_name' => $event_name,
                'event_time' => $event_time,
                'event_id' => $event_id,
                'user_data' => $user_data,
                'custom_data' => $custom_data,
                'action_source' => 'website',
            ]
        ],
        'access_token' => $facebook_access_token
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
