<?php

namespace App\Services;

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

    // public function CreerMatricule($nom,$prenom)
    // {

    //     $num=intval(uniqid(rand(100,999)));
    //     $dernier=strlen($prenom);
    //     $avantDernier=$dernier-2;
    //     $cc=substr( $nom, 0,2);
    //     $ll=substr($prenom,$avantDernier,$dernier);

    //     return date('Y').strtoupper($cc).strtoupper($ll).$num.rand(0,9);
    // }
}