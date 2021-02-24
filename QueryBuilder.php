<?php


class QueryBuilder
{
    protected PDO $pdo;

    private string $select = '*';


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(string $select):self
    {
        $this->select = $select;
        return $this;
    }

    public function from(){

    }

    public function where(){

    }

      public function setParameters(){

    }

    public function execute():array
    {
        $sql = $this->getSQL();
        // bind parameters
        // run sql query
    }


    public function getSQL():string {
        return '';
    }















    public function selectAll($table)
    {
        $sql = "SELECT * FROM $table";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }







}