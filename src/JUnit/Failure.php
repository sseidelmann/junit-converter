<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\JUnit;

class Failure
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    /**
     * @var null|string
     */
    private $description;

    public function __construct(
        string $type,
        string $message,
        ?string $description = null
    ) {
        $this->type = $type;
        $this->message = $message;
        $this->description = $description;
    }

    public static function Generic(string $severity, string $message, ?string $description = null) {
        return new self($severity, $message, $description);
    }

    public static function Warning(string $message, ?string $description = null) {
        return self::Generic('warning', $message, $description);
    }

    public static function Info(string $message, ?string $description = null) {
        return self::Generic('info', $message, $description);
    }

    public function toXML(\DOMDocument $document): \DOMNode {
        $node = $document->createElement('failure', $this->description);
        $node->setAttribute('type', $this->type);
        $node->setAttribute('message', $this->message);

        return $node;
    }
}
