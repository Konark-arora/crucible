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


$config = array(
    
    /**
     * This is default setting for all the apps;
     */
    
    'all' => array(
        'app' => 'default',     # App that is going to be called to cater current request
        'ip'  => 'all',         # Ip which are allowed
        'mode'=> 'prod',        # Mode of operations
        'web_debugger'=> false, # If you want web debugger to be active of not
        'static_paths'=> array('js' , 'css' , 'img') # static folders in the app 
    )
    
    /**
     * Despite, all the default settings are defined, it doesn't mean that
     * you dont have to declare your host name you are hosting in this project.
     * 
     * In case you have all the settings equivalent to default, just declare the
     * name like below
     * 
     * 'mydomain.com' => array();
     * 
     * and that domain will be initialized with that app.  
     */
)

?>
