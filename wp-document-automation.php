<?php
/**
 * Plugin Name:     WordPress Document Automation
 * Plugin URI:      https://wptools.app
 * Description:     Create a word document in seconds by filling a form. Automate your boring, repetitive and tedious documents generation process.
 * Author:          WP Tools
 * Author URI:      https://wptools.app
 * Text Domain:     wp-document-automation
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package Wp_Document_Automation
 */

require_once __DIR__ . '/vendor/autoload.php';

$loader = \WP\Plugin\DocumentAutomation\Loader::get_instance();

$loader['name'] = 'WordPress Document Automation';
$loader['version'] = '1.0.0';
$loader['dir'] = __DIR__;
$loader['url'] = plugins_url('/' . basename(__DIR__));
$loader['file'] = __FILE__;
$loader['slug'] = 'wp-document-automation';

$loader->run();
