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

                    if(isset($marca)) {
                      $marca_id = $marca->marca_id;
                    } else {
                      $marca_id = '';
                    }

                  ?>
                  <?php echo form_open('restrita/marcas/core/'.$marca_id, $atributos); ?>

                  <form name="form_core">
                  <div class="card-body">

                   <div class="form-row">

                      <div class="form-group col-md-4">
                        <label>Nome da marca</label>
                        <input type="text" class="form-control" name="marca_nome" value="<?php echo (isset($marca) ? $marca->marca_nome : set_value('marca_nome')); ?>">
                        <?php echo form_error('marca_nome','<div class="text-danger">','</div>'); ?>
                      </div>

                      <div class="form-group col-md-4">
                            <label for="inputState">Ativa</label>
                            <select id="inputState" class="form-control" name="marca_ativa">

                              <?php if(isset($marca)) : ?>

                                <option value="1" <?php echo($marca->marca_ativa == 1 ? 'selected' : ''); ?> >Sim</option>
                                <option value="0" <?php echo($marca->marca_ativa == 0 ? 'selected' : ''); ?> >Nao</option>

                              <?php else : ?>

                                <option value="1">Sim</option>
                                <option value="0">Nao</option>

                              <?php endif; ?>
                            </select>
                          </div>

                          <?php if(isset($marca)) : ?>

                          <div class="form-group col-md-4">
                            <label>Descrição meta link</label>
                            <input type="text" class="form-control border-0" name="marca_meta_link" value="<?php echo $marca->marca_meta_link; ?>" readonly="">
                          </div>

                          <?php endif; ?>

                    </div>

                    <div class="form-row">
                      <!-- id marca -->
                             <?php if(isset($marca)) : ?>
                              <input type="hidden" name="marca_id" value="<?php echo $marca->marca_id; ?>">         
                            <?php endif; ?>

                    </div>

                     
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2">Salvar</button>
                    <a class="btn btn-dark" href="<?php echo base_url('restrita/marcas') ?>">Voltar</a>
                  </div>
                  <?php  echo form_close();  ?>
                  </div>
                
              </div>
            </div>

          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      