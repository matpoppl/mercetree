<?php

namespace Mateusz\Mercetree;

use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TestApplication
{
    private function __construct(private readonly Application $app)
    {}

    public function getRealApplication() : Application
    {
        return $this->app;
    }

    /**
     * @template T
     * @param string|class-string<T> $id
     * @return mixed|T
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getService(string $id) : mixed
    {
        return $this->app->getService($id);
    }

    /**
     * @template T
     * @param class-string<T> $id
     * @return T
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
