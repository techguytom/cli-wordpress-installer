<?php
/**
 * MessageHandler.php
 *
 * @category Utility
 * @package  Composer
 * @author   Tom Jenkins <tom@techguytom.com>
 */

namespace Techguytom\CliWordpressInstaller;

use Composer\IO\IOInterface;

/**
 * MessageHandler
 *
 * Handle output of messages to the console
 *
 * @package WordPress
 * @author  Tom Jenkins <tom@techguytom.com>
 * @param IOInterface Composer Input Output Interface
 * @version Release: 0.8
 */
class MessageHandler
{
    /**
     * _io
     *
     * @var obj
     */
    private $_io;

    /**
     * __construct
     *
     * @param IOInterface $io The composer IO interface
     *
     * @return ref
     */
    public function __construct(IOInterface $io)
    { 
        $this->_io = $io;
    }

    /**
     * writeStatusToConsole
     *
     * @param str $message Status message for console
     *
     * @return void
     */
    public function writeStatusToConsole($message)
    {
        $this->_io->write("<info>" . $message . "</info>");
    }

    /**
     * writeErrorToConsole
     *
     * @param str $message Error message for console
     *
     * @return void
     */
    public function writeErrorToConsole($message)
    {
        $this->_io->write("<error>" . $message . "</error>");
    }
}
