<?php

namespace Techguytom\CliWordpressInstaller;

use Composer\Script\Event;
use Symfony\Component\Yaml\Parser;

/**
 * InstallHandler
 *
 * Primary control class for directing the workflow of the WordPress 
 * configuration
 *
 * @package 
 * @author Tom Jenkins <tom@techguytom.com>
 * @version $Id$
 */
class InstallHandler {

    public static function cliInstall(Event $event)
    { 
        $messageHandler = new MessageHandler($event->getIO());
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

        $configFile = $extras['incenteev-parameters']['file'];

        $messageHandler->writeStatusToConsole('Parsing "' . $configFile . '" file.');

        $parser     = new Parser();
        $settings   = new Lib\ConfigParser($parser, $configFile);
        $parameters = $settings->parseParameters();

        $setParameters   = new Lib\ParameterSet($parameters);

        $messageHandler->writeStatusToConsole("Writing wp-config.php file");

        $cliConfigurator = new Lib\CliConfigure($setParameters);
        $configString   = $cliConfigurator->buildWpConfig();

        exec("wp $configString");

        $configFinal = new Lib\ConfigFileFinalizer($setParameters);
        $createFile  = $configFinal->finalizeConfig();

        if (!$createFile) {
            $messageHandler->writeErrorToConsole("Error writing wp-config.php");
            exit();
        }

        $messageHandler->writeStatusToConsole("Creating the database.");

        exec("wp db  --path=" . $setParameters->getWpDirectory() . " create");

        exec("mv " . $setParameters->getWpDirectory() . "/wp-config.php wp-config.php");

        $messageHandler->writeStatusToConsole("Database creation complete.");
        $messageHandler->writeStatusToConsole("Generating .htaccess file.");
        
        $htaccess = new Lib\HtaccessGenerator($setParameters);
        $content = $htaccess->htaccessContent();
        $htaccessFile = $htaccess->writeHtaccess($content);

        if (!$htaccessFile) {
            $messageHandler->writeErrorToConsole("Error writing .htaccess file.");
            exit();
        }

        $messageHandler->writeStatusToConsole(".htaccess file created.");
    }
}
