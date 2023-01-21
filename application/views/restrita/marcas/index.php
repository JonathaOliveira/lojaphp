<?php $this->load->view('restrita/layout/navbar'); ?>

<?php $this->load->view('restrita/layout/sidebar'); ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <!-- add content here -->

            <!-- debug de retono de marcas do banco de dados-->
            <!--  
            <php 
              
              echo '<pre>';
              print_r($marcas);
              echo '</pre>';
              >
            -->

            <!-- Inicio Alertas (Tratativas de sucesso) -->

            <?php  if($message = $this->session->flashdata('sucesso')) : ?>

<div class="alert alert-success alert-dismissible show fade">

        <div class="alert-body">
          <button class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
          <div class="alert-title">Sucesso !</div>
          <div class="alert-icon"> <i class="far fa-check-circle"></i>
          <?php echo $message; ?>
          </div>
        </div>
      </div>

<?php endif; ?>

<!-- Fim alertas -->
            
            <!-- Inicio Alertas (Tratativas de erros) -->

            <?php  if($message = $this->session->flashdata('erro')) : ?>

              <div class="alert alert-danger alert-dismissible show fade">
              
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        <div class="alert-title">Atenção !</div>
                        <div class="alert-icon"> <i class="far fa-lightbulb"></i>
                        <?php echo $message; ?>
                        </div>
                      </div>
                    </div>

            <?php endif; ?>

            <!-- Fim alertas -->

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header d-block">
                    <h4><?php echo $titulo; ?></h4>
                    <a class="btn btn-primary float-right" href=" <?php  echo base_url('restrita/marcas/core');  ?>">Cadastrar</a>
                  </div>
                  
                  <div class="card-body">
                  
                    <div class="table-responsive">
                      <table class="table table-striped data-table" >
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Nome da marca</th>
                            <th>Meta link da marca &nbsp;<i data-feather="link-2" class="text-info"></i></th>
                            <th>Data cadastro</th>
                            <th>Ativa</th>
                            <th class="nosort">Ação</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php  foreach($marcas as $marca) : ?>

                          <tr>

                          

                            <td> <?php echo $marca->marca_id; ?> </td>
                            <td> <?php echo $marca->marca_nome; ?> </td>
                            <td> <?php echo $marca->marca_meta_link; ?> </td>
                            <td> <?php echo formata_data_banco_com_hora($marca->marca_data_criacao); ?> </td>
                            <td> <?php echo ($marca->marca_ativa == 1 ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>'); ?> </td>


                          <td>
                          <a href="<?php echo base_url('restrita/marcas/core/' . $marca->marca_id); ?> " class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Editar</a>
                          <a href="<?php echo base_url('restrita/marcas/delete/' . $marca->marca_id); ?> " class="btn btn-icon icon-left btn-danger delete" data-confirm="Tem certeza da exclusão?"><i class="fas fa-times"> Deletar</i></a> 
                          </td>
                            

                          </tr>

                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      