<?php

namespace App\Persistence\Connections;

interface ConnectionInterface {
    public function query($statement, $params = []);
    public function find(string $table, array $columns, array $where = []);
    public function select(string $table, array $columns, array $where = []);
    public function insert(string $table, array $data);
    public function delete(string $table, array $where);
    public function update(string $table, array $data, array $where);
    public function count(string $table, array $where = []);
}
