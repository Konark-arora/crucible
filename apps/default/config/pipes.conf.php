<?php
/**
 * This file is part of Crucible.
 * (c) 2014 Tejaswi Sharma
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * This file basically tells that which app is directly
 * related to which host
 */

$conf = array(
    'static_request_server' => array(
        'propagates_to' => array('route_identifier'), # To which pipe it will further give its result to
        'driver' => '', # Which class is its driver
        'path' => '', # Where it should find its driver class
        'params' => array() # Config parameters for that pipe
    ),
    'route_identifier' => array(
        'propagates_to' => array('module_executor'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'module_executor' => array(
        'propagates_to' => null,
        'driver' => '',
        'path' => '', 
        'params' => array()
    )    
)
?>
