<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Usuarios extends CI_Controller{

    public function __construct() {
        parent:: __construct();

        //Sessão valida?
    }

    public function index() {

        // array associativo
        $data = array(

            'titulo' => 'Usuarios cadastrados',

            'styles' => array(
                'bundles/datatables/datatables.min.css',
                'bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',

            ),

            'scripts' => array(
                'bundles/datatables/datatables.min.js',
                'bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
                'bundles/jquery-ui/jquery-ui.min.js',
                'js/page/datatables.js'
            ),

            'usuarios' => $this->ion_auth->users()->result(),
        );

        /*
        // debug para coletar dados do banco
            
            echo '<pre>';
            print_r($data['usuarios']);
            exit();

        */

        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/usuarios/index');
        $this->load->view('restrita/layout/footer');
        
    }

    public function core($usuario_id = NULL) {

        $usuario_id = (int) $usuario_id;

        if(!$usuario_id){
            // Cadastrar usuario

            $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[3]|max_length[50]|callback_valida_usuario');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|min_length[10]|max_length[100]|valid_email|callback_valida_email');
            $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[6]|max_length[20]');
            $this->form_validation->set_rules('confirma', 'Confirma', 'trim|required|matches[password]');

            if($this->form_validation->run()) {

                    // Debug validando campos de cadastros
                    /*
                    echo '<pre>';
                    print_r($this->input->post());
                    exit();
                    */

                    $username = $this->input->post('username');
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
                    $additional_data = array(
                                'first_name' => $this->input->post('first_name'),
                                'last_name' => $this->input->post('last_name'),
                                'active' => $this->input->post('active'),
                                );
                    $group = array($this->input->post('perfil')); // Sets user to admin or customer
                
                    if ($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {
                        $this->session->set_flashdata('sucesso','Dados salvos com sucesso!');
                    } else {
                        $this->session->set_flashdata('erro', $this->ion_auth->errors());
                    }
                    redirect('restrita/usuarios');
            } else {
                // Erro de validação

                $data = array(
                    'titulo' => 'Cadastrar usuário',
                    'grupos' => $this->ion_auth->groups()->result(),
                );
                //Se usuario foi encontrado, faça...
                $this->load->view('restrita/layout/header', $data);
                $this->load->view('restrita/usuarios/core');
                $this->load->view('restrita/layout/footer');
            }


        } else {

            // Esse usuario existe?
            if(!$usuario =  $this->ion_auth->user($usuario_id)->row()) {
                
                $this->session->set_flashdata('erro', 'Usuário não foi encontrado');
                redirect('restrita/usuarios');

            } else {

                // Edita o usuário

                $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[45]');
                $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[45]');
                $this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[3]|max_length[50]|callback_valida_usuario');
                $this->form_validation->set_rules('email', 'E-mail', 'trim|required|min_length[10]|max_length[100]|valid_email|callback_valida_email');
                $this->form_validation->set_rules('password', 'Senha', 'trim|min_length[6]|max_length[20]');
                $this->form_validation->set_rules('confirma', 'Confirma', 'trim|matches[password]');
                
                


                if($this->form_validation->run()){
                    /* Debugando , validando as informações dos campos de preenchimento
                    echo '<pre>';
                    print_r($this->input->post());
                    exit();
                    */

                    $data = elements(
                        array(
                            'first_name',
                            'last_name',
                            'email',
                            'username',
                            'password',
                            'active',
                        ), $this->input->post()
                    );

                    $password = $this->input->post('password');

                    // Não atualiza a senha , caso não seja informado

                    if (!$password) {

                        unset($data['password']);
                    }

                    $data = html_escape($data);

                    
                    /* Debungando - Validando apenas o que vai para o banco de dados
                    echo '<pre>';
                    print_r($data);
                    exit();
                    */

                    if ($this->ion_auth->update($usuario_id, $data)){

                        $perfil =  (int) $this->input->post('perfil');

                        if ($perfil) {
                            $this->ion_auth->remove_from_group(NULL, $usuario_id);
                            $this->ion_auth->add_to_group($perfil, $usuario_id);
                        }

                        $this->session->set_flashdata('sucesso','Dados salvos com sucesso!');
                    } else {
                        $this->session->set_flashdata('erro', $this->ion_auth->errors());
                    }

                    
                    redirect('restrita/usuarios');

                } else {
                    // Erro de validacao

                    $data = array(
                        'titulo' => 'Editar usuário',
                        'usuario' => $usuario,
                        'perfil' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                        'grupos' => $this->ion_auth->groups()->result(),
                    );
                    //Se usuario foi encontrado, faça...
                    $this->load->view('restrita/layout/header', $data);
                    $this->load->view('restrita/usuarios/core');
                    $this->load->view('restrita/layout/footer');
                }

                
            }
            

        }

    }

    public function valida_email($email) {

        $usuario_id = $this->input->post('usuario_id');

        if (!$usuario_id) {
           
            //cadastrando...
           
            if ($this->core_model->get_by_id('users', array('email' => $email))){
                $this->form_validation->set_message('valida_email', 'Esse e-mail já existe!');
                return false;
            } else {
                return true;
            }
        } else {
            // Editando...
            if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {
                $this->form_validation->set_message('valida_email', 'Esse e-mail já existe!');
                return false;
            } else {
                return true;
            }
        }
        
    }

    public function valida_usuario($username) {

        $usuario_id = $this->input->post('usuario_id');

        if (!$usuario_id) {
           
            //cadastrando...
           
            if ($this->core_model->get_by_id('users', array('username' => $username))){
                $this->form_validation->set_message('valida_usuario', 'Esse usuario já existe!');
                return false;
            } else {
                return true;
            }
        } else {
            // Editando...
            if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {
                $this->form_validation->set_message('valida_usuario', 'Esse usuario já existe!');
                return false;
            } else {
                return true;
            }
        }
        
    }

    public function delete($usuario_id = NULL) {

        $usuario_id = (int) $usuario_id;

        if (!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {
            $this->session->set_flashdata('erro', 'O usuario não foi encontrado');
            redirect('restrita/usuarios');
        } else {
            // Exclusão do usuario

            if ($this->ion_auth->is_admin($usuario_id)) {
                $this->session->set_flashdata('erro', 'Não é permitido excluir um usuário administrador');
                redirect('restrita/usuarios');
            }

            if ($this->ion_auth->delete_user($usuario_id)) {

                $this->session->set_flashdata('sucesso', 'Usuário excluido com sucesso!');

            } else {

                $this->session->set_flashdata('erro',   $this->ion_auth->errors());
            }

            redirect('restrita/usuarios');
        }

    }
}