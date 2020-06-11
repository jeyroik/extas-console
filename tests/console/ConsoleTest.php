<?php
namespace tests\console;

use extas\interfaces\IHasIO;

use extas\components\console\TSnuffConsole;
use extas\components\THasIO;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleTest
 *
 * @package tests
 * @author jeyroik <jeyroik@gmail.com>
 */
class ConsoleTest extends TestCase
{
    use TSnuffConsole;

    public function testIO()
    {
        /**
         * @var BufferedOutput $output
         */
        $output = $this->getOutput(true);

        $item = new class ([
            IHasIO::FIELD__INPUT => $this->getInput(['test' => 'is ok']),
            IHasIO::FIELD__OUTPUT => $output
        ]) {
            use THasIO;
            protected array $config = [];
            public function __construct(array $config = [])
            {
                $this->config = $config;
            }
        };

        $this->assertInstanceOf(InputInterface::class, $item->getInput());
        $this->assertInstanceOf(OutputInterface::class, $item->getOutput());
        $item->writeLn(['test']);
        $item->errorLn(['test error']);
        $item->infoLn(['test info']);
        $item->commentLn(['test comment']);
        $item->decorateLines(['test decor'], 'notice');

        $outputText = $output->fetch();

        $messages = ['test', 'test error', 'test info', 'test comment', 'test decor'];
        foreach ($messages as $message) {
            $this->assertStringContainsString($message, $outputText);
        }

        $this->assertCount(2, $item->getIO());
        $this->assertEquals('is ok', $item->getInputOption('test', 'default'));
        $this->assertEquals('default', $item->getInputOption('unknown', 'default'));
    }
}
