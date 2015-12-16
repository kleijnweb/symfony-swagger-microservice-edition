<?php
/*
 * This file is part of the kleijnweb/symfony-swagger-microservice-edition package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acme\PetStoreBundle\Tests;

use KleijnWeb\SwaggerBundle\Dev\Test\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class PetStoreApiTest extends WebTestCase
{
    use ApiTestCase;

    /**
     * Use config_basic.yml
     *
     * @var bool
     */
    protected $env = 'test';

    /**
     * @var bool
     */
    protected $validateErrorResponse = false;

    /**
     * Init response validation, point to your spec
     */
    public static function setUpBeforeClass()
    {
        static::initSchemaManager(__DIR__ . '/../../../app/config/swagger.yml');
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
        $params = ['status' => 'placed'];

        $this->post('/v2/store/order', $params);
    }
}
