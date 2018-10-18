<?php

namespace Libraries;

class Uploader
{
    public static function upload($incomingFile, string $subdirectory, string $fileType = '')
    {
        // var_dump($incomingFile);
        if (empty($incomingFile)) {
            throw new \Exception('Cannot upload null file');
        }

        if ($fileType == 'image') {
            $verifyImg =  getimagesize($incomingFile['tmp_name']);

            if (!preg_match('#^(image/)[^\s\n<]+$#i', $verifyImg['mime'])) {
                throw new \Exception('Only image files are accepted');
            }
        }

        $fileExtension = @strtolower(end(explode('.', $incomingFile['name'])));

        $randomFileName = strtolower(bin2hex(openssl_random_pseudo_bytes(17, $cstrong))) . '.' . $fileExtension;
        
        $filePath = 'uploads' .$subdirectory . $randomFileName;

        if (move_uploaded_file($incomingFile['tmp_name'], $filePath)) {
            return $filePath;
        } else {
            throw new \Exception($incomingFile['error']);
        }
    }

    public static function getFile()
    {
        //
    }
}
