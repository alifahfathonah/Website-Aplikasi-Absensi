<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();

$autoload['libraries'] = array(
	'database',
	'template',
	'session',
	'table',
	'pagination',
	'form_validation',
	'ciqrcode',
	'calendar'
);

$autoload['drivers'] = array();

$autoload['helper'] = array(
	'html',
	'form',
	'file',
	'url',
	'site',
	'bootstrap',
	'inflector',
	'text',
	'html',
	'string'
);

$autoload['config'] = array('jwt');

$autoload['language'] = array();

$autoload['model'] = array(
	'paginationmodel'
);
