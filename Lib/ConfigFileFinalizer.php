<?php

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

class ConfigFileFinalizer
{
    private $_parameters;

    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }
        
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
    
    private function _environmentCheck()
    {
        if ($this->_parameters->getEnvironment() == "dev") {
            return "define( 'WP_DEBUG', true );"; 
        } elseif ($this->_parameters->getEnvironment() == "prod") {
            return "define( 'WP_DEBUG', false );"; 
        } 

        return null;
    }

    private function _addFileAdditions($configFile, $debugString)
    {
        $location = strpos($configFile, "/* That's all, stop editing!");

        $additions = "define('WP_HOME' , '" . $this->_parameters->getSiteUrl() . "');\n";
        $additions .= "define('WP_SITEURL', WP_HOME);\n";
        $additions .= "define('WP_CONTENT_DIR', dirname(__FILE__) . '" . $this->_parameters->getContentDirectory() . "');\n";
        $additions .= "define('WP_CONTENT_URL', '" .
            $this->_parameters->getSiteUrl() . 
            "/" . 
            $this->_parameters->getContentDirectory() . 
            "');\n";
        $additions .= $debugString . "\n";

        return substr_replace($configFile, $additions, $location - 1, 0);
        
    }
}
