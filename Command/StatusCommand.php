<?php
/**
 * Released under the MIT License.
 *
 * Copyright (c) 2017 Miha Vrhovnik <miha.vrhovnik@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace mvrhov\PhinxBundle\Command;

use Phinx\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends AbstractCommand
{
    use CommonTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('phinx:status')
            ->setDescription('Show migration status')
            ->addOption(
                '--format',
                '-f',
                InputOption::VALUE_REQUIRED,
                'The output format: text or json. Defaults to text.'
            )
            ->setHelp(
<<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

<info>phinx status</info>
<info>phinx status -f json</info>
EOT
            );
    }

    /**
     * Show the migration status.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return integer 0 if all migrations are up, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initialize($input, $output);

        $format = $input->getOption('format');

        if (null !== $format) {
            $output->writeln('<info>using format</info> ' . $format);
        }

        // print the status
        return $this->getManager()->printStatus('default', $format);
    }
}
