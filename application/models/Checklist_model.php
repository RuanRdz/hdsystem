<?php
  class Checklist_model extends CI_Model {
    public function __construct() {
      parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false) {
      $this->db->select($fields);
      $this->db->from($table);
      $this->db->limit($perpage, $start);
      $this->db->order_by('idChecklist', 'desc');

      if ($where) {
        $this->db->where($where);
      }

      $query = $this->db->get();

      $result = !$one ? $query->result() : $query->row();

      return $result;
    }

    public function getById($iId) {
      $this->db->select('checklists.*');
      $this->db->from('checklists');
      $this->db->where('checklists.idChecklist', $iId);
      $this->db->limit(1);

      return $this->db->get()->row();
    }

    public function add($table, $data, $returnId = false) {
      $this->db->insert($table, $data);
      if ($this->db->affected_rows() == '1') {
        if ($returnId == true) {
          return $this->db->insert_id($table);
        }
        return true;
      }

      return false;
    }

    public function edit($table, $data, $fieldID, $ID) {
      $this->db->where($fieldID, $ID);
      $this->db->update($table, $data);

      if ($this->db->affected_rows() >= 0) {
        return true;
      }

      return false;
    }

    public function delete($table, $fieldID, $ID) {
      $this->db->where($fieldID, $ID);
      $this->db->delete($table);
      if ($this->db->affected_rows() == '1') {
        return true;
      }

      return false;
    }

    public function count($table) {
      return $this->db->count_all($table);
    }
  }