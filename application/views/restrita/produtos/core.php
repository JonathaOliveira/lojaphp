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
                  <!-- Atributo form core -->
                  <?php

                    $atributos = array('name' => 'form_core');

                      if(isset($produto)) {
                        $produto_id = $produto->produto_id;
                        } else {
                        $produto_id = '';
                        }

                  ?>
                  
                  <?php echo form_open('restrita/produtos/core/'.$produto_id, $atributos); ?>

                  <div class="card-body">
                    <!--(Exibe linha 1)Seta produto selecionado, e exibe metalink -->
                    <?php if(isset($produto)): ?>

                      <div class="form-row">

                        <div class="col-md-12">

                          <label>Meta link do produto</label>
                          <p class="text-info"><?php echo $produto->produto_meta_link; ?></p>

                        </div>

                      </div>

                    <?php endif; ?>
                    
                    <!--(Exibe linha 2)Dados do produto, cod, nome, etc... -->
                    <div class="form-row">
                      <!-- (Código produto) -->
                      <div class="form-group col-md-3">
                        <label>Código produto</label>
                        <input type="text" class="form-control" name="produto_codigo" value="<?php echo (isset($produto) ? $produto->produto_codigo : set_value('produto_codigo')); ?>">
                        <?php echo form_error('produto_codigo','<div class="text-danger">','</div>'); ?>
                      </div>
                      <!-- (Nome do produto) -->
                      <div class="form-group col-md-3">
                        <label>Nome produto</label>
                        <input type="text" class="form-control" name="produto_nome" value="<?php echo (isset($produto) ? $produto->produto_nome : set_value('produto_nome')); ?>">
                        <?php echo form_error('produto_nome','<div class="text-danger">','</div>'); ?>
                      </div>
                      
                      <!-- (Categoria) -->
                      <div class="form-group col-md-3">
                            <label for="inputState">Categoria</label>
                            <select id="inputState" class="form-control" name="produto_categoria_id">

                                <option value="">Escolha...</option>

                              <?php foreach($categorias as $categoria): ?>

                                <?php if(isset($produto)) : ?>

                                  <option value="<?php echo $categoria->categoria_id; ?>"
                                    <?php echo($categoria->categoria_id == $produto->produto_categoria_id ? 'selected' : '') ?> >
                                    <?php  echo $categoria->categoria_nome; ?>
                                  </option>

                                <?php else : ?>

                                  <option value="<?php echo $categoria->categoria_id; ?>">
                                    <?php  echo $categoria->categoria_nome; ?>
                                  </option>
                                  

                                <?php endif; ?>

                              <?php endforeach; ?>
                            </select>
                      </div>

                      <!-- (Marcas) -->
                      <div class="form-group col-md-3">
                            <label for="inputState">Marcas</label>
                            <select id="inputState" class="form-control" name="produto_marca_id">

                                <option value="">Escolha...</option>

                              <?php foreach($marcas as $marca): ?>

                                <?php if(isset($produto)) : ?>

                                  <option value="<?php echo $marca->marca_id; ?>" <?php echo($marca->marca_id == $produto->produto_marca_id ? 'selected' : '') ?> >
                                    <?php  echo $marca->marca_nome; ?>
                                  </option>

                                <?php else : ?>

                                  <option value="<?php echo $marca->marca_id; ?>">
                                    <?php  echo $marca->marca_nome; ?>
                                  </option>
                                  

                                <?php endif; ?>

                              <?php endforeach; ?>
                            </select>
                      </div>
                      
                      

                    </div>

                    <div class="form-row">
                      <!-- id marca -->
                             <?php if(isset($produto)) : ?>
                              <input type="hidden" name="produto_id" value="<?php echo $produto->produto_id; ?>">         
                            <?php endif; ?>

                    </div>

                     
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2">Salvar</button>
                    <a class="btn btn-dark" href="<?php echo base_url('restrita/produtos') ?>">Voltar</a>
                  </div>
                  <?php  echo form_close();  ?>
                  </div>
                
              </div>
            </div>

          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      