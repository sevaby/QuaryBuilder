<?php


class QueryBuilder
{
    protected PDO $pdo;

    private array $select;
    private string $from;
    private ?array $andWhere = null;
    private ?array $orWhere = null;
    private ?array $params = null;
    private ?string $limit = null;
    private ?array $orderBy = null;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(array $select): self
    {
//        $strSelect = implode(',', $select);
        $this->select = $select;
        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function where(string $where): self
    {
        return $this->andWhere($where);
    }

    public function andWhere(string $andWhere): self
    {
        $this->andWhere[] = $andWhere;
        return $this;
    }

    public function orWhere(string $orWhere): self
    {
        $this->orWhere[] = $orWhere;
        return $this;
    }

    public function limit(string $limit): self
    {
        $this->limit = $limit;
    }

    public function orderBy(array $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setParameters(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function execute(): array
    {

        $sql = $this->getSQL();
//        var_dump($sql);

        $statement = $this->pdo->prepare($sql);
        if (isset($this->params)) {
            foreach ($this->params as $param => $value) {
                $statement->bindValue($param, $value);
            }
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getSQL(): string
    {
        $sql = "SELECT ";
        if ($this->select) {
            $select = implode(', ', $this->select);
            $sql .= $select;
        } else {
            $sql = "{$this->select}";
        }
        $sql .= " FROM {$this->from}";

        if ($this->andWhere) {
            $sql .= ' WHERE (' . implode(' AND ', $this->andWhere) . ')';
        }
        if (($this->orWhere) && $this->andWhere) {
            $sql .= ' OR ' . implode(' OR ', $this->orWhere);
        }
        if ($this->orderBy) {
            $sql .= ' ORDER BY ';
            foreach ($this->orderBy as $order => $by) {
                $sql .= $order . ' ' . $by . ', ';
            }
            $sql = rtrim($sql, ', ');

        }

        return $sql;

    }


    private function isWhere(): bool
    {
        return $this->andWhere || $this->orWhere;
    }

}