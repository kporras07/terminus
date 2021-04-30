<?php

namespace Pantheon\Terminus\UnitTests\Commands\Self;

use Pantheon\Terminus\Commands\Self\ConsoleCommand;
use Pantheon\Terminus\Config\TerminusConfig;
use Pantheon\Terminus\UnitTests\Commands\Env\EnvCommandTest;

/**
 * Class ConsoleCommandTest
 * Test suite class for Pantheon\Terminus\Commands\Self\ConsoleCommand
 * @package Pantheon\Terminus\UnitTests\Commands\Console
 */
class ConsoleCommandTest extends EnvCommandTest
{
    /**
     * @var TerminusConfig
     */
    protected $config;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->command = new ConsoleCommand();
        $this->command->setSites($this->sites);
    }

    /**
     * Tests the self:console command
     */
    public function testConsole()
    {
        $out = $this->command->console('site.env');
        $this->assertNull($out);
    }
}