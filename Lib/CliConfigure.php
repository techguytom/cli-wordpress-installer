<?php

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

class CliConfigure
{
    private $_parameters;

    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }

    public function buildWpConfig()
    {
        $configString = "core config";
        $configString .= " --path=" . $this->_parameters->getWpDirectory();
        $configString .= " --dbname=" . $this->_parameters->getDbName();
        $configString .= " --dbuser=" . $this->_parameters->getDbUser();
        $configString .= " --dbpass=" . $this->_parameters->getDbPass();
        $configString .= " --dbhost=" . $this->_parameters->getDbHost();
        $configString .= " --dbprefix=" . $this->_parameters->getDbPrefix();
        $configString .= " --dbcharset=" . $this->_parameters->getDbCharset();
        if ($this->_parameters->getDbCollate()) {
            $configString .= " --dbcollate=" . $this->_parameters->getDbCollate();
        }
        $configString .= " --locale=" . $this->_parameters->getLocale();

        return $configString;
    }

    public function databaseChanges()
    {
        if (!$this->_parameters->getUploadPath() || !$this->_parameters->getUploadUrl()) {
            return null; 
        }

        $sql = "UPDATE " . $this->_parameters->getDbPrefix() . "options SET option_value = '" . $this->_parameters->getUploadPath() . "' WHERE option_name = 'upload_path';";
        $sql .= "UPDATE " . $this->_parameters->getDbPrefix() . "options SET option_value = '" . $this->_parameters->getUploadUrl() . "' WHERE option_name = 'upload_url';";

        return $sql;
    }
}
