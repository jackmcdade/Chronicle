<?php

/**
 * CHRONICLE
 * 
 * Chronicle is a light-weight and flexible, file-based publishing engine.
 * Kudos to Slim (slimframework.com) for powering the RESTful routing
 * @package Chronicle <http://github.com/jackmcdade/chronicle>
 * @author Jack McDade
 * @copyright 2012 Jack McDade <http://jackmcdade.com>
 */

if(phpversion() < 5.3) {
	die('<h3>Chronicle requires PHP/5.3 or higher.<br>You are currently running PHP/'.phpversion().'.</h3><p>Time to upgrade.</p>');
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
	
	$initialize = array(
		'title' => $app->config['defaultTitle'],
		'date' => $date,
		'prev' => find_prev($date),
		'next' => find_next($date),
	);
	$meta = Spyc::YAMLLoad('content/'. $date .'/meta.yaml');

	return array_merge($initialize, $meta);
}

function get_directories()
{
	$dirs = array_filter(glob('content/*', GLOB_ONLYDIR), 'is_dir');

	array_walk($dirs, function(&$item, $key) {
		$item = get_endpoint($item);
	});

	// remove the archive dir
	$archive = array_search('archive', $dirs);
	if ($archive)
		unset($dirs[$archive]);

	return $dirs;
}

function build_archive()
{
	$app = Slim::getInstance();

	$dirs = get_directories();
	$archive = array();
	
	foreach ($dirs as $key => $dir)
	{
		$meta_file = 'content/'.$dir.'/meta.yaml';
		if (file_exists($meta_file))
			$archive[$dir] = Spyc::YAMLLoad($meta_file);
		else
			$archive[$dir] = $app->config['defaultTitle'];
		
		$archive[$dir]['url'] = '/'.$dir;
	}
	return $archive;
}


function find_latest()
{	
	$dirs = get_directories();
	$latest = end($dirs);

	return get_endpoint($latest);
}

function find_next($date)
{
	$dirs = get_directories();
	$current = array_search($date, $dirs);

	if ($current !== FALSE)
	{
		while (key($dirs) !== $current) next($dirs);
			return next($dirs);
	}

	return FALSE;
}

function find_prev($date)
{
	$dirs = get_directories();
	$current = array_search($date, $dirs);
	if ($current !== FALSE) {
		while (key($dirs) !== $current) next($dirs);
			return prev($dirs);	
	}

	return FALSE;
}

function get_endpoint($dir)
{
	$dir_array = explode('/', $dir);
	return end($dir_array);
}

function asset_path($asset) {
	$app = Slim::getInstance();

	return '/content'.$app->request()->getResourceUri().'/'.$asset;
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

	$app->redirect(find_latest());

});

$app->get('/archive', function (){

	$app = Slim::getInstance();
	$data = Spyc::YAMLLoad('content/archive/meta.yaml');
	$data['entries'] = build_archive();

	$app->render('/archive/index.php', $data);

});

$app->get('/:date', function ($date) use ($app) {

	$data = get_meta($date);

	$app->render($date.'/index.php', $data);

});


// Go!
$app->run();