<?php
/**
 * @project Junit Converter
 * @file Severity.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\JUnit;

enum Severity
{
    case Warning;

    case Info;

    case Error;
}
