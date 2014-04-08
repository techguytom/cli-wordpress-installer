<?php

namespace Techguytom\CliWordpressInstaller\Lib;

use Techguytom\CliWordpressInstaller\Lib\ParameterSet;

class HtaccessGenerator
{
    private $_parameters;

    public function __construct(ParameterSet $parameters)
    {
        $this->_parameters = $parameters;
    }

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

    public function writeHtaccess($content)
    {
        return file_put_contents(".htaccess", $content);
    }
}
