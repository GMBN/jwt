<?php

class JWT {

    const KEY = KEY_JWT;

    static function encode($data,$expire = false) {
       
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = json_encode($header);
        $header = self::base64url_encode($header);

        $issuedAt = time();
        //payload
        $payload = $data;
        $payload['iat'] = $issuedAt;
        
        if($expire){
            $payload['exp'] = $issuedAt + $expire;
        }
        
        $payload = json_encode($payload);
        $payload = self::base64url_encode($payload);

        //signature
        $signature = hash_hmac('sha256', "$header.$payload", self::KEY, true);
        $signature = self::base64url_encode($signature);

        return "$header.$payload.$signature";
    }
    
    
    static function getData($token){
        $part = explode(".",$token);
        $payload = $part[1];
        
        return json_decode(self::base64url_decode($payload),1);
    }
    
    static function isValid($token){
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload", self::KEY,true);
        $valid = self::base64url_encode($valid);

        if($signature === $valid){
            return true;
        }else{
           return false;
        }

    }

    private static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}
