<?php

namespace Bws\Interactor;

use Bws\Repository\EmailAddressRepository;

class Login
{
    /**
     * @var EmailAddressRepository
     */
    private $emailRepository;

    /**
     * @param EmailAddressRepository $emailRepository
     */
    public function __construct(EmailAddressRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return LoginResponse
     */
    public function execute($email, $password)
    {
        $response = new LoginResponse();

        if (!$email = $this->emailRepository->findByAddress($email)) {
            $response->code       = LoginResponse::WRONG_EMAIL_ADDRESS;
            $response->messages[] = 'Please check your e-mail address again';
            return $response;
        }

        $customer = $email->getCustomer();

        if ($customer->getPassword() == null) {
            if ($password != $customer->getBirthday()->format('Y-m-d')) {
                $response->code       = LoginResponse::WRONG_PASSWORD_BIRTHDAY;
                $response->messages[] = 'Your initial password is the birthday in format yyyy-mm-dd';
            } else {
                $invoice              = $customer->getLastUsedInvoiceAddress();
                $response->code       = LoginResponse::SUCCESS;
                $response->customerId = $customer->getId();
                $response->display    = $invoice->getFirstName() . ' ' . $invoice->getLastName();
            }
        } else {
            if ($customer->getPassword() != md5($password)) {
                $response->code       = LoginResponse::WRONG_PASSWORD_BIRTHDAY;
                $response->messages[] = 'Your password is wrong';
            } else {
                $invoice              = $customer->getLastUsedInvoiceAddress();
                $response->code       = LoginResponse::SUCCESS;
                $response->customerId = $customer->getId();
                $response->display    = $invoice->getFirstName() . ' ' . $invoice->getLastName();
            }
        }

        return $response;
    }
}
 