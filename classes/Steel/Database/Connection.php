<?php
namespace Steel\Database;

use Steel\Database\IConnection;
use \PDO;

class Connection implements IConnection{
    
    private $conn;
    
    public function __construct($database){
        if($database['enabled']){
            try {
                $this->conn = new PDO ('mysql:dbname='.$database['dbname'].';host='.$database['ip'].';port='.$database['port'], $database['username'], $database['password'], array(PDO::ATTR_PERSISTENT => TRUE));
                $this->conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                $this->conn->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
                $this->conn->exec ( "SET NAMES utf8" );
            } catch (PDOException $e){
                die($e);
            }
        }else{
            return null;
        }
    }
    
    public function delete($table, $conditions = []) {
        if(empty($table)){
            return 999;
        }
        $statement = sprintf("DELETE FROM `%s` WHERE", (string)$table);
        $preparedValues = [];
        if(empty($conditions)){
            $statement .= " 1";
        }else{
            $lastcolumn = \Steel\ArrayMethods::lastKey($conditions);
            foreach($conditions as $column => $value){
                if($column === $lastcolumn){
                    $statement .= " ".$column." = ?";
                }else{
                    $statement .= " ".$column." = ? AND";
                }
                array_push($preparedValues, $value);
            }
        }
        $stmt = $this->conn->prepare($statement);
        $stmt->execute($preparedValues);
        return $stmt->errorCode();
    }

    public function insert($table, $values = []) {
        $statement = sprintf("INSERT INTO %s (", $table);
        if(empty($values) || empty($table)){
            return 999;
        }
        foreach($values as $key => $val){
            if($key === \Steel\ArrayMethods::lastKey($values)){
                $statement .= sprintf("`%s`)", (string)$key);
            }else{
                $statement .= sprintf("`%s`, ", (string)$key);
            }
        }
        $statement .= " VALUES (";
        $size = count($values) - 1;
        if($size === 1){
            $statement .= "?);";
        }else{
            for($k = 0; $k < $size && $k != $size; $k++){
                $statement .= "?, ";
            }
            $statement .= "?);";
        }
        $stmt = $this->conn->prepare($statement);
        echo $stmt->queryString;
        $stmt->execute(array_values($values));
        return $stmt->errorCode();
    }

    public function prepared($statement, $values = [], $giveresults = false) {
        if(empty($statement)){
            return 999;
        }
        $stmt = $this->conn->prepare($statement);
        $stmt->execute($values);
        if($giveresults){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function query($query) {
        if(empty($query)){
            return 999;
        }
        return $this->conn->query($query);
    }

    public function select($table, $conditions = [], $columns = []) {
        if(empty($table)){
            return 999;
        }
        $statement = "SELECT ";
        if(empty($columns)){
            $statement .= "* ";
        }else{
            $sanitized = array_values($columns);
            if(count($columns) === 1){
                $statement .= sprintf("%s ", (string)$sanitized[0]);
            }else{
                foreach($columns as $column){
                    if($column !== \Steel\ArrayMethods::lastValue($columns)){
                        $statement .= sprintf("%s, ", (string)$column);
                    }else{
                        $statement .= sprintf("%s ", (string)$column);
                    }
                }
            }
        }
        $statement .= sprintf("FROM `%s` WHERE ", $table);
        if(empty($conditions)){
            $statement .= "1";
        }else{
            foreach($conditions as $column => $row){
                if($column !== \Steel\ArrayMethods::lastKey($conditions)){
                    $statement .= sprintf("`%s` = ? AND ", (string)$column);
                }else{
                    $statement .= sprintf("`%s` = ?;", (string)$column);
                }
            }
        }
        $stmt = $this->conn->prepare($statement);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $updates = [], $conditions = []) {
        if(empty($table) || empty($updates)){
            return 999;
        }
        $statement = sprintf("UPDATE `%s` SET ", $table);
        if(count($updates === 1)){
            $statement .= sprintf("`%s` = ? ", key($updates));
        }else{
            foreach($updates as $column => $newcolumn){
                if($column !== \Steel\ArrayMethods::lastKey($updates)){
                    $statement .= sprintf("`%s` = ?, ", $column);
                }else{
                    $statement .= sprintf("`%s` = ?;", $column);
                }
            }
        }
        $statement .= " WHERE ";
        if(empty($conditions)){
            $statement .= "1";
        }else{
            foreach($conditions as $column => $row){
                if($column !== \Steel\ArrayMethods::lastKey($conditions)){
                    $statement .= sprintf("`%s` = ? AND ", (string)$column);
                }else{
                    $statement .= sprintf("`%s` = ?;", (string)$column);
                }
            }
        }
        $stmt = $this->conn->prepare($statement);
        $updateValues = array_values($updates);
        $conditionValues = array_values($conditions);
        $stmt->execute(array_merge($updateValues, $conditionValues));
        return $stmt->errorCode();
    }
    
    public function getConnection(){
        return $this->conn;
    }

}