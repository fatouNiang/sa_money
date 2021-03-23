<?php

namespace App\Services;

use Twilio\Rest\Client;
 //use Twilio\Http\Client;
 //use Twilio\TwiML\Voice\Client;
// use GuzzleHttp\Client;
// use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

class UserService
{

    public function uploadImage( $request){
        $avatar = $request->files->get("avatar");
        if($avatar){
            
            $avatarBlob = fopen($avatar->getRealPath(),"rb");
            return $avatarBlob;
        }
    return null;

    }

    public function validate(){
        
        return true;
    }


    public function CreerMatricule($nom=10)
    {

        $num=intval(uniqid(rand(100,999)));
        $cc=substr( $nom, 0,2);
        return date('Y').strtoupper($cc).$num.rand(0,9);
    }

    public function sendSMS($montant, $nomComplet, $code){
        $sid = "ACad2d554b715af05619f5aa08484a1a13"; // Your Account SID from www.twilio.com/console
        $token = "d6c8e13ce00bf183c2a4ca006dd3aab2"; // Your Auth Token from www.twilio.com/console
        
        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
          '779184216', // Text this number
          [
            'from' => '+12675363999', // From a valid Twilio number
            'body' => 'vous avez reçu une somme de '.$montant.' fcfa de '.$nomComplet.' votre code est '.$code
          ]
        );
        
        print $message->sid;
    }
}

