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
namespace Integrations\Tools\Programs\Git\Reference;

use Pedreiro\Exceptions\RuntimeException;
use Integrations\Tools\Programs\Git\Reference;

/**
 * Representation of a tag reference.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Tag extends Reference
{
    public function getName(): string
    {
        if (!preg_match('#^refs/tags/(.*)$#', $this->revision, $vars)) {
            throw new RuntimeException(sprintf('Cannot extract tag name from "%s"', $this->revision));
        }

        return $vars[1];
    }
}
