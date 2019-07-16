<?php namespace App\Http\Controllers\Api;

use App\Menu;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
    public function newOrderNotification($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);

        $chef = $menu->user;

        $tokens = [
            $chef->FMCToken
        ];

        $message = array("message" => "Message from server",
        "customKey" => "customValue");

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $tokens, //tokens
            //"condition" => "'dogs' in topics || 'cats' in topics",
            //"to" => "/topics/news",
            'data' => $message
        );

        $headers = array(
            'Content-Type: application/json',
            'Authorization:key=AAAAmsF3aT8:APA91bEo7gh2S5KYq3mKZBcd4E5Fl-rBbEeP6kS2SNZ5inCsCaoNLCC1ul9Tua40Et7SpzdEtr_MnbRNfInbI_y1SQxhJvoeWnWUlgRN1hLihiiqlw_8URbL-1Vq6BKVdBsXIQHbHdK4'
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        dd($result);
        if ($result == FALSE)
            die('Curl failed: ' . curl_error($ch));

        curl_close($ch);

    }

    public function updateFMCTocken($user_id, $fmcTocken)
    {
        $user = User::findOrFail($user_id);

        $user->FMCToken = $fmcTocken;

        $user->save();

        return response()->json(["code" => 200], 200);

    }
}
