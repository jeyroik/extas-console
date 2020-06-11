<?php
namespace tests\console;

use extas\commands\DefaultCommand;
use extas\components\console\TSnuffConsole;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommandTest
 * 
 * @package tests\console
 * @author jeyroik <jeyroik@gmail.com>
 */
class CommandTest extends TestCase
{
    use TSnuffConsole;

    public function testDispatch()
    {
        $command = new class extends DefaultCommand{
            protected string $commandTitle = 'test';
            protected string $commandVersion = '1.0.0';
            protected function dispatch(InputInterface $input, OutputInterface &$output): void
            {

            }
        };

        $output = $this->getOutput(true);
        $command->run($this->getInput(), $output);
        $outputText = $output->fetch();
        $this->assertStringContainsString(
            'test v1.0.0',
            $outputText,
            'Missed command title: ' . $outputText
        );
        $this->assertStringContainsString(
            'Finished in',
            $outputText,
            'Missed elapsed time: ' . $outputText
        );
    }
}
