<?php

namespace Mateusz\Mercetree;

use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;

class TestApplication
{
    private function __construct(private readonly Application $app)
    {}

    public function getRealApplication() : Application
    {
        return $this->app;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getService(string $id) : mixed
    {
        return $this->app->getService($id);
    }

    public function getComponent(string $id) : object
    {
        return $this->app->getComponent($id);
    }

    public function getConfig() : ConfigInterface
    {
        return $this->app->getService(ConfigInterface::class);
    }

    public static function getInstance() : self
    {
        static $instance = null;

        if (null === $instance) {

            $config = require TEST_PATH_APP_ROOT . '/configs/app.php';
            $app = Application::create($config);

            $instance = new self($app);
        }

        return $instance;
    }
}
