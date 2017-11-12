<?php

namespace cwreden\php7ccAnalyser\Console;

use cwreden\php7ccAnalyser\Console\PHP7CCAnalyseCommand;
use Symfony\Component\Console\Input\InputInterface;

class Application extends \Symfony\Component\Console\Application
{
    const VERSION = '0.1.0';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('PHP 7 Compatibility Check Analyser', static::VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return PHP7CCAnalyseCommand::COMMAND_NAME;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new PHP7CCAnalyseCommand();

        return $defaultCommands;
    }
}