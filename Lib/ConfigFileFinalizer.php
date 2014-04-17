<?php
/**
 * ConfigFileFinalizer.php
 *
 * @category File_Handler
 * @package  WordPress
 */

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

/**
 * ConfigFileFinalizer
 *
 * @category Installer
 * @package Wordpress
 * @author Tom Jenkins <tom@techguytom.com>
 * @version Release: 0.8
 */
class ConfigFileFinalizer
{
    /**
     * _parameters
     *
     * @var object
     */
    private $_parameters;

    /**
     * __construct
     *
     * @param ParameterSet $parameters Reference to the class
     * @return object
     */
    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }
        
    /**
     * finalizeConfig
     *
     * Handles adding items to the wp-config.php file
     *
     * @return file
     */
    public function finalizeConfig()
    {
        $debug = $this->_environmentCheck(); 

        $configFile = file_get_contents($this->_parameters->getWpDirectory() . "/wp-config.php");

        if (!$configFile) {
            return $configFile;
        }

        $wpDebug    = $this->_environmentCheck();
        $configFile = $this->_addFileAdditions($configFile, $wpDebug);

        return file_put_contents($this->_parameters->getWpDirectory() . '/wp-config.php', $configFile);

    }
    
    /**
     * _environmentCheck
     *
     * Set WP_DEBUG based on environment
     *
     * @return string
     */
    private function _environmentCheck()
    {
        if ($this->_parameters->getEnvironment() == "dev") {
            return "define( 'WP_DEBUG', true );"; 
        } elseif ($this->_parameters->getEnvironment() == "prod") {
            return "define( 'WP_DEBUG', false );"; 
        } 

        return null;
    }

    /**
     * _addFileAdditions
     *
     * Place Content, Home, and Debug data in wp-config file
     *
     * @param string $configFile The wp-config file
     * @param string $debugString the WP_DEBUG setting
     *
     * @return string
     */
    private function _addFileAdditions($configFile, $debugString)
    {
        $location = strpos($configFile, "/* That's all, stop editing!");

        $additions = "define('WP_HOME' , '" . $this->_parameters->getSiteUrl() . "');\n";
        $additions .= "define('WP_SITEURL', WP_HOME);\n";
        $additions .= "define('WP_CONTENT_DIR', dirname(__FILE__) . '"
            . DIRECTORY_SEPARATOR
            . $this->_parameters->getContentDirectory()
            . "');\n";
        $additions .= "define('WP_CONTENT_URL', '"
            . $this->_parameters->getSiteUrl()
            . "/"
            . $this->_parameters->getContentDirectory() 
            . "');\n";
        $additions .= $debugString . "\n";

        return substr_replace($configFile, $additions, $location - 1, 0);
        
    }
}
