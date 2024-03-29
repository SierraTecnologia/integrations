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

use Integrations\Tools\Programs\Git\Reference;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Stash extends Reference
{
    public function getName(): string
    {
        return 'stash';
    }
}
