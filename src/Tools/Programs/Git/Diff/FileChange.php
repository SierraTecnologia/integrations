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
namespace Integrations\Tools\Programs\Git\Diff;

class FileChange
{
    const LINE_CONTEXT = 0;
    const LINE_REMOVE = -1;
    const LINE_ADD = 1;

    protected $rangeOldStart;
    protected $rangeOldCount;
    protected $rangeNewStart;
    protected $rangeNewCount;
    protected $lines;

    public function __construct($rangeOldStart, $rangeOldCount, $rangeNewStart, $rangeNewCount, $lines)
    {
        $this->rangeOldStart = $rangeOldStart;
        $this->rangeOldCount = $rangeOldCount;
        $this->rangeNewStart = $rangeNewStart;
        $this->rangeNewCount = $rangeNewCount;
        $this->lines = $lines;
    }

    /**
     * @return int
     *
     * @psalm-return 0|positive-int
     */
    public function getCount($type)
    {
        $result = 0;
        foreach ($this->lines as $line) {
            if ($line[0] === $type) {
                ++$result;
            }
        }

        return $result;
    }

    public function getRangeOldStart()
    {
        return $this->rangeOldStart;
    }

    public function getRangeOldCount()
    {
        return $this->rangeOldCount;
    }

    public function getRangeNewStart()
    {
        return $this->rangeNewStart;
    }

    public function getRangeNewCount()
    {
        return $this->rangeNewCount;
    }

    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return array
     *
     * @psalm-return array{range_old_start: mixed, range_old_count: mixed, range_new_start: mixed, range_new_count: mixed, lines: mixed}
     */
    public function toArray(): array
    {
        return array(
            'range_old_start' => $this->rangeOldStart,
            'range_old_count' => $this->rangeOldCount,
            'range_new_start' => $this->rangeNewStart,
            'range_new_count' => $this->rangeNewCount,
            'lines' => $this->lines,
        );
    }

    public static function fromArray(array $array): self
    {
        return new self($array['range_old_start'], $array['range_old_count'], $array['range_new_start'], $array['range_new_count'], $array['lines']);
    }
}
