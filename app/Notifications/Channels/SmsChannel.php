<?php


namespace App\Notifications\Channels;


use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification){
        if(!method_exists($notification, 'toSMS')){
            throw  new \Exception('toSMS not found');
        }
        $data = $notification->toSMS($notifiable);
        $content = $data['text'];
        $phone = $data['number'];
        $apiKey = config('services.sms.key');


        try
        {
            $message = $content;
            $lineNumber = "10008566";
            $receptor = $phone;
            $api = new \Ghasedak\GhasedakApi($apiKey);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(ApiException $e){
            echo $e->errorMessage();
        }
        catch(HttpException $e){
            echo $e->errorMessage();
        }
    }

}
