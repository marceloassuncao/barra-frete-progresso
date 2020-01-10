<?php $array_squid_option = get_option('squid_woo_report_option');?>
<div id="benefits">



  <div class="column benefits">

    <div class="portlet">

      <div class="portlet-header">

        <span class="title">Frete</span>
        <?php 
        if($array_squid_option['shipp_status'] == 'true' ){
          $shipp_status = 'checked';
        }else{
          $shipp_status = '';
        }
        ?>

        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
          <input type="checkbox" id="switch-1" class="mdl-switch__input" <?php echo $shipp_status?>>
          <span class="mdl-switch__label"></span>
        </label>

      </div>

      <div class="portlet-content">

        <div class="values-benefits">


        <!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input class="mdl-textfield__input" type="text" pattern="^[-+]?\d+(\.\d+)?$" id="sample4" value="<?php //echo $array_squid_option['min_value']?>">
          <label class="mdl-textfield__label" for="sample4">Min. Subtotal R$</label>
          <span class="mdl-textfield__error">Informe apenas números ou decimais com "."</span>
        </div> -->

          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" pattern="^[-+]?\d+(\.\d+)?$" id="sample4" value="<?php echo $array_squid_option['max_value']?>">
            <label class="mdl-textfield__label" for="sample4">Máx. Subtotal R$</label>
            <span class="mdl-textfield__error">Informe apenas números ou decimais com "."</span>
          </div>

        </div>

        <div class="dados-benefit">

          <div class="dados-1">

            

            <div class="dados-type">

              <?php if($array_squid_option['shipp_type'] == 'true' ){

                $shipp_type_fixed = 'checked';

                $shipp_type_percent = '';

                }else{

                $shipp_type_fixed = '';

                $shipp_type_percent = 'checked';

                }

              ?>

              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="1" <?php echo $shipp_type_fixed ?>>
                <span class="mdl-radio__label">Preço Fixo (R$)</span>
              </label>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="2" <?php echo $shipp_type_percent ?>>
                <span class="mdl-radio__label">Preço Percentual (%)</span>
              </label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="text" pattern="^[-+]?\d+(\.\d+)?$" id="sample4" value="<?php echo $array_squid_option['shipp_value']?>">
              <label class="mdl-textfield__label" for="sample4">Valor do Frete</label>
              <span class="mdl-textfield__error">Informe apenas números ou decimais com "."</span>
            </div>

          </div>

          <div class="dados-2">

          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="sample3" value="<?php echo $array_squid_option['shipp_text']?>">
            <label class="mdl-textfield__label" for="sample3">Descrição do Frete</label>
          </div>

          </div>

        </div>

      </div>

    </div>

  </div>





  <div class="save-benefit">

    <button id="save-benefit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Salvar</button>
    <span class="success escondido">Salvo com Sucesso!</span>

  </div>


</div>


