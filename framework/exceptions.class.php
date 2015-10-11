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

class InvalidControllerException extends Exception {
    public function InvalidControllerException ( $name ) {
        $this->code = 400;
        $this->message = 'Invalid Controller ' . $name;
    }
}

class ServiceUnavailableException extends Exception {
    public function ServiceUnavailableException () {
        $this->code = 503;
        $this->message = 'Service Unavailable';
    }
}

class InternalServerErrorException extends Exception {
    public function InternalServerErrorException () {
        $this->code = 500;
        $this->message = 'Internal Server Error';
    }
}