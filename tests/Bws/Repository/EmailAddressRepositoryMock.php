<?php

namespace Bws\Repository;

use Bws\Entity\EmailAddress;

class EmailAddressRepositoryMock implements EmailAddressRepository
{
    private $emailAddresses = array();
    private $lastInserted;

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
}
 