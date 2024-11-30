<?php

declare(strict_types=1);

require_once 'autoload.php';

use Core\Router\Router;
use Http\Controllers\CategoryController;
use Http\Controllers\CourseController;

$router = new Router();
$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/categories/tree', [CategoryController::class, 'tree']);
$router->get('/categories/{id}', [CategoryController::class, 'showById']);
$router->get('/courses', [CourseController::class, 'index']);
$router->get('/courses/category/{id}', [CourseController::class, 'getCategoryCourses']);
$router->get('/courses/{id}', [CourseController::class, 'showById']);
