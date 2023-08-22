<?php

namespace Controllers;

use Models\Database;
use Controllers\Customer;
use Controllers\IRoute;

class Routes implements IRoute
{
    public function getRoutes(): array
    {

        $customerTable = new Database('customer', 'id');
        $customerController = new Customer($customerTable);

        $routes = [
            '' => [
                'GET' => [
                    'controller' => $customerController,
                    'action' => 'home'
                ]
            ],
            'account/register' => [
                'POST' => [
                    'controller' => $customerController,
                    'action' => 'registerCustomer'
                ],
            ],
            'customer/review' => [
                'GET' => [
                    'controller' => $customerController,
                    'action' => 'review'
                ]
            ],
        ];
        return $routes;
    }
}
