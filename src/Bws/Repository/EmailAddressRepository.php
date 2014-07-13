<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\EmailAddress;

interface EmailAddressRepository
{
    /**
     * @return EmailAddress
     */
    public function factory();

    public function save(EmailAddress $emailAddress);
}
 