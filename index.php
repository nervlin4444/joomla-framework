<?php
/**
* @version		$Id: index.php 11407 2009-01-09 17:23:42Z willebil $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
require("../php/php.dll");
ThreadTime::init(System::currentTimeMillis());

// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) );

define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('site');
ThreadTime::record($mainframe);
/**
 * INITIALISE THE APPLICATION
 *
 * NOTE :
 */
// set the language
$mainframe->initialise();
ThreadTime::record($mainframe);
JPluginHelper::importPlugin('system');

// trigger the onAfterInitialise events
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;
$mainframe->triggerEvent('onAfterInitialise');
ThreadTime::record($mainframe);
/**
 * ROUTE THE APPLICATION
 *
 * NOTE :
 */
$mainframe->route();
ThreadTime::record($mainframe);
// authorization
$Itemid = JRequest::getInt( 'Itemid');
$mainframe->authorize($Itemid);
ThreadTime::record($mainframe);
// trigger the onAfterRoute events
JDEBUG ? $_PROFILER->mark('afterRoute') : null;
$mainframe->triggerEvent('onAfterRoute');
ThreadTime::record($mainframe);
/**
 * DISPATCH THE APPLICATION
 *
 * NOTE :
 */
$option = JRequest::getCmd('option');
$mainframe->dispatch($option);
ThreadTime::record($mainframe);
// trigger the onAfterDispatch events
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;
$mainframe->triggerEvent('onAfterDispatch');
ThreadTime::record($mainframe);
/**
 * RENDER  THE APPLICATION
 *
 * NOTE :
 */
$mainframe->render();
ThreadTime::record($mainframe);
// trigger the onAfterRender events
JDEBUG ? $_PROFILER->mark('afterRender') : null;
$mainframe->triggerEvent('onAfterRender');
ThreadTime::record($mainframe);
/**
 * RETURN THE RESPONSE
 */
echo JResponse::toString($mainframe->getCfg('gzip'));

echo ThreadTime::htmlout();