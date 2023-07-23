<?php
namespace App\Model;

class Model
{
    protected $connection;

    public function __construct(){

    }

    public function __destructor(){
        if(!empty($this->connection)){
            $this->connection->close();
            $this->connection = '';
        }
    }

    public function closeConnection(){
        try {
            if(!empty($this->connection)){
                $this->connection->close();
                $this->connection = '';
            }
        }catch (\Exception $exception){

        }
    }

    public function getConnection(){
        if(empty($this->connection)) {
            $configs = getConfigs();
            $database_configs = $configs['database'];
            try {
                $conn = new \mysqli($database_configs['host'], $database_configs['user'], $database_configs['password'], $database_configs['database']);
                if($conn->connect_error){
                    throw new \Exception("Connection failed: ".$conn->connect_error);
                }
                $this->connection = $conn;
                return $this->connection;
            } catch (\Exception $exception) {
                throw new \Exception($exception);
            }
        }else {
            return $this->connection;
        }
    }

    public function getResultsArray($results){
        $res = [];
        if ($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $res[] = $row;
            }
        }
        return $res;
    }

}