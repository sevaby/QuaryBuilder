<?php


class DataBaseGateway
{
    protected PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(',:', array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function update($table, $data, $id)
    {
        $keys = array_keys($data);
        $str = '';
        foreach ($keys as $key) {
            $str .= $key . '=:' . $key . ',';
        }
        $keys = rtrim($str, ',');
        $data['id'] = $id;
        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute($data);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}