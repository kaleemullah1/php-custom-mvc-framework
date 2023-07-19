<?php

namespace App\Model;

class UserModel extends Model
{
    private $table_name = 'users';
    public $username;
    public $password;
    public $name;
    public $is_admin;
    public $is_deleted;
    public $updated_at;

    public function getUser(array $params)
    {
        $conn = $this->getConnection();

        $where_clause = '';
        foreach ($params as $key => $val) {
            $where_clause .= !empty($where_clause) ? " and $key='$val'" : "$key='$val' ";
        }

        $sql = "SELECT * FROM $this->table_name where is_deleted=0 and $where_clause ";
        $query = $conn->query($sql);

        $this->closeConnection();

        $results = [];
        if($query) {
            $results = $this->getResultsArray($query);
        }

        return $results;
    }

    public function updatePassword($id=null){
        $conn = $this->getConnection();
        if(!empty($this->password)) {
            if(!empty($id)){
                $query = $this->update(['id'=>$id],['password'=>$this->password]);
            }
            if ($query) {
                return true;
            }
        }else{
            return false;
        }
    }

    public function update(array $where,array $data){
        $conn = $this->getConnection();
        if(!empty($where) && !empty($data)) {
            $sql = "Update $this->table_name";
            $data_sql = $this->getWhereClause($data);
            $sql = !empty($data_sql)?$sql." SET updated_at=now() , ".str_replace('and',',',$data_sql):$sql;
            $where = $this->getWhereClause($where);
            $sql = !empty($where)?$sql." where ".$where:$sql;

            $query = $conn->query($sql);
            return $query;
        }
        return false;
    }

    public function getWhereClause(array $params){
        $where_clause = '';
        foreach ($params as $key => $val) {
            if(is_array($val) && !empty($val['val'])){
                $where_clause .= !empty($where_clause) ? " and $key='$val'" : "$key='$val' ";
            }else {
                $where_clause .= !empty($where_clause) ? " and $key='$val'" : "$key='$val' ";
            }
        }

        return $where_clause;
    }

}