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
namespace Integrations\Tools\Programs\Git;

use Pedreiro\Exceptions\InvalidArgumentException;
use Pedreiro\Exceptions\LogicException;

/**
 * Hooks collection, aggregated by repository.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Hooks
{
    /**
     * @var Integrations\Tools\Programs\Git\Repository
     */
    protected $repository;

    /**
     * @var Repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Tests if repository has a given hook.
     *
     * @param string $name Name of the hook
     *
     * @return bool
     */
    public function has($name)
    {
        return file_exists($this->getPath($name));
    }

    /**
     * Fetches content of a hook.
     *
     * @param string $name Name of the hook
     *
     * @return string Content of the hook
     *
     * @throws InvalidArgumentException Hook does not exist
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Hook named "%s" is not present', $name));
        }

        return file_get_contents($this->getPath($name));
    }

    /**
     * Insert a hook in repository using a symlink.
     *
     * @param string $name Name of the hook to insert
     * @param string $file Target of symlink
     *
     * @throws LogicException   Hook is already present
     * @throws RuntimeException Error on symlink creation
     *
     * @return void
     */
    public function setSymlink($name, $file): void
    {
        if ($this->has($name)) {
            throw new LogicException(sprintf('A hook "%s" is already defined', $name));
        }

        $path = $this->getPath($name);
        if (false === symlink($file, $path)) {
            throw new RuntimeException(sprintf('Unable to create hook "%s"', $name, $path));
        }
    }

    /**
     * Set a hook in repository.
     *
     * @param string $name    Name of the hook
     * @param string $content Content of the hook
     *
     * @throws LogicException The hook is already defined
     *
     * @return void
     */
    public function set($name, $content): void
    {
        if ($this->has($name)) {
            throw new LogicException(sprintf('A hook "%s" is already defined', $name));
        }

        $path = $this->getPath($name);
        file_put_contents($path, $content);
        chmod($path, 0777);
    }

    /**
     * Removes a hook from repository.
     *
     * @param string $name Name of the hook
     *
     * @throws LogicException The hook is not present
     *
     * @return void
     */
    public function remove($name): void
    {
        if (!$this->has($name)) {
            throw new LogicException(sprintf('The hook "%s" was not found', $name));
        }

        unlink($this->getPath($name));
    }

    protected function getPath(string $name): string
    {
        return $this->repository->getGitDir().'/hooks/'.$name;
    }
}
