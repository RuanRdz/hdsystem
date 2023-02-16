<div class="row-fluid" style="margin-top:0">
  <div class="span12">
    <div class="widget-box">
      <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
          <i class="fas fa-wrench"></i>
        </span>
        <h5>Cadastro de Checklist</h5>
      </div>
      <div class="widget-content nopadding tab-content">
        <?php echo $custom_error; ?>
        <form action="<?php echo current_url(); ?>" id="formChecklist" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="nome" class="control-label">Nome<span class="required">*</span></label>
            <div class="controls">
              <input id="nome" type="text" name="nome" value="<?php echo set_value('nome'); ?>" />
            </div>
          </div>
          <div class="form-actions">
            <div class="span12">
              <div class="span6 offset3" style="display:flex;justify-content: center">
                <button type="submit" class="button btn btn-mini btn-success" style="max-width: 160px">
                  <span class="button__icon">
                    <i class='bx bx-plus-circle'></i>
                  </span>
                  <span class="button__text2">Adicionar</span>
                </button>
                <a href="<?php echo base_url() ?>mapos/configurar?menu=os" id="btnAdicionar" class="button btn btn-mini btn-warning" style="max-width: 160px">
                  <span class="button__icon">
                    <i class="bx bx-undo"></i>
                  </span>
                  <span class="button__text2">Voltar</span>
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('[name=nome]').focus();
    $("#formChecklist").validate({
      rules: {
        nome: {
          required: true
        }
      }
      , messages: {
        nome: {
          required: 'Campo Requerido.'
        }
      }
      , errorClass: "help-inline"
      , errorElement: "span"
      , highlight: function(element, errorClass, validClass) {
          $(element).parents('.control-group').addClass('error');
        }
      , unhighlight: function(element, errorClass, validClass) {
          $(element).parents('.control-group').removeClass('error');
          $(element).parents('.control-group').addClass('success');
        }
      });
    });
</script>
