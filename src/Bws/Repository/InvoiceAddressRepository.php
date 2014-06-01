<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;

interface InvoiceAddressRepository
{
    /**
     * @param InvoiceAddress $invoiceAddress
     */
    public function save(InvoiceAddress $invoiceAddress);

    /**
     * @return InvoiceAddress
     */
    public function factory();
}
