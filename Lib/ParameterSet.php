<?php
/**
 * ParameterSet.php
 *
 * @category Builder
 * @package  WordPress
 * @author   Tom Jenkins <tom@techguytom.com>
 */

namespace Techguytom\CliWordpressInstaller\Lib;

/**
 * ParameterSet
 *
 * @category Builder
 * @package  WordPress
 * @author   Tom Jenkins <tom@techguytom.com>
 * @version  Release: 0.8
 */
class ParameterSet
{
    /**
     * _wpDirectory
     *
     * @var str
     */
    private $_wpDirectory;

    /**
     * _dbName
     *
     * @var str
     */
    private $_dbName;

    /**
     * _dbUser
     *
     * @var str
     */
    private $_dbUser;

    /**
     * _dbPass
     *
     * @var str
     */
    private $_dbPass;

    /**
     * _dbHost
     *
     * @var str
     */
    private $_dbHost;

    /**
     * _dbPrefix
     *
     * @var str
     */
    private $_dbPrefix;

    /**
     * _dbCharset
     *
     * @var str
     */
    private $_dbCharset;

    /**
     * _dbCollate
     *
     * @var str
     */
    private $_dbCollate;

    /**
     * _locale
     *
     * @var str
     */
    private $_locale;

    /**
     * _environment
     *
     * @var str
     */
    private $_environment;

    /**
     * _siteUrl
     *
     * @var str
     */
    private $_siteUrl;

    /**
     * _contentDirectory
     *
     * @var str
     */
    private $_contentDirectory;

    /**
     * _uploadPath
     *
     * @var str
     */
    private $_uploadPath;

    /**
     * _uploadUrl
     *
     * @var str
     */
    private $_uploadUrl;

    /**
     * setWpDirectory
     *
     * @param str $dir WordPress Directory
     *
     * @return void
     */
    public function setWpDirectory($dir = '')
    {
        $this->_wpDirectory = $dir;
    }

    /**
     * setDbName
     *
     * @param str $dbName Database name
     * 
     * @return void
     */
    public function setDbName($dbName)
    {
        $this->_dbName = $dbName;
    }

    /**
     * setDbUser
     *
     * @param str $dbUser Database username
     * @return void
     */
    public function setDbUser($dbUser)
    {
        $this->_dbUser = $dbUser;
    }

    /**
     * setDbPass
     *
     * @param str $dbPass Database password
     * @return void
     */
    public function setDbPass($dbPass)
    {
        $this->_dbPass = $dbPass;
    }

    /**
     * setDbHost
     *
     * @param string $dbHost Database host
     * @return void
     */
    public function setDbHost($dbHost = 'localhost')
    {
        $this->_dbHost = $dbHost;
    }

    /**
     * setDbPrefix
     *
     * @param string $dbPrefix Database prefix
     * @return void
     */
    public function setDbPrefix($dbPrefix = 'wp_')
    {
        $this->_dbPrefix = $dbPrefix;
    }

    /**
     * setDbCharset
     *
     * @param string $dbCharset Database character set
     * @return void
     */
    public function setDbCharset($dbCharset = 'utf8')
    {
        $this->_dbCharset = $dbCharset;
    }

    /**
     * setDbCollate
     *
     * @param string $dbCollate Database collation
     * @return void
     */
    public function setDbCollate($dbCollate = '')
    {
        $this->_dbCollate = $dbCollate;
    }

    /**
     * setLocale
     *
     * @param string $locale WordPress locale
     * @return void
     */
    public function setLocale($locale = 'en_US')
    {
        $this->_locale = $locale;
    }

    /**
     * setEnvironment
     *
     * @param string $environment Environment variable
     * @return void
     */
    public function setEnvironment($environment = 'prod')
    {
        $this->_environment = $environment;
    }

    /**
     * setSiteUrl
     *
     * @param string $url Site url
     * @return void
     */
    public function setSiteUrl($url)
    {
        $this->_siteUrl = $url;
    }

    /**
     * setContentDirectory
     *
     * @param str $dir Location of content directory
     * @return void
     */
    public function setContentDirectory($dir)
    {
        $this->_contentDirectory = $dir;
    }

    /**
     * setUploadPath
     *
     * @param str $path location of file upload path
     * @return void
     */
    public function setUploadPath($path)
    {
        $this->_uploadPath = $path;
    }

    /**
     * setUploadUrl
     *
     * @param str $url Url of upload directory
     * @return void
     */
    public function setUploadUrl($url)
    {
        $this->_uploadUrl = $url;
    }

    /**
     * getWpDirectory
     *
     * @return string
     */
    public function getWpDirectory()
    {
        return $this->_wpDirectory;
    }

    /**
     * getDbName
     *
     * @return string
     */
    public function getDbName()
    {
        return $this->_dbName;
    }

    /**
     * getDbUser
     *
     * @return string
     */
    public function getDbUser()
    {
        return $this->_dbUser;
    }

    /**
     * getDbPass
     *
     * @return string
     */
    public function getDbPass()
    {
        return $this->_dbPass;
    }

    /**
     * getDbHost
     *
     * @return string
     */
    public function getDbHost()
    {
        return $this->_dbHost;
    }

    /**
     * getDbPrefix
     *
     * @return string
     */
    public function getDbPrefix()
    {
        return $this->_dbPrefix;
    }

    /**
     * getDbCharset
     *
     * @return string
     */
    public function getDbCharset()
    {
        return $this->_dbCharset;
    }

    /**
     * getDbCollate
     *
     * @return string
     */
    public function getDbCollate()
    {
        return $this->_dbCollate;
    }

    /**
     * getLocale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * getEnvironment
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * getSiteUrl
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->_siteUrl;
    }

    /**
     * getSiteUrlNoHttp
     *
     * @return string
     */
    public function getSiteUrlNoHttp()
    {
        $position = strpos($this->_siteUrl, "://");
        $newpos = $position + 3;

        return substr($this->_siteUrl, $newpos);
    }

    /**
     * getContentDirectory
     *
     * @return string
     */
    public function getContentDirectory()
    {
        return $this->_contentDirectory;
    }

    /**
     * getUploadPath
     *
     * @return string
     */
    public function getUploadPath()
    {
        return $this->_uploadPath;
    }

    /**
     * getUploadUrl
     *
     * @return string
     */
    public function getUploadUrl()
    {
        return $this->_uploadUrl;
    }

}
