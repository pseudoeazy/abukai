<?php

namespace Models;

use \PDOStatement;

abstract class DbQuery extends DbConnection
{
    protected $pdo;
    /**
     * @param $sql
     * @param array $parameters
     * @return bool|PDOStatement
     */
    protected function query($sql, array $parameters = [])
    {
        $this->pdo = parent::dbConnect();
        $result = $this->pdo->prepare($sql);
        $result->execute($parameters);
        return $result;
    }
}
