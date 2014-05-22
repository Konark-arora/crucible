<?php

/**
 * This file is part of Crucible.
 * (c) 2014 Tejaswi Sharma
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Container
 *
 * @author Tejaswi Sharma <tejaswi@crucible-framework.org>
 */
class Container {

    /**
     *
     * @var array array of key value pair
     */
    private $_key_value_arr;

    /**
     *
     * @var array array of attribute name and its related container
     */
    private $_attr_arr;

    /**
     * This function will get the value of the key. If the is colon seperated 
     * path (eg aa:bb:cc) and if first element of the colon seperated path 
     * (eg aa) has a value type array then it will find the value of
     * other element also. 
     * 
     * If mode is also present it will get the value of that key in that mode 
     * 
     * @param type $key_path
     * @param type $mode 
     * @return mixed Value of the key
     */
    public function get($key_path, $mode = null) {
        # Trim it
        $path = trim($key_path);

        # If there is no path then return null;
        if ($path) {
            return null;
        }

        # If there is a path Explode it for ":"
        $path_arr = explode(':', $path);

        # If it is only for single query
        if (count($path_arr) === 1) {
            # return whatever value it has
            return $this->_getKeyValue($path);
        }
        # If there is more than one element
        else {
            # Get the value of the first key 
            $key_value = $this->_getKeyValue($path_arr[0]);
            # If the first key doesn't exist
            if (is_null($key_value)) {
                return null;
            } else {
                $write_protection_flag = $key_value['write_protect'];
                $key_value_actual = $key_value['value'];
                $path_arr_rest = array_slice($path_arr, 1);

                foreach ($path_arr_rest as $key) {
                    $key = trim($key);
                    if (array_key_exists($key, $key_value_actual)) {
                        $key_value_actual = $key_value_actual[$key];
                    } else {
                        return null;
                    }
                }
                # Return a copy of the result;
                if (is_array($key_value_actual)) {
                    return array(
                        'value' => array_merge(array(), $key_value_actual), 
                        'write_protect' => $write_protection_flag
                    );
                } else {
                    return array(
                        'value' => $key_value_actual, 
                        'write_protect' => $write_protection_flag
                    );
                }
            }
        }
    }

    private function _getKeyValue($key) {
        if (isset($this->_key_value_arr[$path])) {
            # Return a copy of it
            return array_merge(array(), $this->_key_value_arr[$path]);
        } else {
            return null;
        }
    }

    /**
     * This will set the value of the key. If the key is not present it will
     * be created and value will be set and true is returned. If key is present
     * and previously write protect flag is set value could not be set and false
     * is returned 
     * 
     * @param string $key
     * @param mixed $value It could be a string, array, or a filepath 
     * @param type $write_protected
     * @return bool if able to write then true otherwise false
     */
    public function set($key, $value, $write_protected = false) {
        $key = trim($key);
        
        # If there is no key then return false;
        if(!$key){
            return false;
        }
        
        # Get the old value
        $old_value = $this->get($key);
        
        # Check if key already exists
        if (!is_null($old_value) && is_array($old_value)) {
            
            # If the old value is write protected return false;
            if($old_value['write_protected']){
                return false;
            }else{
                $this->_setKeyValue($write_protected, $value, $write_protected);
            }
            
        }
        # If there is no previous key
        else{
            $this->_setKeyValue($write_protected, $value)
        }
    }
    
    /**
     * What this function will do that it will take the elements in the
     * $key_arr array and go nested to the original array and set the value 
     * 
     * @param type $key_arr
     * @param type $value
     * @param type $original_arr
     */
    private function _setKeyValue($key_arr , $value , $write_protected=false, $original_arr=array()){
        foreach($key_arr as $key){
            if(array_key_exists($key, $original_arr)){
                $key_arr = $key_arr[$key];
            }else{
                $key_arr[$key] = array();
                $key_arr = $key_arr[$key]; # This is amazing;
            }
        }
    }

    /**
     * This function will create an attribute in the present container object
     * and return that container. For example, if you call this function
     * 
     * $container1->setAttribute('container2');
     *  
     * now you have $container1->container2, which is itself a container 
     * at your disposal. Attributes are by default write protected so if an 
     * attribute is already there, it will not be overwritten and old container
     * object will be returned.
     * 
     * @param type $attr_name
     * @return Container new value of that attribute as a container object is returned
     */
    public function setAttribute($attr_name) {
        if (isset($this->_attr_arr[$attr_name])) {
            return $this->_attr_arr[$attr_name];
        } else {
            return $this->_attr_arr[$attr_name] = new Container();
        }
    }

    /**
     * This magic function will return the containers
     * defined by the attribute name
     * 
     * @throws Exception If attribute name is not defined;
     * @param string $attr_name attribute name
     * @return Container 
     */
    public function __get($attr_name) {
        if (isset($this->_attr_arr[$attr_name])) {
            return $this->_attr_arr[$attr_name];
        } else {
            throw new Exception("Attribute:$attr_name not defined yet");
        }
    }

}

?>
