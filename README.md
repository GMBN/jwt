# Simple jwt class
Simple class PHP to encode and decode token JWT
...

```php
<?php
require_once "JWT.php";
/*
 * ==============
 * set private key JWT to generate token
 */
define('KEY_JWT','your key here');
/*
 * ==============
 * generate JWT Token
  */
$data= [
    'id_user'=>48,
    'name'=>'My Name',
    'mail'=>'test@gmail.com'
];
$token = JWT::encode($data);
echo $token;
echo "<br />";
/*
 * ==============
 * check token is valid
  */
$valid = JWT::isValid($token);
if($valid){
    echo 'OK';
}else{
    echo 'ERROR';
}
echo "<br />";
/*
 * ==============
 * get Data from JWT token
  */
$decode = JWT::getData($token);
print_r($decode);
