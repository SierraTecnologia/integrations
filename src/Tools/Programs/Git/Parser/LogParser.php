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

class LogParser extends CommitParser
{
    public $log = array();

    /**
     * @return void
     */
    protected function doParse()
    {
        $this->log = array();

        while (!$this->isFinished()) {
            $commit = array();
            $this->consume('commit ');
            $commit['id'] = $this->consumeHash();
            $this->consumeNewLine();

            $this->consume('tree ');
            $commit['treeHash'] = $this->consumeHash();
            $this->consumeNewLine();

            $commit['parentHashes'] = array();
            while ($this->expects('parent ')) {
                $commit['parentHashes'][] = $this->consumeHash();
                $this->consumeNewLine();
            }

            $this->consume('author ');
            list($commit['authorName'], $commit['authorEmail'], $commit['authorDate']) = $this->consumeNameEmailDate();
            $commit['authorDate'] = $this->parseDate($commit['authorDate']);
            $this->consumeNewLine();

            $this->consume('committer ');
            list($commit['committerName'], $commit['committerEmail'], $commit['committerDate']) = $this->consumeNameEmailDate();
            $commit['committerDate'] = $this->parseDate($commit['committerDate']);

            // will consume an GPG signed commit if there is one
            $this->consumeGPGSignature();

            $this->consumeNewLine();
            $this->consumeNewLine();

            $message = '';
            if ($this->expects('    ')) {
                $this->cursor -= strlen('    ');

                while ($this->expects('    ')) {
                    $message .= $this->consumeTo("\n")."\n";
                    $this->consumeNewLine();
                }
            } else {
                $this->cursor--;
            }

            if (!$this->isFinished()) {
                $this->consumeNewLine();
            }

            $commit['message'] = $message;

            $this->log[] = $commit;
        }
    }
}
