<?php
/**
 * InstallHandler.php
 *
 * @category Installer
 * @package  Composer
 * @author   Tom Jenkins <tom@techguytom.com>
 */

namespace Techguytom\CliWordpressInstaller;

use Composer\Script\Event;
use Symfony\Component\Yaml\Parser;

/**
 * InstallHandler
 *
 * Primary control class for directing the workflow of the WordPress 
 * configuration
 *
 * @package WordPress
 * @author  Tom Jenkins <tom@techguytom.com>
 * @version Release: 0.8.1
 */
class InstallHandler
{
    /**
     * cliInstall
     *
     * Handles all of the configuration options and output
     *
     * @param Event $event Composer event
     *
     * @return void
     */
    public static function cliInstall(Event $event)
    { 
        $messageHandler = new Lib\MessageHandler($event->getIO());
        $messageHandler->writeStatusToConsole("Starting WordPress Configuration...");
        
        $extras = $event->getComposer()->getPackage()->getExtra();

        if (!isset($extras['incenteev-parameters'])) {
            throw new \InvalidArgumentException(
                'The parameter handler needs to be configured through the extra.incenteev-parameters setting.'
            );
        }

        if (!isset($extras['incenteev-parameters']['file'])) {
            throw new \InvalidArgumentException(
                'The extra.incenteev-parameters setting must be an array and must contain the file parameter.'
            );

        }

        $settingsFile = $extras['incenteev-parameters']['file'];

        $messageHandler->writeStatusToConsole(sprintf('Parsing %s file', $settingsFile));

        // Parse the config.yml file and collect settings
        $parser     = new Parser();
        $settings   = new Lib\ConfigParser($parser, $settingsFile);
        $parameters = $settings->parseParameters();

        $setParameters = new Lib\ParameterSet();

        $setParameters->setWpDirectory($parameters->wordpress_directory);
        $setParameters->setDbName($parameters->database_name);
        $setParameters->setDbUser($parameters->database_user);
        $setParameters->setDbPass($parameters->database_password);
        $setParameters->setDbHost($parameters->database_host);
        $setParameters->setDbPrefix($parameters->database_prefix);
        $setParameters->setDbCharset($parameters->database_character_set);
        $setParameters->setDbCollate($parameters->database_collation);
        $setParameters->setLocale($parameters->wordpress_locale);
        $setParameters->setEnvironment($parameters->environment);
        $setParameters->setSiteUrl($parameters->wordpress_site_url);
        $setParameters->setContentDirectory($parameters->content_directory);
        /* TODO for future feature */
        //$setParameters->setUploadPath($parameters->wordpress_upload_path);
        //$setParameters->setUploadUrl($parameters->wordpress_upload_url);

        $messageHandler->writeStatusToConsole("Writing wp-config.php file");

        // Create the wp-config.php file and move to the root
        $cliConfigurator = new Lib\CliConfigure($setParameters);
        $configString    = $cliConfigurator->buildWpConfig();

        exec("wp $configString");

        $configFinal = new Lib\ConfigFileFinalizer($setParameters);
        $createFile  = $configFinal->finalizeConfig();

        if (!$createFile) {
            $messageHandler->writeErrorToConsole("Error writing wp-config.php");
            exit();
        }

        $messageHandler->writeStatusToConsole("Creating the database.");

        // Create the database - if it exists wpcli will show an error but 
        // contiue processing
        exec("wp db  --path=" . $setParameters->getWpDirectory() . " create");

        exec("mv " . $setParameters->getWpDirectory() . "/wp-config.php wp-config.php");

        $messageHandler->writeStatusToConsole("Database creation complete.");
        $messageHandler->writeStatusToConsole("Generating .htaccess file.");
        
        // Create the .htaccess file in the root
        $htaccess = new Lib\HtaccessGenerator($setParameters);
        $content = $htaccess->htaccessContent();
        $htaccessFile = $htaccess->writeHtaccess($content);

        if (!$htaccessFile) {
            $messageHandler->writeErrorToConsole("Error writing .htaccess file.");
            exit();
        }

        $messageHandler->writeStatusToConsole(".htaccess file created.");
        $messageHandler->writeStatusToConsole("Visit your site withing the browser to finalize setup.");
    }
}
