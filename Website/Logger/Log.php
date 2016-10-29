<?php

class Log {

    public static function logToErrFile($err) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $file = __DIR__ . '/'.$date.'.txt';
        
        $logTxt = '['.$time.'] >> '.$err;
        
        file_put_contents($file, $logTxt, FILE_APPEND | LOCK_EX);
    }
    
}