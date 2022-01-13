<?php

try {
	include __DIR__ . '/includes/autoload.php';
	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
	if ($route == ltrim($_SERVER['REQUEST_URI'],  '/') )
	    $route = '';
	else
		$route = $_SERVER['QUERY_STRING'];
	if (strlen(strtok($route, '?')) <  strlen($route))
	{ 
	$_GET['id'] = substr ($route, strlen(strtok($route, '?')) + 4, strlen($route));
        $route = strtok($route, '?');
	}
	$entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ijdb\IjdbRoutes());
	$entryPoint->run();

}
catch (PDOException $e) {
	$title = 'An error has occurred';
	$output = 'Database error: ' . $e->getMessage() . ' in ' .
	$e->getFile() . ':' . $e->getLine();
	include  __DIR__ . '/templates/layout.html.php';
}
    ini_set('max_execution_time', 0);
    
