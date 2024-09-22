<?php
/**
 * Basic routing.
 */

$request = $_SERVER['REQUEST_URI'];
$basePath = '/authentication';

/** 
 * $request variable contains the full path of the request,
 * therefore we need to remove the base path from it.
 */
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}

switch ($request) {
case '/' :
    include __DIR__ . '/views/login.php';
    break;
case '/login' :
    include __DIR__ . '/views/login.php';
    break;
case '/register' :
    include __DIR__ . '/views/register.php';
    break;
default:
    http_response_code(404);
    echo '404 - Page not found';
    break;
}