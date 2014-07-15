<?php

namespace Bws\Interactor;

class LoginResponse
{
    const SUCCESS                 = 1;
    const FAILURE                 = 0;
    const WRONG_PASSWORD_BIRTHDAY = -1;
    const WRONG_PASSWORD          = -2;
    const WRONG_EMAIL_ADDRESS     = -3;

    public $code;
    public $messages = array();

    public $customerId;
    public $display;
}
