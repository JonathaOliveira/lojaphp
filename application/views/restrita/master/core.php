<?php $this->load->view('restrita/layout/navbar'); ?>

<?php $this->load->view('restrita/layout/sidebar'); ?>

      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><?php echo $titulo; ?></h4>
                  </div>
                  <?php

                  $atributos = array(
                    'name' => 'form_core'
                  
                  );

                    if(isset($master)) {
                      $categoria_pai_id = $master->categoria_pai_id;
                    } else {
                      $categoria_pai_id = '';
                    }

                  ?>
                  <?php echo form_open('restrita/master/core/'.$categoria_pai_id, $atributos); ?>

                  <form name="form_core">
                  <div class="card-body">

                   <div class="form-row">

                      <div class="form-group col-md-4">
                        <label>Nome da categoria pai</label>
                        <input type="text" class="form-control" name="categoria_pai_nome" value="<?php echo (isset($master) ? $master->categoria_pai_nome : set_value('categoria_pai_nome')); ?>">
                        <?php echo form_error('categoria_pai_nome','<div class="text-danger">','</div>'); ?>
                      </div>

                      <div class="form-group col-md-4">
                            <label for="inputState">Ativa</label>
                            <select id="inputState" class="form-control" name="categoria_pai_ativa">

                              <?php if(isset($master)) : ?>

                                <option value="1" <?php echo($master->categoria_pai_ativa == 1 ? 'selected' : ''); ?> >Sim</option>
                                <option value="0" <?php echo($master->categoria_pai_ativa == 0 ? 'selected' : ''); ?> >Nao</option>

                              <?php else : ?>

                                <option value="1">Sim</option>
                                <option value="0">Nao</option>

                              <?php endif; ?>
                            </select>
                          </div>

                          <?php if(isset($master)) : ?>

                          <div class="form-group col-md-4">
                            <label>Descrição meta link da categoria PAI</label>
                            <input type="text" class="form-control border-0" name="categoria_pai_meta_link" value="<?php echo $master->categoria_pai_meta_link; ?>" readonly="">
                          </div>

                          <?php endif; ?>

                    </div>

                    <div class="form-row">
                      <!-- id marca -->
                             <?php if(isset($master)) : ?>
                              <input type="hidden" name="categoria_pai_id" value="<?php echo $master->categoria_pai_id; ?>">         
                            <?php endif; ?>

                    </div>

                     
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2">Salvar</button>
                    <a class="btn btn-dark" href="<?php echo base_url('restrita/master') ?>">Voltar</a>
                  </div>
                  <?php  echo form_close();  ?>
                  </div>
                
              </div>
            </div>

          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      