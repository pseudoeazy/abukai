<?php

namespace Controllers;

use Controllers\IRoute;

class Controller
{
    private $route;
    private $routes;
    private $method;


    public function __construct(string $route, string $method, IRoute $routes)
    {
        $this->route = $route;
        $this->method = $method;
        $this->routes = $routes;
    }


    private function loadTemplate($templateFileName, $variables = [])
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../../templates/' . $templateFileName;
        return ob_get_clean();
    }

    /**
     * Send API response.
     * @param mixed  $data
     * @param int $statusCode
     */
    protected function sendResponse($data, $statusCode = 404)
    {
        http_response_code($statusCode);
        print_r(json_encode($data));
        exit;
    }



    public function run()
    {
        $routes = $this->routes->getRoutes();
        $controller = $routes[$this->route][$this->method]['controller'];
        $action = $routes[$this->route][$this->method]['action'];
        $page = $controller->$action();

        if (isset($page['template'])) {
            $title = $page['title'];
            if (isset($page['variables'])) {
                $output = $this->loadTemplate($page['template'], $page['variables']);
            } else {
                $output = $this->loadTemplate($page['template']);
            }
            include __DIR__ . '/../../templates/layout.php';
        } else {
            $this->sendResponse($page['data'], $page['status_code']);
        }
    }
}
