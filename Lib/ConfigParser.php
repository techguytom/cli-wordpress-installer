<?php
/**
 * Config Parser
 *
 * @category Installer
 * @package  WordPress
 * @author   Tom Jenkins <tom@techguytom.com>
 */

namespace Techguytom\CliWordpressInstaller\Lib;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * ConfigParser
 *
 * @package WordPress
 * @author Tom Jenkins <tom@techguytom.com>
 * @version $Id$
 */
class ConfigParser
{
    /**
     * _parser
     *
     * @var obj
     */
    private $_parser;

    /**
     * _file
     *
     * @var str
     */
    private $_file;

    /**
     * __construct
     *
     * @param Parser $parser The Incentive Parser
     * @param str $configFile The name of the file to parse
     *
     * @return void
     */
    public function __construct(Parser $parser, $configFile)
    {
        $this->_parser = $parser;
        $this->_file = $configFile;
    }

    /**
     * parseParameters
     *
     * @return obj The parameters object
     */
    public function parseParameters()
    {
        try {
            $parameters = $this->_parser->parse(file_get_contents($this->_file));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }

        if (!isset($parameters['parameters'])) {
            throw new \InvalidArgumentException(
                "The parameters yaml file is not properly configured. It must be contained within a 'parameters' array"
            );

        }

        return (object) $parameters['parameters'];
    }
}
