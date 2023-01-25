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

                    if(isset($categoria)) {
                      $categoria_id = $categoria->categoria_id;
                    } else {
                      $categoria_id = '';
                    }

                  ?>
                  <?php echo form_open('restrita/categorias/core/'.$categoria_id, $atributos); ?>

                  <form name="form_core">
                  <div class="card-body">

                   <div class="form-row">

                      <div class="form-group col-md-3">
                        <label>Nome da categoria</label>
                        <input type="text" class="form-control" name="categoria_nome" value="<?php echo (isset($categoria) ? $categoria->categoria_nome : set_value('categoria_nome')); ?>">
                        <?php echo form_error('categoria_nome','<div class="text-danger">','</div>'); ?>
                      </div>

                      <div class="form-group col-md-3">
                            <label for="inputState">Ativa</label>
                            <select id="inputState" class="form-control" name="categoria_ativa">

                              <?php if(isset($categorias)) : ?>

                                <option value="1" <?php echo($categorias->categoria_ativa == 1 ? 'selected' : ''); ?> >Sim</option>
                                <option value="0" <?php echo($categorias->categoria_ativa == 0 ? 'selected' : ''); ?> >Nao</option>

                              <?php else : ?>

                                <option value="1">Sim</option>
                                <option value="0">Nao</option>

                              <?php endif; ?>
                            </select>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="inputState">Categoria pai</label>
                            <select id="inputState" class="form-control" name="categoria_pai_id">

                            <?php foreach($masters as $pai): ?>

                              <?php if(isset($categoria)) : ?>

                                <option value="<?php echo $pai->categoria_pai_id; ?>" <?php echo($pai->categoria_pai_id == $categoria->categoria_pai_id ? 'selected' : '') ?> > <?php  echo $pai->categoria_pai_nome; ?> </option>
                                

                              <?php else : ?>

                                <option value="<?php echo $pai->categoria_pai_id; ?>"><?php  echo $pai->categoria_pai_nome; ?></option>
                                

                              <?php endif; ?>

                              <?php endforeach; ?>
                            </select>
                          </div>

                          <?php if(isset($categoria)) : ?>

                          <div class="form-group col-md-3">
                            <label>Descrição meta link da categoria</label>
                            <input type="text" class="form-control border-0" name="categoria_meta_link" value="<?php echo $categoria->categoria_meta_link; ?>" readonly="">
                          </div>

                          <?php endif; ?>

                    </div>

                    <div class="form-row">
                      <!-- id marca -->
                             <?php if(isset($categoria)) : ?>
                              <input type="hidden" name="categoria_id" value="<?php echo $categoria->categoria_id; ?>">         
                            <?php endif; ?>

                    </div>

                     
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2">Salvar</button>
                    <a class="btn btn-dark" href="<?php echo base_url('restrita/categorias') ?>">Voltar</a>
                  </div>
                  <?php  echo form_close();  ?>
                  </div>
                
              </div>
            </div>

          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      