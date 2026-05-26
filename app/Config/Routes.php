<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->match(['get', 'post'], 'login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    $routes->get('bookings', 'BookingController::index');
    $routes->match(['get', 'post'], 'bookings/create', 'BookingController::create');

    $routes->get('approvals', 'ApprovalController::index');
    $routes->post('approvals/approve/(:num)', 'ApprovalController::approve/$1');
    $routes->post('approvals/reject/(:num)', 'ApprovalController::reject/$1');

    $routes->get('fuel-logs', 'FuelLogController::index');
    $routes->match(['get', 'post'], 'fuel-logs/create', 'FuelLogController::create');

    $routes->get('services', 'ServiceController::index');
    $routes->match(['get', 'post'], 'services/create', 'ServiceController::create');

    $routes->get('usage-history', 'UsageHistoryController::index');

    $routes->get('reports', 'ReportController::index');
    $routes->get('reports/export', 'ReportController::export');
});
