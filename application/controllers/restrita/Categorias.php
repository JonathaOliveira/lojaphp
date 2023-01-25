<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Categorias extends CI_Controller {

    // valida sessão logado
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
   
               'titulo' => 'Categorias cadastradas',
   
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
   
               'categorias' => $this->core_model->get_all('categorias'),
           );
   
           $this->load->view('restrita/layout/header', $data);
           $this->load->view('restrita/categorias/index');
           $this->load->view('restrita/layout/footer');
    }

    // core (Cadastrar e editar)
    public function core($categoria_id = NULL) {

        $categoria_id = (int) $categoria_id;

        if(! $categoria_id) {
            //Cadastrar

                $this->form_validation->set_rules('categoria_nome', 'Nome da categoria', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria'); // campo, mensaguem, validações

                if($this->form_validation->run()) {
                   
                    $data = elements(
    
                        array(
                            'categoria_nome',
                            'categoria_ativa',
                            'categoria_pai_id',
                        ), $this->input->post()
    
                    );
    
                    // Definindo meta link
                    $data['categoria_meta_link'] = url_amigavel($data['categoria_nome']);
    
                    $data = html_escape($data);
    
                    $this->core_model->insert('categorias', $data);
                    redirect('restrita/categorias');
    
                } else {

                //Erro de validação
                    $data = array(
            
                        'titulo' => 'Cadastrando categoria',
                        'masters' => $this->core_model->get_all('categorias_pai', array('categoria_pai_ativa' => 1)),
                        
                    );
                
                    $this->load->view('restrita/layout/header', $data);
                    $this->load->view('restrita/categorias/core');
                    $this->load->view('restrita/layout/footer');

                }
                    
        } else {
            if(!$categoria = $this->core_model->get_by_id('categorias', array('categoria_id' => $categoria_id))) {
               
                $this->session->set_flashdata('erro', 'Categoria não foi encontrada');
                redirect('restrita/categorias');
            } else {

                // Editando

            $this->form_validation->set_rules('categoria_nome', 'Nome da categoria', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria'); // campo, mensaguem, validações

            if($this->form_validation->run()) {
                                
               
                $data = elements(

                    array(
                        'categoria_nome',
                        'categoria_ativa',
                        'categoria_pai_id',
                    ), $this->input->post()

                );

                // Definindo meta link
                $data['categoria_meta_link'] = url_amigavel($data['categoria_nome']);

                $data = html_escape($data);

                $this->core_model->update('categorias', $data, array('categoria_id' => $categoria_id));
                redirect('restrita/categorias');

            }

                //Erro de validação
        $data = array(

            'titulo' => 'Editar categoria',
            'categoria' => $categoria,
            'masters' => $this->core_model->get_all('categorias_pai', array('categoria_pai_ativa' => 1)),
        );
       
        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/categorias/core');
        $this->load->view('restrita/layout/footer');
                

            }
        }

        
    }
    
    //callback (Validar existencias)
    public function valida_nome_categoria($categoria_nome) {

        $categoria_id = (int) $this->input->post('categoria_id');

        if (!$categoria_id) { 
            // Cadastrando...
            if ($this->core_model->get_by_id('categorias', array('categoria_nome' => $categoria_nome))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');                
                return false;
            } else {
                return TRUE;
            }
        } else {
            // Editando
            if($this->core_model->get_by_id('categorias', array('categoria_nome' => $categoria_nome, 'categoria_id !=' => $categoria_id))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');
                return false;
            } else {
                return TRUE;
            }
        }
    }

    // deletar dados
    public function delete($categoria_id = NULL) {

        $categoria_id = (int) $categoria_id; 

        // Valida se existe categoria                                               
        if (!$categoria_id || !$this->core_model->get_by_id('categorias', array('categoria_id' => $categoria_id))) // categorias_pai [tabela] / array[condicoes]
        {
            $this->session->set_flashdata('erro', 'Categoria pai não foi encontrada');
            redirect('restrita/categorias');
        }

        // Valida se está ativa
        if ($this->core_model->get_by_id('categorias', array('categoria_id' => $categoria_id, 'categoria_ativa' => 1))) 
        {
            $this->session->set_flashdata('erro', 'Não é permitido excluir uma categoria ativa');
            redirect('restrita/categorias');
        }

        // Deleta categoria
        $this->core_model->delete('categorias', array('categoria_id' => $categoria_id));
        redirect('restrita/categorias');
    }
}