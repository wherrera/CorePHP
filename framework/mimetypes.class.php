<?php
/**
 * @author wherrera
 */
class MimeTypes {
    public static function mimeContentType ($file) {
        if (function_exists('mime_content_type'))
        {
            return mime_content_type($file);
        }        
        else {
            return NULL;
        }
    }
}