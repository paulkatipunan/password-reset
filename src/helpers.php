<?php

if (!function_exists('sendPasswordResetLink')) {
    /**
     * Help resize images regardless of image dimension then save
     *
     * @param file $file
     * @param int $size
     * @param string $filepath
     * @param string $filename
     * @return response
     */
    function sendPasswordResetLink($email)
    {   
      
        return redirect()->route('request.email', $email);

    }
}
