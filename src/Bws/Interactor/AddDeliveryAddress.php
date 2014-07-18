<?php

namespace Bws\Interactor;

use Bws\Entity\DeliveryAddress;
use Bws\Repository\CustomerRepository;
use Bws\Repository\DeliveryAddressRepository;

class AddDeliveryAddress
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepository
     */
    private $deliveryAddressRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        DeliveryAddressRepository $deliveryAddressRepository
    ) {
        $this->customerRepository        = $customerRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
    }

    /**
     * @param AddDeliveryAddressRequest $request
     *
     * @return AddDeliveryAddressResponse
     */
    public function execute(AddDeliveryAddressRequest $request)
    {
        $result = new AddDeliveryAddressResponse();

        if (!$customer = $this->customerRepository->find($request->customerId)) {
            $result->code = $result::CUSTOMER_NOT_FOUND;
            return $result;
        }

        $address = $this->deliveryAddressRepository->factory();
        $address->setFirstName($request->firstName);
        $address->setLastName($request->lastName);
        $address->setStreet($request->street);
        $address->setZip($request->zip);
        $address->setCity($request->city);
        $address->setCustomer($customer);

        $this->deliveryAddressRepository->save($address);

        $result->code = $result::SUCCESS;

        return $result;
    }
}
 