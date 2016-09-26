<?php

namespace Pantheon\Terminus\UnitTests\Commands\Connection;

use Consolidation\OutputFormatters\StructuredData\AssociativeList;
use Pantheon\Terminus\Commands\Connection\InfoCommand;
use Pantheon\Terminus\Config;

use Prophecy\Prophet;
use Terminus\Models\Environment;
use Terminus\Models\Site;
use VCR\VCR;

/**
 * Test suite for class for Pantheon\Terminus\Commands\Connection\InfoCommand
 */
class InfoCommandTest extends ConnectionCommandTest
{
    private $prophet;

    /**
     * Test suite setup
     *
     * @return void
     */
    protected function setup()
    {
        parent::setUp();

        $this->command = new InfoCommand($this->getConfig());
        $this->command->setLogger($this->logger);
        $this->prophet = new Prophet;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->prophet->checkPredictions();
    }


    /**
     * Exercises connection:info command with a valid environment
     *
     * @return void
     *
     * @vcr site_connection-info
     */
    public function testConnectionInfo()
    {
        // command output with a valid site
        $out = $this->command->connectionInfo('behat-tests.dev');

        // should return a RowOfFields object
        $this->assertInstanceOf(AssociativeList::class, $out);

        // should have a field structure
        $connection_info = $out->getArrayCopy();

        // should contain connection parameters
        $connection_keys = array_keys($connection_info);
        $this->assertContains('sftp_command', $connection_keys);
        $this->assertContains('git_command', $connection_keys);
        $this->assertContains('mysql_command', $connection_keys);
        $this->assertContains('redis_command', $connection_keys);
    }

    /**
     * Exercises connection:info command without a valid environment argument
     *
     * @return void
     *
     * @expectedException \Exception
     * @expectedExceptionMessage The environment argument must be given as <site_name>.<environment>
     */
    public function testConnectionInfoInvalid()
    {
        // should return the correct type and structure
        $out = $this->command->connectionInfo('invalid-env');
    }
}