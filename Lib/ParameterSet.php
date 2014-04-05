<?php

namespace Techguytom\CliWordpressInstaller\Lib;

class ParameterSet
{
    private $_wpDirectory;

    private $_dbName;

    private $_dbUser;

    private $_dbPass;

    private $_dbHost;

    private $_dbPrefix;

    private $_dbCharset;

    private $_dbCollate;

    private $_locale;

    private $_environment;

    private $_siteUrl;

    private $_contentDirectory;

    private $_uploadPath;

    private $_uploadUrl;

    public function __construct($parameters)
    {
        $this->setWpDirectory($parameters->wordpress_directory);
        $this->setDbName($parameters->database_name);
        $this->setDbUser($parameters->database_user);
        $this->setDbPass($parameters->database_password);
        $this->setDbHost($parameters->database_host);
        $this->setDbPrefix($parameters->database_prefix);
        $this->setDbCharset($parameters->database_character_set);
        $this->setDbCollate($parameters->database_collation);
        $this->setLocale($parameters->wordpress_locale);
        $this->setEnvironment($parameters->environment);
        $this->setSiteUrl($parameters->wordpress_site_url);
        $this->setContentDirectory($parameters->content_directory);
        $this->setUploadPath($parameters->wordpress_upload_path);
        $this->setUploadUrl($parameters->wordpress_upload_url);
    }

    public function setWpDirectory($dir = '')
    {
        $this->_wpDirectory = $dir;
    }

    public function setDbName($dbName)
    {
        $this->_dbName = $dbName;
    }

    public function setDbUser($dbUser)
    {
        $this->_dbUser = $dbUser;
    }

    public function setDbPass($dbPass)
    {
        $this->_dbPass = $dbPass;
    }

    public function setDbHost($dbHost = 'localhost')
    {
        $this->_dbHost = $dbHost;
    }

    public function setDbPrefix($dbPrefix = 'wp_')
    {
        $this->_dbPrefix = $dbPrefix;
    }

    public function setDbCharset($dbCharset = 'utf8')
    {
        $this->_dbCharset = $dbCharset;
    }

    public function setDbCollate($dbCollate = '')
    {
        $this->_dbCollate = $dbCollate;
    }

    public function setLocale($locale = 'en_US')
    {
        $this->_locale = $locale;
    }

    public function setEnvironment($environment = 'prod')
    {
        $this->_environment = $environment;
    }

    public function setSiteUrl($url)
    {
        $this->_siteUrl = $url;
    }

    public function setContentDirectory($dir)
    {
        $this->_contentDirectory = $dir;
    }

    public function setUploadPath($path)
    {
        $this->_uploadPath = $path;
    }

    public function setUploadUrl($url)
    {
        $this->_uploadUrl = $url;
    }

    public function getWpDirectory()
    {
        return $this->_wpDirectory;
    }

    public function getDbName()
    {
        return $this->_dbName;
    }

    public function getDbUser()
    {
        return $this->_dbUser;
    }

    public function getDbPass()
    {
        return $this->_dbPass;
    }

    public function getDbHost()
    {
        return $this->_dbHost;
    }

    public function getDbPrefix()
    {
        return $this->_dbPrefix;
    }

    public function getDbCharset()
    {
        return $this->_dbCharset;
    }

    public function getDbCollate()
    {
        return $this->_dbCollate;
    }

    public function getLocale()
    {
        return $this->_locale;
    }

    public function getEnvironment()
    {
        return $this->_environment;
    }

    public function getSiteUrl()
    {
        return $this->_siteUrl;
    }

    public function getContentDirectory()
    {
        return $this->_contentDirectory;
    }

    public function getUploadPath()
    {
        return $this->_uploadPath;
    }

    public function getUploadUrl()
    {
        return $this->_uploadUrl;
    }

}
