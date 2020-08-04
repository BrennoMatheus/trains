<?php
//AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7

class Routes
{
    private array $towns;

    public function __construct(array $towns)
    {
        $this->towns = $towns;
    }

    public function addTown(Town $town): void
    {
        $this->towns[] = $town;
    }

    public function getTowns(): array
    {
        return $this->towns;
    }

    public function getTownByName(string $name): Town
    {
        return $this->towns[$name];
    }
}

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

class Route
{
    private string $destination_town;
    private int $distance;

    public function __construct(string $destination_town, int $distance)
    {
        $this->destination_town = $destination_town;
        $this->distance = $distance;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getDestinationTown(): string
    {
        return $this->destination_town;
    }
}

// input - AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7

//$line = trim(fgets(STDIN));
$inputs = preg_split("/, /", "AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7");

function validate(array $inputs): ?Exception
{
    foreach ($inputs as $input)
        if (!preg_match('/[A-E][A-E][1-9][0-9]*/', $input))
            return new Exception('valitation fails', 1);

    return null;
}

$error = validate($inputs);

if ($error) die;

$routes = new Routes([
    'A' => new Town('A'),
    'B' => new Town('B'),
    'C' => new Town('C'),
    'D' => new Town('D'),
    'E' => new Town('E')
]);

foreach ($inputs as $input) {
    $start = substr($input, 0, 1);
    $end = substr($input, 1, 1);
    $distance = substr($input, 2);
    $routes->getTownByName($start)->addRoute(new Route($end, $distance));
}

function distance(Routes $routes, array $towns): ?int
{
    $distance = 0;

    foreach ($towns as $key => $town) {

        if ($key === array_key_last($towns))
            break;

        $route = $routes
            ->getTowns()[$town]
            ->findRouteByDestination($towns[$key + 1]);

        if (!$route) {
            echo 'NO SUCH ROUTE';
            return null;
        }

        $distance += $route->getDistance();
    }

    return $distance;
}

function getPathsOfTwoTowns(Routes $routes, string $start, string $end)
{
}

function shortestRoute(Routes $routes, string $start, string $end): int
{
    $result = [];
    $visited = [];
    searchRoutes($routes, $start, $end, 0, 0, $result, $visited);

    return min($result);
}

function searchRoutes(Routes $routes, string $start, string $end, int $length, int $stops, array &$trips, array $visited): void
{
    $visited[] = $start;

    if ($start === $end and $stops !== 0) {
        $trips[] = $length;
        return;
    }

    $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

    foreach ($adjacent_routes as $townName => $route) {
        if (!array_search($townName, $visited) or $townName === $end) {
            $nextStop = $stops + 1;
            $distance = $length + $route->getDistance();
            searchRoutes($routes, $townName, $end,  $distance, $nextStop, $trips, $visited);
        }
    }
}

function countTripsByMaxStops(Routes $routes, string $start, string $end, int $max): int
{
    $result = 0;
    searchRoutesWithMaxStops($routes, $start, $end, $max, 0, $result);
    return $result;
}

function searchRoutesWithMaxStops(Routes $routes, string $start, string $end, int $max, int $stops, int &$trips): void
{
    if ($start === $end and $stops !== 0) {
        $trips++;
        return;
    }

    if ($stops === $max) return;

    $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

    foreach ($adjacent_routes as $townName => $route) {
        $nextStop = $stops + 1;
        searchRoutesWithMaxStops($routes, $townName, $end,  $max, $nextStop, $trips);
    }
}

function countTripsByStops(Routes $routes, string $start, string $end, int $number_of_stops): int
{
    $result = 0;
    searchRoutesWithAnNumberOfStops($routes, $start, $end, $number_of_stops, 0, $result);
    return $result;
}

function searchRoutesWithAnNumberOfStops(Routes $routes, string $start, string $end, int $number_of_stops, int $stops, int &$trips): void
{

    if ($start === $end and $stops === $number_of_stops) {
        $trips++;
        return;
    }

    if ($stops === $number_of_stops) return;

    $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

    foreach ($adjacent_routes as $townName => $route) {
        $nextStop = $stops + 1;
        searchRoutesWithAnNumberOfStops($routes, $townName, $end,  $number_of_stops, $nextStop, $trips);
    }
}

function dijkstra(Routes $routes, string $start, string $end): ?int
{
    $unvisited = $routes->getTowns();
    $distance = array_map(fn ($town) => $town->getName() === $start ? 0 : 999999, $unvisited);

    while ($unvisited) {
        $near = closest($unvisited, $distance);

        unset($unvisited[$near]);

        foreach ($routes->getTownByName($near)->getRoutes() as $route) {
            $total_distance = $distance[$near] + $route->getDistance();

            if ($total_distance < $distance[$route->getDestinationTown()])
                $distance[$route->getDestinationTown()] = $total_distance;
        }

        if ($near == $end)
            return $distance[$end];
    }

    return null;
}

function closest(array $unvisited, array $distance): string
{
    $diff = array_diff_key($distance, $unvisited);
    $tmp = $distance;

    foreach ($diff as $name => $town) unset($tmp[$name]);

    return array_search(min($tmp), $tmp);
}

function countTripsByMaxLength(Routes $routes, string $start, string $end, int $max): int
{
    $result = 0;
    $visited = [];
    searchRoutesWithMaxLength($routes, $start, $end, 0, $max, 0, $result, $visited);

    return $result;
}

function searchRoutesWithMaxLength(Routes $routes, string $start, string $end, int $length, int $max_length, int $stops, int &$trips): void
{
    if ($start === $end and $stops !== 0)
        $trips++;

    $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

    foreach ($adjacent_routes as $townName => $route) {

        $nextStop = $stops + 1;
        $distance = $length + $route->getDistance();

        if ($distance >= $max_length) return;

        searchRoutesWithMaxLength($routes, $townName, $end,  $distance, $max_length, $nextStop, $trips);
    }
}

// The distance of the route A-B-C.
var_dump(distance($routes, ['A', 'B', 'C']));

// The distance of the route A-D.
var_dump(distance($routes, ['A', 'D']));

// The distance of the route A-D-C.
var_dump(distance($routes, ['A', 'D', 'C']));

// The distance of the route A-E-B-C-D.
var_dump(distance($routes, ['A', 'E', 'B', 'C', 'D']));

// The distance of the route A-E-D.
var_dump(distance($routes, ['A', 'E', 'D']));

//The number of trips starting at C and ending at C with a maximum of 3 stops. 
var_dump(countTripsByMaxStops($routes, 'C', 'C', 3));

//The number of trips starting at A and ending at C with exactly 4 stops. 
var_dump(countTripsByStops($routes, 'A', 'C', 4));

//The length of the shortest route (in terms of distance to travel) from A to C.
var_dump(dijkstra($routes, 'A', 'C'));

//The length of the shortest route (in terms of distance to travel) from B to B.
var_dump(shortestRoute($routes, 'B', 'B'));

//The number of different routes from C to C with a distance of less than 30.
var_dump(countTripsByMaxLength($routes, 'C', 'C', 30));
