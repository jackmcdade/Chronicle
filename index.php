<?php

if(phpversion() < 5.3) {
	die('<h3>Chronical requires PHP/5.3 or higher.<br>You are currently running PHP/'.phpversion().'.</h3><p>Time to upgrade.</p>');
}

require 'app/Slim.php';
require 'app/parsers/spyc.php';

$config = Spyc::YAMLLoad('config.yaml');

$app = new Slim(array(
	'debug' => $config['debug'],
	'templates.path' => 'content'
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
	$meta = Spyc::YAMLLoad('content/'. $date .'/meta.yaml');

	return array_merge($defaults, $meta);
}

// @todo functions
function get_directories()
{
	$dirs = array_filter(glob('content/*', GLOB_ONLYDIR), 'is_dir');

	// remove the archive dir
	$archive = array_search('content/archive', $dirs);
	if ($archive)
		unset($dirs[$archive]);

	return $dirs;
}

function find_latest()
{	
	$dirs = get_directories();
	$latest = end($dirs);

	return get_dir_endpoint($latest);
}

function find_next()
{
	$app = Slim::getInstance();
}

function find_prev()
{
	$app = Slim::getInstance();
}

function get_dir_endpoint($dir)
{
	$dir_array = explode('/', $dir);
	return end($dir_array);
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
	$app->redirect(find_latest());

});

$app->get('/:date', function ($date) use ($app) {

	$data = get_meta($date);
	$app->render($date.'/index.php', $data);

});


// Go!
$app->run();