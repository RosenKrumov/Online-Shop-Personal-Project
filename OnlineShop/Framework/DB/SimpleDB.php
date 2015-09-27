<?php


namespace Framework\DB;


use Framework\App;

class SimpleDB
{
    protected $connection = null;
    private $db = null;
    private $stmt = null;
    private $params = [];
    private $sql;

    public function __construct($connection = null)
    {
        if($connection instanceof \PDO){
            $this->db = $connection;
        } else if($connection != null){
            $this->db = App::getInstance()->getDbConnection($connection);
            $this->connection = $connection;
        } else {
            $this->db = App::getInstance()->getDbConnection($this->connection);
        }
    }

    public function prepare($sql, $params = [], $pdoOptions = []){
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        return $this;
    }

    public function execute($params = []){
        if($params){
            $this->params = $params;
        }

        $this->stmt->execute($this->params);
        return $this;
    }

    public function fetchAllAssoc(){
        return $this->stmt->fetchall(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc(){
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum(){
        return $this->stmt->fetchall(\PDO::FETCH_NUM);
    }

    public function fetchRowNum(){
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj(){
        return $this->stmt->fetchall(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj(){
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllColumn($column){
        return $this->stmt->fetchall(\PDO::FETCH_COLUMN, $column);
    }

    public function fetchRowColumn($column){
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $column);
    }

    public function fetchAllClass($class){
        return $this->stmt->fetchall(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class){
        return $this->stmt->fetch(\PDO::FETCH_CLASS, $class);
    }

    public function getLastInsertId(){
        return $this->db->lastInsertId();
    }

    public function getAffectedRows(){
        return $this->stmt->rowCount();
    }

    public function getStmt(){
        return $this->stmt;
    }
}