<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:50
 */
class token
{
    //generate a new token
    public static function generate(){
        return session::put(config::get('session/token_name'), md5(uniqid()));
    }

    // check if the token value supplied by the form value is equal to the session token
    public static function check($token){
        $tokenName = config::get('session/token_name');

        //if the token value supplied matches the session token, delete because it is no longer needed
        if (session::exists($tokenName) && $token === session::get($tokenName)){
            session::delete($tokenName);
            return true;
        }

        return false;
    }
}