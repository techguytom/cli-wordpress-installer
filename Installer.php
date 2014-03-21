<?php

namespace Techguytom\CliWordpressInstaller;

use Symfony\Component\Yaml\Parser;
use Composer\Script\Event;

class Installer {
    public static function cliInstall(Event $event)
    {
        $parser = new Parser();
        var_dump($parser);
    }
}
