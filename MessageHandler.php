<?php

namespace Techguytom\CliWordpressInstaller;

use Composer\IO\IOInterface;

class MessageHandler {

    private $_io;

    public function __construct(IOInterface $io)
    { 
        $this->_io = $io;
    }

    public function writeStatusToConsole($message)
    {
        $this->_io->write("<info>" . $message . "</info>");
    }

    public function writeErrorToConsole($message)
    {
        $this->_io->write("<error>" . $message . "</error>");
    }
}
