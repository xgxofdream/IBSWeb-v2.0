<?php

/*
 * Load a relevant class file once a class gets instantiated
 *
 */
function __autoload($className) {
	// Analyze class names
	list ( $filename, $suffix ) = explode ( '_', $className );
	// Get file path
	$file = SERVER_ROOT . '/models/' . strtolower ( $filename ) . '.php';
	
	// Get file
	if (file_exists ( $file )) {
		// introdce file
		include_once ($file);
	} else {
		//
		die ( "File '$filename' containing class '$className' not found." );
	}
}

/*
 *
 * Analyze URL and get the GET variables and values
 *
 */
$request = $_SERVER ['QUERY_STRING'];

if (empty ( $request )) {
	$page = 'index';
	$getVars = array ();
} else {
	// Get the first variable that defines types of operations
	$parsed = explode ( '&', $request );
	$page = array_shift ( $parsed );
	
	// Get the left variables and values that support operations
	$getVars = array ();
	foreach ( $parsed as $argument ) {
		
		list ( $variable, $value ) = explode ( '=', $argument );
		$getVars [$variable] = $value;
	}
}

/*
 *
 * Get the controller file that define operations
 *
 */
$target = SERVER_ROOT . '/controllers/' . $page . '.php';

// Introduce file
if (file_exists ( $target )) {
	include_once ($target);
	$class = ucfirst ( $page ) . '_Controller';
	
	if (class_exists ( $class )) {
		$controller = new $class ();
	} else {
		
		die ( 'class does not exist!' );
	}
} else {
	
	die ( 'page does not exist!' );
}

/*
 *
 * Execute operations
 *
 */
$controller->main ( $getVars );

?> 
