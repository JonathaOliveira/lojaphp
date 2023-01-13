<?php $this->load->view('restrita/layout/navbar'); ?>

<?php $this->load->view('restrita/layout/sidebar'); ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <!-- add content here -->

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
<!--
<php

            echo '<pre>';  

              print_r($this->session->userdata('item'));

            echo '</pre>';

>
-->
          </div>
        </section>
        <?php $this->load->view('restrita/layout/sidebarsettings'); ?>      
      </div>
      