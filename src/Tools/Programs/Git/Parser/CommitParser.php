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

class CommitParser extends ParserBase
{
    public $tree;
    public $parents;
    public $authorName;
    public $authorEmail;
    public $authorDate;
    public $committerName;
    public $committerEmail;
    public $committerDate;
    public $message;

    /**
     * @return void
     */
    protected function doParse()
    {
        $this->consume('tree ');
        $this->tree = $this->consumeHash();
        $this->consumeNewLine();

        $this->parents = array();
        while ($this->expects('parent ')) {
            $this->parents[] = $this->consumeHash();
            $this->consumeNewLine();
        }

        $this->consume('author ');
        list($this->authorName, $this->authorEmail, $this->authorDate) = $this->consumeNameEmailDate();
        $this->authorDate = $this->parseDate($this->authorDate);
        $this->consumeNewLine();

        $this->consume('committer ');
        list($this->committerName, $this->committerEmail, $this->committerDate) = $this->consumeNameEmailDate();
        $this->committerDate = $this->parseDate($this->committerDate);

        // will consume an GPG signed commit if there is one
        $this->consumeGPGSignature();

        $this->consumeNewLine();

        $this->consumeNewLine();
        $this->message = $this->consumeAll();
    }

    /**
     * @return string[]
     *
     * @psalm-return array{0: string, 1: string, 2: string}
     */
    protected function consumeNameEmailDate(): array
    {
        if (!preg_match('/(([^\n]*) <([^\n]*)> (\d+ [+-]\d{4}))/A', $this->content, $vars, 0, $this->cursor)) {
            throw new RuntimeException('Unable to parse name, email and date');
        }

        $this->cursor += strlen($vars[1]);

        return array($vars[2], $vars[3], $vars[4]);
    }

    protected function parseDate(string $text): \DateTime
    {
        $date = \DateTime::createFromFormat('U e O', $text.' UTC');

        if (!$date instanceof \DateTime) {
            throw new RuntimeException(sprintf('Unable to convert "%s" to datetime', $text));
        }

        return $date;
    }
}
