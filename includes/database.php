<?php

$lokalno=false;

if($lokalno){
    $hostname="localhost";
    $username="cms";
    $password="geslo";
    $database="cms";
}else{
    if (!function_exists('get_db_credentials')) {
        function get_db_credentials($file_path) {
            $credentials = [];
            if (file_exists($file_path)) {
                $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    list($key, $value) = explode('=', $line, 2);
                    $credentials[trim($key)] = trim($value);
                }
            } else {
                die("Credentials file not found.");
            }
            return $credentials;
        }
    }
    
    $credentials_file = __DIR__ . '/dbCredentials.txt';
    $db_credentials = get_db_credentials($credentials_file);
    
    $hostname = $db_credentials['hostname'];
    $username = $db_credentials['username'];
    $password = $db_credentials['password'];
    $database = $db_credentials['database'];
    
}

?>
