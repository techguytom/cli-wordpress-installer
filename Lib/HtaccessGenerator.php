<?php
/**
 * HtaccessGenerator.php
 *
 * @category File_Handler
 * @package  WordPress
 */

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

/**
 * HtaccessGenerator
 *
 * @package  WordPress
 * @author   Tom Jenkins <tom@techguytom.com>
 * @version  Release: 0.8
 */
class HtaccessGenerator
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
     * @param ParameterSet $parameters Reference to class
     *
     * @return object
     */
    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }

    /**
     * htaccessContent
     *
     * Prepare file contents
     *
     * @return string
     */
    public function htaccessContent()
    {
        $htaccess = "RewriteEngine on\n";
        $htaccess .= "RewriteBase /\n";
        $htaccess .= "\n";
        $htaccess .= "RewriteCond %{HTTP_HOST} ^(www.)?" . $this->_parameters->getSiteUrlNoHttp() . "\n";
        $htaccess .= "RewriteCond %{REQUEST_URI} !^" . $this->_parameters->getWpDirectory() . "\n";
        $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
        $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
        $htaccess .= "RewriteRule ^(.*)$ " . $this->_parameters->getWpDirectory() . "/$1\n";
        $htaccess .= "RewriteCond %{HTTP_HOST} ^(www.)?" . $this->_parameters->getSiteUrlNoHttp() . "$\n";
        $htaccess .= "RewriteRule ^(/)?$ " . $this->_parameters->getWpDirectory() . "/index.php [L]\n";
        $htaccess .= "\n";
        $htaccess .= "RewriteRule ^index\.php$ - [L]\n";
        $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
        $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
        $htaccess .= "RewriteRule . /index.php [L]";
    
        return $htaccess;
    }

    /**
     * writeHtaccess
     *
     * Write the .htaccess file
     *
     * @param string $content Contents to be written
     * @return file
     */
    public function writeHtaccess($content)
    {
        return file_put_contents(".htaccess", $content);
    }
}
