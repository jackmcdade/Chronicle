<?php

require 'app/Slim.php';
require 'app/parsers/spyc.php';

$config = Spyc::YAMLLoad('config.yaml');

$app = new Slim(array(
	'debug' => $config['debug'],
	'templates.path' => $config['contentDir']
));

// Sitewide global config
$app->config = $config;

// This is today
$app->today = date($app->config['dateFormat']);


/**
 * Functions
 * 
 * Why not keep it all in one file.
 * This stuff does the dirty work.
 */

function get_meta($date) {

	$app = Slim::getInstance();
	
	$defaults = array(
		'title' => $app->config['defaultTitle']
	);
	$meta = Spyc::YAMLLoad($app->config['contentDir'] .'/'. $date .'/meta.yaml');

	return array_merge($defaults, $meta);
}

// @todo functions
function parse_content()
{
	// probably should be a class
	$app = Slim::getInstance();
}

function find_latest()
{
	$app = Slim::getInstance();
}

function find_next()
{
	$app = Slim::getInstance();
}

function find_prev()
{
	$app = Slim::getInstance();
}
//

/**
 * The Routes: Tread lightly!
 * 
 * Make sure you know what you're doing
 * if you want to edit these routes.
 * They make the magic happen.
 */

$app->get('/', function () use ($app) {

	// @todo make this the "latest", not just today
	$app->redirect($app->today);

});

$app->get('/:date', function ($date) use ($app) {

	$data = get_meta($date);
	$app->render($date.'/index.php', $data);

});


// Go!
$app->run();