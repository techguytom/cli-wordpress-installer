<?php

namespace Techguytom\CliWordpressInstaller;

use Composer\Script\Event;

class InstallHandler {

    public static function cliInstall(Event $event)
    {
        
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

        $configFile   = $extras['incenteev-parameters']['file'];
        $cliProcessor = new CliProcessor($event->getIO());

        //$cliProcessor->getParameters($configFile);
        
    }
}
