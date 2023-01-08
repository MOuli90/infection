<?php

declare(strict_types=1);

namespace Infection\TestFramework;

/**
 * @internal
 */
interface VersionParserInterface
{
    public function parse(string $content): string;
}
