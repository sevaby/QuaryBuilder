<?php


class QueryBuilder
{
    protected PDO $pdo;

    private string $select = '*';
    private string $from;
    private ?string $where;
    private ?string $andWhere;
    private ?string $orWhere;
    private ?array $params;
    private ?string $limit;
    private ?string $orderBy;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(array $select): self
    {
        $strSelect = implode(',', $select);
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

    public function andWhere(string $andWhere): self
    {
        $this->andWhere = $andWhere;
        return $this;
    }

    public function orWhere(string $orWhere): self
    {
        $this->orWhere = $orWhere;
        return $this;
    }

    public function limit(string $limit): self
    {
        $this->limit = $limit;
    }

    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
    }

    public function setParameters(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function execute(): array
    {

        $sql = $this->getSQL();
        var_dump($sql);

        $statement = $this->pdo->prepare($sql);
        foreach ($this->params as $param => $value) {
            $statement->bindValue($param, $value);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }


    public function getSQL(): string
    {

        if (isset($this->where) && isset($this->params)) {
            if (isset($this->andWhere) && isset($this->orWhere)) {
                $sql = "SELECT {$this->select} FROM {$this->from} WHERE {$this->where} AND {$this->andWhere} OR {$this->orWhere}";
                return $sql;
            } else {
                if (isset($this->andWhere)) {
                    $sql = "SELECT {$this->select} FROM {$this->from} WHERE {$this->where} AND {$this->andWhere}";
                    return $sql;
                } elseif (isset($this->orWhere)) {
                    $sql = "SELECT {$this->select} FROM {$this->from} WHERE {$this->where} OR {$this->orWhere}";
                    return $sql;
                }
            }
                $sql = "SELECT {$this->select} FROM {$this->from} WHERE {$this->where}";
                return $sql;

        } else {
            $sql = "SELECT {$this->select} FROM {$this->from}";
            return $sql;
        }
    }


    public
    function selectAll($table)
    {
        $sql = "SELECT * FROM $table";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public
    function selectOne($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


}