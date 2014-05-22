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
    'config_initializer' => array(
        'propagates_to' => array('request_parser'), # To which pipe it will further give its result to
        'driver' => '', # Which class is its driver
        'path' => '', # Where it should find its driver class
        'params' => array(
            'log_core_events' => true,
            'log_level'       => 10
        ) # Config parameters for that pipe
    ),
    'request_parser' => array(
        'propagates_to' => array('cache'),
        'driver' => '',
        'path' => '',
        'params' => array()
    ),
    'cache' => array(
        'propagates_to' => array('app_executor','response_creator'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'app_identifier' => array(
        'propagates_to' => array('app_executor'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'app_diversion' => array(
        'propagates_to' => array('app_executor'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'app_executor' => array(
        'propagates_to' => array('cache_aggregator'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'cache_aggregator' => array(
        'propagates_to' => array('response_creator'),
        'driver' => '',
        'path' => '', 
        'params' => array()
    ),
    'response_creator' => array(
        'propagates_to' => null,
        'driver' => '',
        'path' => '', 
        'params' => array()
    )
)
?>
