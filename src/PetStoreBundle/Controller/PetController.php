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
class PetController
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Request $request
     *
     * @return array
     */
    public function findPetsByStatus(Request $request)
    {
        return [];
    }
}
