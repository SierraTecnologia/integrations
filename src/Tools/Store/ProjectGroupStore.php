<?php

namespace Integrations\Tools\Store;

use PDO;
use PHPCensor\Database;
use PHPCensor\Exception\HttpException;
use PHPCensor\Model\ProjectGroup;
use Integrations\Tools\Store;

class ProjectGroupStore extends Store
{
    /**
     * @var string
     */
    protected $tableName  = 'project_group';

    /**
     * @var string
     */
    protected $modelName  = '\PHPCensor\Model\ProjectGroup';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Get a ProjectGroup by primary key (Id)
     *
     * @param int    $key
     * @param string $useConnection
     *
     * @return null|ProjectGroup
     */
    public function getByPrimaryKey($key, $useConnection = 'read')
    {
        return $this->getById($key, $useConnection);
    }

    /**
     * Get a single ProjectGroup by Id.
     *
     * @param int    $id
     * @param string $useConnection
     *
     * @return ProjectGroup|null
     *
     * @throws HttpException
     */
    public function getById($id, $useConnection = 'read')
    {
        if (is_null($id)) {
            throw new HttpException('Value passed to ' . __FUNCTION__ . ' cannot be null.');
        }

        $query = 'SELECT * FROM {{' . $this->tableName . '}} WHERE {{id}} = :id LIMIT 1';
        $stmt  = Database::getConnection($useConnection)->prepareCommon($query);

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return new ProjectGroup($data);
            }
        }

        return null;
    }

    /**
     * Get a single ProjectGroup by title.
     *
     * @param int    $title
     * @param string $useConnection
     *
     * @return ProjectGroup|null
     *
     * @throws HttpException
     */
    public function getByTitle($title, $useConnection = 'read')
    {
        if (is_null($title)) {
            throw new HttpException('Value passed to ' . __FUNCTION__ . ' cannot be null.');
        }

        $query = 'SELECT * FROM {{' . $this->tableName . '}} WHERE {{title}} = :title LIMIT 1';
        $stmt  = Database::getConnection($useConnection)->prepareCommon($query);

        $stmt->bindValue(':title', $title);

        if ($stmt->execute()) {
            if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return new ProjectGroup($data);
            }
        }

        return null;
    }
}
