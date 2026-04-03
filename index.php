<?php
// index.php
require_once __DIR__ . '/src/Router.php';
require_once __DIR__ . '/src/Controller/HomeController.php';
require_once __DIR__ . '/src/Controller/GroupController.php';
require_once __DIR__ . '/src/Controller/ExpenseController.php';
require_once __DIR__ . '/src/Model/Group.php';
require_once __DIR__ . '/src/Model/Expense.php';
require_once __DIR__ . '/src/Util/DebtCalculator.php';

use App\Router;
use App\Controller\HomeController;
use App\Controller\GroupController;
use App\Controller\ExpenseController;

session_start();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->post('/group/create', [GroupController::class, 'create']);
$router->post('/group/add-member', [GroupController::class, 'addMember']);
$router->post('/group/delete', [GroupController::class, 'delete']);
$router->post('/expense/create', [ExpenseController::class, 'create']);
$router->post('/expense/delete', [ExpenseController::class, 'delete']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
