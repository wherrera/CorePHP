<?php
/**
 * @author williamherrera
 */
class Logout extends Controller {
    public function execute () {
        Session::Destroy();
        $this->loadview('login.view');
    }
}
