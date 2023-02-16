<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Checklist extends MY_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('checklist_model');
  }

  public function adicionar() {
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
      $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
      redirect(base_url());
    }

    $this->load->library('form_validation');
    $this->data['custom_error'] = '';

    if ($this->form_validation->run('checklist') == false) {
      $this->data['custom_error'] = (validation_errors() ? true : false);
    } else {

      $data = [
        'nome' => $this->input->post('nome')
      ];

      if (is_numeric($id = $this->checklist_model->add('checklists', $data, true))) {
        $this->session->set_flashdata('success', 'Checklist adicionado com sucesso!');
        log_info(sprintf('Adicionou checklist ID: %d', $id));
        redirect(site_url('mapos/configurar?menu=os'));
      } else {
        $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
      }
    }

    $this->data['view'] = 'checklist/adicionarChecklist';
    return $this->layout();
  }

  public function excluir() {
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
      $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
      redirect(base_url());
    }

    $data = ['excluido' => 'S'];
    $idChecklist = $this->input->post('id');
    $sStatus = 'erro';
    if ($this->checklist_model->edit('checklists', $data, 'idChecklist', $idChecklist) == true) {
      $idChecklist = $this->input->post('idChecklist');
      $this->session->set_flashdata('success', 'Checklist excluído com sucesso!');
      log_info(sprintf('Excluiu checklist ID: %d', $idChecklist));
      $sStatus = 'ok';
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode(['status' => $sStatus]));
  }
}
