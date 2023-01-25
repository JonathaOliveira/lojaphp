<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Master extends CI_Controller {

    // sessao logada
    public function __construct() {

        parent:: __construct();

        // sessao logada
            if (!$this->ion_auth->logged_in()) {
                redirect('restrita/login');
            }
    }

    // view mostra dados do banco de dados, na pagina principal
    public function index() {
            // array associativo
            $data = array(
   
               'titulo' => 'Categorias pai cadastradas',
   
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
   
               'master' => $this->core_model->get_all('categorias_pai'),
           );
   
           $this->load->view('restrita/layout/header', $data);
           $this->load->view('restrita/master/index');
           $this->load->view('restrita/layout/footer');
    }

    // core (Cadastrar e editar)
    public function core($categoria_pai_id = NULL) {

        $categoria_pai_id = (int) $categoria_pai_id;

        if(! $categoria_pai_id) {
            //Cadastrar

                $this->form_validation->set_rules('categoria_pai_nome', 'Nome da categoria PAI', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria'); // campo, mensaguem, validações

                if($this->form_validation->run()) {
                   
                    $data = elements(
    
                        array(
                            'categoria_pai_nome',
                            'categoria_pai_ativa',
                            
                        ), $this->input->post()
    
                    );
    
                    // Definindo meta link
                    $data['categoria_pai_meta_link'] = url_amigavel($data['categoria_pai_nome']);
    
                    $data = html_escape($data);
    
                    $this->core_model->insert('categorias_pai', $data);
                    redirect('restrita/master');
    
                }
    
                    //Erro de validação
            $data = array(
    
                'titulo' => 'Cadastrar categoria pai',
                
            );
           
            $this->load->view('restrita/layout/header', $data);
            $this->load->view('restrita/master/core');
            $this->load->view('restrita/layout/footer');
        } else {
            if(!$master = $this->core_model->get_by_id('categorias_pai', array('categoria_pai_id' => $categoria_pai_id))) {
               
                $this->session->set_flashdata('erro', 'Categoria pai não foi encontrada');
                redirect('restrita/master');
            } else {

                // Editando

            $this->form_validation->set_rules('categoria_pai_nome', 'Nome da categoria PAI', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria'); // campo, mensaguem, validações

            if($this->form_validation->run()) {

                                
                    if($this->input->post('categoria_pai_ativa') == 0) {

                        // Proibir desativação

                        if($this->core_model->get_by_id('categorias', array('categoria_pai_id' => $categoria_pai_id))){
                            
                            $this->session->set_flashdata('erro', 'Categoria pai não pode ser desativada pois está vinculada a uma categoria filha');
                            redirect('restrita/master');
                            

                        }

                    }
                                
               
                $data = elements(

                    array(
                        'categoria_pai_nome',
                        'categoria_pai_ativa',
                        
                    ), $this->input->post()

                );

                // Definindo meta link
                $data['categoria_pai_meta_link'] = url_amigavel($data['categoria_pai_nome']);

                $data = html_escape($data);

                $this->core_model->update('categorias_pai', $data, array('categoria_pai_id' => $categoria_pai_id));
                redirect('restrita/master');

            }

                //Erro de validação
        $data = array(

            'titulo' => 'Editar categoria pai',
            'master' =>$master,
        );
        //debug
        /*
        echo '<pre>';
        print_r($data['categoria_pai']);
        exit();
        */
        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/master/core');
        $this->load->view('restrita/layout/footer');
                

            }
        }

        
    }

    //callback (Validar existencias)
    public function valida_nome_categoria($categoria_pai_nome) {

        $categoria_pai_id = (int) $this->input->post('categoria_pai_id');

        if (!$categoria_pai_id) { 
            // Cadastrando...
            if ($this->core_model->get_by_id('categorias_pai', array('categoria_pai_nome' => $categoria_pai_nome))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria pai já existe');                
                return false;
            } else {
                return TRUE;
            }
        } else {
            // Editando
            if($this->core_model->get_by_id('categorias_pai', array('categoria_pai_nome' => $categoria_pai_nome, 'categoria_pai_id !=' => $categoria_pai_id))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria pai já existe');
                return false;
            } else {
                return TRUE;
            }
        }
    }
    
    // deletar dados
    public function delete($categoria_pai_id = NULL) {

        $categoria_pai_id = (int) $categoria_pai_id; 

        // Valida se existe categoria                                               
        if (!$categoria_pai_id || !$this->core_model->get_by_id('categorias_pai', array('categoria_pai_id' => $categoria_pai_id))) // categorias_pai [tabela] / array[condicoes]
        {
            $this->session->set_flashdata('erro', 'Categoria pai não foi encontrada');
            redirect('restrita/master');
        }

        // Valida se está ativa
        if ($this->core_model->get_by_id('categorias_pai', array('categoria_pai_id' => $categoria_pai_id, 'categoria_pai_ativa' => 1))) 
        {
            $this->session->set_flashdata('erro', 'Não é permitido excluir uma categoria pai ativa');
            redirect('restrita/master');
        }

        // Deleta categoria
        $this->core_model->delete('categorias_pai', array('categoria_pai_id' => $categoria_pai_id));
        redirect('restrita/master');
    }
}