<?php
// src/Download.php

class Download {
    public static function downloadContent($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function downloadFile($url, $savePath) {
        $fp = fopen($savePath, 'w+');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
}
