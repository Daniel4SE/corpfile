<?php
/**
 * Base Model
 */
class BaseModel {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($orderBy = 'id DESC', $limit = null, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        return $this->db->fetchAll($sql);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    public function getWhere($where, $params = [], $orderBy = 'id DESC') {
        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy}";
        return $this->db->fetchAll($sql, $params);
    }
    
    public function getOneWhere($where, $params = []) {
        $sql = "SELECT * FROM {$this->table} WHERE {$where} LIMIT 1";
        return $this->db->fetchOne($sql, $params);
    }
    
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        return $this->db->update($this->table, $data, "{$this->primaryKey} = ?", [$id]);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, "{$this->primaryKey} = ?", [$id]);
    }
    
    public function count($where = '1=1', $params = []) {
        return $this->db->count($this->table, $where, $params);
    }
    
    public function search($keyword, $columns, $orderBy = 'id DESC') {
        $conditions = array_map(fn($col) => "{$col} LIKE ?", $columns);
        $where = implode(' OR ', $conditions);
        $params = array_fill(0, count($columns), "%{$keyword}%");
        return $this->getWhere($where, $params, $orderBy);
    }
}
