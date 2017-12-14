<?php

use Mockery as m;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp()
    {
        parent::setUp();

        config(['app.url' => $this->baseUrl]);
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    public function mock($class)
    {
        $mock = m::mock($class);
        
        app()->instance($class, $mock);
        
        return $mock;
    }
}
