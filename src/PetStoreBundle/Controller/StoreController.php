<?php
/*
 * This file is part of the kleijnweb/symfony-swagger-microservice-edition package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acme\PetStoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class StoreController
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Request $request
     *
     * @return array
     */
    public function placeOrder(Request $request)
    {
        return [
            'id'       => 12345679,
            'petId'    => 987654321,
            'quantity' => 10,
            'shipDate' => (new \DateTime())->format(\DateTime::W3C),
            'status'   => 'placed',
            'complete' => true,
        ];
    }
}
