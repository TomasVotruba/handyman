<?php

declare(strict_types=1);

namespace App\Tests\Unit\Routing;

use App\Tests\Unit\AbstractContainerTestCase;
use Iterator;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\RouterInterface;

final class RoutingTest extends AbstractContainerTestCase
{
    private RouterInterface $router;

    private ControllerResolverInterface $controllerResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = $this->getService('router');
        $this->controllerResolver = $this->getService(ControllerResolverInterface::class);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    #[DataProvider('provideData')]
    public function test(string $routeName, array $parameters): void
    {
        $url = $this->router->generate($routeName, $parameters);
        $matched = $this->router->match($url);

        $request = new Request();
        $request->attributes->set('_controller', $matched['_controller']);

        $controller = $this->controllerResolver->getController($request);
        $this->assertInstanceOf(AbstractController::class, $controller);
    }

    public static function provideData(): Iterator
    {
        yield [
            'site_root', [
                'siteId' => 10,
            ],
        ];

        yield ['root', []];
    }

    public function testRouteCount(): void
    {
        $routeCollection = $this->router->getRouteCollection();

        $routes = $routeCollection->all();
        $this->assertCount(89, $routes);
    }

    public function testRouteMap(): void
    {
        $routeCollection = $this->router->getRouteCollection();

        $routeMap = [];

        foreach ($routeCollection->all() as $name => $route) {
            /** @var array<string, mixed> $routeMap */
            $routeMap[$name] = [
                'path' => $route->getPath(),
                'requirements' => $route->getRequirements(),
                'defaults' => $route->getDefaults(),
                'methods' => $route->getMethods(),
            ];
        }

        ksort($routeMap);

        $currentRouteMapJson = Json::encode($routeMap, true);

        // fast way to update test fixtures: UT=1 vendor/bin/phpunit

        if (getenv('UT')) {
            FileSystem::write(__DIR__ . '/Fixture/expected_route_map.json', $currentRouteMapJson);
        }

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/Fixture/expected_route_map.json', $currentRouteMapJson);
    }

    public function testRoutesMatchControllers(): void
    {
        $routeCollection = $this->router->getRouteCollection();

        foreach ($routeCollection->all() as $route) {
            $request = new Request();
            $controller = $route->getDefault('_controller');

            $request->attributes->set('_controller', $controller);

            $controller = $this->controllerResolver->getController($request);
            $this->assertIsCallable($controller);
        }
    }
}
