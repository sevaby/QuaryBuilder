<?php


class QueryBuilder
{
    protected PDO $pdo;

    private string $select = '*';
    private string $from;
    private ?string $where;
    private ?array $param;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(array $select): self
    {
        $strSelect = implode(',',$select);
        $this->select = $strSelect;
        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function where(string $where): self
    {
        $this->where = $where;
        return $this;
    }

    public function setParameters(array $param): self
    {
        $this->param = $param;
        return $this;
    }

    public function execute(): array
    {
        $sql = $this->getSQL();

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(':id', $this->param['id'] );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
        // bind parameters
        // run sql query
    }


    public function getSQL(): string
    {
     //@TODO create paramets from array

        if (isset($this->where) && isset($this->param)){
            $sql = "SELECT {$this->select} FROM {$this->from} WHERE {$this->where}";
            return $sql;
        }
        else {
            $sql = "SELECT {$this->select} FROM {$this->from}";
            return $sql;
        }
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