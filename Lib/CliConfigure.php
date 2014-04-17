<?php
/**
 * CliConfigure.php
 *
 * @package Wordpress
 */

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

/**
 * CliConfigure
 *
 * @package  WordPress
 * @author   Tom Jenkins <tom@techguytom.com>
 * @version  Release: 0.8 
 */
class CliConfigure
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
     * @param ParameterSet $parameters Class reference
     *
     * @return string
     */
    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }

    /**
     * buildWpConfig
     *
     * Create the config string for WP-Cli
     *
     * @return string
     */
    public function buildWpConfig()
    {
        $configString  = "core config";
        $configString .= " --path="      . $this->_parameters->getWpDirectory();
        $configString .= " --dbname="    . $this->_parameters->getDbName();
        $configString .= " --dbuser="    . $this->_parameters->getDbUser();
        $configString .= " --dbpass="    . $this->_parameters->getDbPass();
        $configString .= " --dbhost="    . $this->_parameters->getDbHost();
        $configString .= " --dbprefix="  . $this->_parameters->getDbPrefix();
        $configString .= " --dbcharset=" . $this->_parameters->getDbCharset();
        if ($this->_parameters->getDbCollate()) {
            $configString .= " --dbcollate=" . $this->_parameters->getDbCollate();
        }
        $configString .= " --locale=" . $this->_parameters->getLocale();

        return $configString;
    }

    /**
     * databaseChanges
     *
     * Update mysql commands for defining remote upload location
     *
     * @return string
     */
    public function databaseChanges()
    {
        if (!$this->_parameters->getUploadPath() || !$this->_parameters->getUploadUrl()) {
            return null; 
        }

        $sql = sprintf(
            "UPDATE %soptions SET option_value = %s WHERE option_name = 'upload_path'",
            $this->_parameters->getDbPrefix(), 
            $this->_parameters->getUploadPath()
        );
        $sql .= sprintf(
            "UPDATE %soptions SET option_value = %s WHERE option_name = 'upload_url'",
            $this->_parameters->getDbPrefix(),
            $this->_parameters->getUploadUrl()
        );

        return $sql;
    }
}
