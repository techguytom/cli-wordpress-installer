<?php

namespace Techguytom\CliWordpressInstaller;

use Composer\Script\Event;
use Symfony\Component\Yaml\Parser;

class InstallHandler {

    private $_io;

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

        $databaseString = $cliConfigurator->databaseChanges();

        if ($databaseString) {
            file_put_contents('dbpath.sql', $databaseString);
            exec("wp db --path=" . $setParameters->getWpDirectory() . " query < dbpath.sql");    
            unlink('dbpath.sql');
        }

        $messageHandler->writeStatusToConsole("Database changes complete.");
    }
}
