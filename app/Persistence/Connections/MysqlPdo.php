<?php

namespace App\Persistence\Connections;

use PDO;
use Exception;
use PDOException;

final class MysqlPdo implements ConnectionInterface
{
    private $connection;

    public function __construct() 
    {
        $dbHost = getenv('DB_HOST');
        $dbName = getenv('DB_DATABASE');
        $dbUser = getenv('DB_USERNAME');
        $dbPass = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
        try {
            $this->connection = new PDO($dsn, $dbUser, $dbPass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function query($statement, $params = []): array
    {
        try {
            $stmt = $this->connection->prepare($statement);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Query execution failed: " . $e->getMessage());
        }
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_values($data));
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Insertion failed: " . $e->getMessage());
        }
    }

    public function update(string $table, array $data, array $where): int
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(', ', $set);

        $whereConditions = [];
        foreach ($where as $key => $value) {
            $whereConditions[] = "$key = ?";
        }
        $whereConditions = implode(' AND ', $whereConditions);

        $sql = "UPDATE $table SET $set WHERE $whereConditions";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge(array_values($data), array_values($where)));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Update failed: " . $e->getMessage());
        }
    }

    public function delete(string $table, array $where): int
    {
        $whereConditions = [];
        foreach ($where as $key => $value) {
            $whereConditions[] = "$key = ?";
        }
        $whereConditions = implode(' AND ', $whereConditions);

        $sql = "DELETE FROM $table WHERE $whereConditions";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_values($where));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Deletion failed: " . $e->getMessage());
        }
    }

    public function count(string $table, array $where = []): int
    {
        $whereConditions = [];
        foreach ($where as $key => $value) {
            $whereConditions[] = "$key = ?";
        }
        $whereConditions = implode(' AND ', $whereConditions);

        $sql = "SELECT COUNT(*) as count FROM $table";
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_values($where));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['count'];
        } catch (PDOException $e) {
            throw new Exception("Count query failed: " . $e->getMessage());
        }
    }

    public function select(string $table, array $columns, array $where = []): array
    {
        $columnsList = implode(', ', $columns);

        $whereConditions = [];
        foreach ($where as $key => $value) {
            $whereConditions[] = "$key = ?";
        }
        $whereConditions = implode(' AND ', $whereConditions);

        $sql = "SELECT $columnsList FROM $table";
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_values($where));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Select query failed: " . $e->getMessage());
        }
    }

    public function find(string $table, array $columns, array $where = []): array
    {
        $result = $this->select($table, $columns, $where);
        if (count($result) === 0) {
            throw new Exception("No records found");
        }

        return $result[0];
    }
}
