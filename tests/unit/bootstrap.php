<?php

define('_JEXEC', 1);

// Maximise error reporting.
ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL & ~(E_STRICT | E_USER_DEPRECATED));
ini_set('display_errors', 1);

// Set fixed precision value to avoid round related issues
ini_set('precision', 14);

/*
 * Ensure that required path constants are defined.
 */
if (!defined('JPATH_BASE'))
{
    define('JPATH_BASE', JOOMLA_ROOT_PATH);
}
if (!defined('JPATH_PLATFORM'))
{
    define('JPATH_PLATFORM', JPATH_BASE . '/libraries');
}
if (!defined('JPATH_LIBRARIES'))
{
    define('JPATH_LIBRARIES', JPATH_BASE . '/libraries');
}
if (!defined('JPATH_ROOT'))
{
    define('JPATH_ROOT', realpath(JPATH_BASE));
}
if (!defined('JPATH_CACHE'))
{
    define('JPATH_CACHE', JPATH_BASE . '/cache');
}
if (!defined('JPATH_CONFIGURATION'))
{
    define('JPATH_CONFIGURATION', JPATH_BASE);
}
if (!defined('JPATH_SITE'))
{
    define('JPATH_SITE', JPATH_ROOT);
}
if (!defined('JPATH_ADMINISTRATOR'))
{
    define('JPATH_ADMINISTRATOR', JPATH_ROOT . '/administrator');
}
if (!defined('JPATH_INSTALLATION'))
{
    define('JPATH_INSTALLATION', JPATH_ROOT . '/installation');
}
if (!defined('JPATH_MANIFESTS'))
{
    define('JPATH_MANIFESTS', JPATH_ADMINISTRATOR . '/manifests');
}
if (!defined('JPATH_PLUGINS'))
{
    define('JPATH_PLUGINS', JPATH_BASE . '/plugins');
}
if (!defined('JPATH_THEMES'))
{
    define('JPATH_THEMES', JPATH_BASE . '/templates');
}
if (!defined('JDEBUG'))
{
    define('JDEBUG', false);
}

// Import the platform in legacy mode.
require_once JPATH_PLATFORM . '/import.legacy.php';

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';

// Load Plugin
require_once dirname(__FILE__) . '/../../src/plugins/system/articleimages/articleimages.php';
