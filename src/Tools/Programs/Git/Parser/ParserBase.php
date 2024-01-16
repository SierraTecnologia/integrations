<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Integrations\Tools\Programs\Git\Parser;

use Pedreiro\Exceptions\RuntimeException;

abstract class ParserBase
{
    protected $cursor;
    protected $content;
    protected $length;

    abstract protected function doParse();

    public function parse(string $content): void
    {
        $this->cursor = 0;
        $this->content = $content;
        $this->length = strlen($this->content);

        $this->doParse();
    }

    protected function isFinished(): bool
    {
        return $this->cursor === $this->length;
    }

    /**
     * @return false|string
     */
    protected function consumeAll()
    {
        $rest = substr($this->content, $this->cursor);
        $this->cursor += strlen($rest);

        return $rest;
    }

    protected function expects(string $expected): bool
    {
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual !== $expected) {
            return false;
        }

        $this->cursor += $length;

        return true;
    }

    protected function consumeShortHash(): string
    {
        if (!preg_match('/([A-Za-z0-9]{7,40})/A', $this->content, $vars, null, $this->cursor)) {
            throw new RuntimeException('No short hash found: '.substr($this->content, $this->cursor, 7));
        }

        $this->cursor += strlen($vars[1]);

        return $vars[1];
    }

    protected function consumeHash(): string
    {
        if (!preg_match('/([A-Za-z0-9]{40})/A', $this->content, $vars, null, $this->cursor)) {
            throw new RuntimeException('No hash found: '.substr($this->content, $this->cursor, 40));
        }

        $this->cursor += 40;

        return $vars[1];
    }

    /**
     * @return string[]
     *
     * @psalm-return array<string>
     */
    protected function consumeRegexp(string $regexp): array
    {
        if (!preg_match($regexp.'A', $this->content, $vars, null, $this->cursor)) {
            throw new RuntimeException('No match for regexp '.$regexp.' Upcoming: '.substr($this->content, $this->cursor, 30));
        }

        $this->cursor += strlen($vars[0]);

        return $vars;
    }

    /**
     * @param string $text
     *
     * @return false|string
     */
    protected function consumeTo(string $text)
    {
        $pos = strpos($this->content, $text, $this->cursor);

        if (false === $pos) {
            throw new RuntimeException(sprintf('Unable to find "%s"', $text));
        }

        $result = substr($this->content, $this->cursor, $pos - $this->cursor);
        $this->cursor = $pos;

        return $result;
    }

    protected function consume(string $expected): string
    {
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual !== $expected) {
            throw new RuntimeException(sprintf('Expected "%s", but got "%s" (%s)', $expected, $actual, substr($this->content, $this->cursor, 10)));
        }
        $this->cursor += $length;

        return $expected;
    }

    protected function consumeNewLine()
    {
        return $this->consume("\n");
    }

    /**
     * @return string
     */
    protected function consumeGPGSignature()
    {
        $expected = "\ngpgsig ";
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual != $expected) {
            return '';
        }
        $this->cursor += $length;

        return $this->consumeTo("\n\n");
    }
}
