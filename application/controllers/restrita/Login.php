<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Login extends CI_Controller{

    public function index() {

        $data = array(
            'titulo' => 'Área de login',
        );

        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/login/index');
        $this->load->view('restrita/layout/footer');

    }

    public function auth() {
        // DEBUG
        /*
        echo '<pre>';
        print_r($this->input->post()); 
        exit();
        */
        // END DEBUG

        $identity = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = ($this->input->post('remember' ? TRUE : FALSE));
        if ($this->ion_auth->login($identity, $password, $remember)) {
            $this->session->set_flashdata('sucesso', 'Sejam muito bem vindo(a)!');
            redirect('restrita');
        } else {
            $this->session->set_flashdata('erro', 'Por favor, verifique suas credenciais');
            redirect('restrita/login');
        }
    }

    public function logout() {
        $this->ion_auth->logout();
        redirect('restrita/login');
    }
}