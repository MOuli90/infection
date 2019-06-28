<?php
/**
 * This code is licensed under the BSD 3-Clause License.
 *
 * Copyright (c) 2017, Maks Rafalko
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * * Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

declare(strict_types=1);

namespace Infection\Tests\Config;

use Infection\Config\ConsoleHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class ConsoleHelperTest extends TestCase
{
    public function test_it_writes_to_section(): void
    {
        $formatHelper = $this->createMock(FormatterHelper::class);
        $formatHelper->expects($this->once())
            ->method('formatBlock')
            ->with(
                'foo',
                'bg=blue;fg=white',
                true
            )
            ->willReturn('Formatted Foo');

        $output = $this->createMock(OutputInterface::class);
        $output->expects($this->once())
            ->method('writeln')->with(
                [
                    '',
                    'Formatted Foo',
                    '',
                ]
            );
        $console = new ConsoleHelper($formatHelper);

        $console->writeSection($output, 'foo');
    }

    public function test_get_question_with_no_default(): void
    {
        $consoleHelper = new ConsoleHelper(new FormatterHelper());

        $this->assertSame(
            '<info>Would you like a cup of tea?</info>: ',
            $consoleHelper->getQuestion('Would you like a cup of tea?')
        );
    }

    public function test_get_question_with_default(): void
    {
        $consoleHelper = new ConsoleHelper(new FormatterHelper());

        $this->assertSame(
            '<info>Would you like a cup of tea?</info> [<comment>yes</comment>]: ',
            $consoleHelper->getQuestion('Would you like a cup of tea?', 'yes')
        );
    }
}
