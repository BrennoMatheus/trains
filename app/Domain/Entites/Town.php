<?php

namespace App\Domain\Entites;

class Town
{
    private string $name;
    private ?array $routes;

    public function __construct(string $name, array $routes = null)
    {
        $this->name = $name;
        $this->routes = $routes;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[$route->getDestinationTown()] = $route;
    }

    public function findRouteByDestination(string $destination): ?Route
    {
        return isset($this->routes[$destination]) ? $this->routes[$destination] : null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
