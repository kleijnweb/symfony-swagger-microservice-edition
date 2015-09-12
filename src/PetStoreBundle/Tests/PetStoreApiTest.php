<?php
/*
 * This file is part of the kleijnweb/symfony-swagger-microservice-edition package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acme\PetStoreBundle\Tests;

use KleijnWeb\SwaggerBundle\Dev\Test\ApiTestCase;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class PetStoreApiTest extends ApiTestCase
{
    /**
     * @var bool
     */
    protected $validateErrorResponse = false;

    public static function setUpBeforeClass()
    {
        parent::initSchemaManager(__DIR__ . '/../../../app/config/swagger.yml');
    }

    /**
     * @test
     */
    public function canFindPetsByStatus()
    {
        $params = ['status' => 'available'];

        $this->get('/v2/pet/findByStatus', $params);
    }

    /**
     * @test
     */
    public function canPlaceOrder()
    {
        $params = ['status' => 'available'];

        $this->post('/v2/store/order', $params);
    }
}
