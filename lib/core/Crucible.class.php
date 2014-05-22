<?php

/**
 * This file is part of Crucible.
 * (c) 2014 Tejaswi Sharma
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This class will basically bootstrap the whole process
 *
 * @author Tejaswi Sharma <tejaswi@crucible-framework.org>
 */
class Crucible {
    
    /**
     *
     * @var type Crucible;
     */
    private static $_instance = null;

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Crucible();
        }
        return self::$_instance;
    }
    
    private function __clone() {
        return self::getInstance();
    }
    
    private function __construct() {
        $this->_setupSimpleAutoload();
    }
    
    /**
     * _setupSimpleAutoload
     * 
     * This function creates a basic autoload mechanism for all the core classes
     * in which the files of the classes will be loaded from a lookup array (self::$_autoload)
     */
    private function _setupSimpleAutoload() {
        $autoload_file = CORE . DS . 'config' . DS . 'config' . DS . 'autoload.php';

        # Load the autoload.php file
        if (is_file($autoload_file)) {
            include $autoload_file;
            self::$_autoload = $config;
        } else {
            throw new Exception("Core autoload.php file is missing");
        }

        # Register the _simpleAutoload function as the autoload function
        spl_autoload_register(array("Crucible", "_simpleAutoload"));
    }

    /**
     * _simpleAutoload
     * 
     * This function will include the file of the class
     * to be autoloaded
     * 
     * @param string $class_name
     * @throws Exception
     */
    private function _simpleAutoload($class_name) {

        # Checks if the class name present in the list
        if (array_key_exists($class_name, self::$_autoload)) {

            # If yes check if the listed file is present
            $file_path = self::$_autoload[$class_name];
            $full_file_path = ROOT . DS . 'lib' . DS . 'core' . DS . $file_path;

            if (is_file($full_file_path)) {

                # If the file is present include it
                require_once $full_file_path;
            } else {

                # Otherwise throw an exception
                throw new Exception("Core class file $full_file_path not found");
            }
        } else {

            // Class not present in autoload.php file 
            return null;
        }
    }
    
    public function dispatch(){
        $config  = new Container();
        $request = new Container();
        $response= new Container();
        $pipe_config_file = ROOT_CONFIG . DS . 'pipes.conf.php';
        
        $pipe_runner = new PipeRunner($config, $request, $response , $pipe_config_file);
        $pipe_runner->run();
    }
    
    
}

?>
