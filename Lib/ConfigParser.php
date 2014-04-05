<?php

namespace Techguytom\CliWordpressInstaller\Lib;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class ConfigParser
{
    private $_parser;

    private $_file;

    public function __construct(Parser $parser, $configFile)
    {
        $this->_parser = $parser;
        $this->_file = $configFile;
    }

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
