<?php
namespace Steel\Database;

interface IConnection{
    public function insert($table, $values = []);
    public function select($table, $conditions = [], $columns = []);
    public function update($table, $updates = [], $conditions = []);
    public function delete($table, $conditions = []);
    public function prepared($statement, $values);
    public function query($query);
}