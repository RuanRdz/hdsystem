<?php
  class Oschecklist_model extends CI_Model {
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

    public function add($data) {
      $this->db->insert('os_checklists', $data);
      if ($this->db->affected_rows() == '1') {
        return true;
      }
      return false;
    }

    public function delete($fieldID, $ID) {
      $this->db->where($fieldID, $ID);
      $this->db->delete('os_checklists');
      if ($this->db->affected_rows() == '1') {
        return true;
      }
      return false;
    }

    public function getChecklists($idOs) {
      $this->db->select('checklists.*');
      $this->db->from('os_checklists');
      $this->db->join('checklists', 'checklists.idChecklist = os_checklists.idChecklist');
      $this->db->where('os_checklists.idOs', $idOs);
      $this->db->order_by('nome');

      return $this->db->get()->result();
    }

    public function deleteFromOs($idOs) {
      $this->db->where('os_checklists.idOs', $idOs);
      $this->db->delete('os_checklists');
      if (!empty($this->db->affected_rows())) {
        return true;
      }
      return false;
    }
  }