<?php

namespace Bws\Repository;

use Bws\Entity\EmailAddress;
use Bws\Entity\EmailAddressStub;

class EmailAddressRepositoryMock implements EmailAddressRepository
{
    /**
     * @var EmailAddress[]
     */
    private $emailAddresses = array();

    /**
     * @var EmailAddress
     */
    private $lastInserted;

    public function __construct()
    {
        $this->save(new EmailAddressStub());
    }

    /**
     * @return EmailAddress
     */
    public function factory()
    {
        return new EmailAddress();
    }

    public function save(EmailAddress $emailAddress)
    {
        $this->emailAddresses[] = $emailAddress;
        $this->lastInserted = $emailAddress;
    }

    /**
     * @return EmailAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    /**
     * @param string $address
     *
     * @return EmailAddress|null
     */
    public function findByAddress($address)
    {
        foreach ($this->emailAddresses as $emailAddress) {
            if ($emailAddress->getAddress() == $address) {
                return $emailAddress;
            }
        }

        return null;
    }
}
 