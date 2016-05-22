<?php namespace Lit\Core;

use Interop\Container\ContainerInterface;
use Lit\Core\Interfaces\IRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * the lit app class
 *
 * @property App $app
 * @property IRouter $router the main router
 */
class App
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        return $this->container->get($name);
    }

    public function __isset($name)
    {
        return isset($this->{$name}) || $this->container->has($name);
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $middleware = new DispatcherMiddleware($this->router);

        return call_user_func($middleware, $request, $response);
    }
}
