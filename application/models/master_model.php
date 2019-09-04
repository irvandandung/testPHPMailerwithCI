<?php
class Master_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function getwhere($table, $where, $or_where)
    {
        $this->db->where($where);
        $this->db->or_where($or_where);
        return $this->db->get($table);
    }

    public function insert_data($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function select_maxe($table, $field){
        $this->db->select_max($field);
        return $this->db->get($table);
    }
}
