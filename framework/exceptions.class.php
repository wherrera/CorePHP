<?php
/**
 * @author wherrera
 */
class BadRequestException extends Exception {
    public function BadRequestException () {
        $this->code = 400;
        $this->message = 'Bad Request';
    }
}

class ServiceUnavailableException extends Exception {
    public function ServiceUnavailableException () {
        $this->code = 503;
        $this->message = 'Service Unavailable';
    }
}