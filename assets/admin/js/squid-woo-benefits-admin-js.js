document.addEventListener("DOMContentLoaded", function() {
    
    const send = XMLHttpRequest.prototype.send
    XMLHttpRequest.prototype.send = function() { 
        this.addEventListener('load', function() {
            // console.log('global handler', this.responseText)
            // add your global handler here
            console.log('rodou após ajax');
        })
        return send.apply(this, arguments)
    }



    function updateBenefit(){

        var shipp_status = document.querySelector('.portlet-header input').checked;
        var values = document.querySelectorAll('.portlet-content input');
        // var min_value = values[0].value;
        var max_value = values[0].value;
        var shipp_value = values[3].value;
        var shipp_type = document.querySelector('.dados-type input').checked;//se for falso, é porcentagem;
        var shipp_text = values[4].value;

        let xhr         = new XMLHttpRequest();
        let data        = new FormData();

        data.append( 'action', 'save_squid_woo_benefits' );
        data.append( 'shipp_status',  shipp_status );
        // data.append( 'min_value',  min_value );
        data.append( 'max_value',  max_value );
        data.append( 'shipp_value',  shipp_value );
        data.append( 'shipp_type',  shipp_type );
        data.append( 'shipp_text',  shipp_text );

        xhr.open( 'POST', ajax_object.ajaxurl, true );

            xhr.responseType = 'text';
            xhr.onloadstart = function(){
                document.querySelector( '.save-benefit span.success' ).classList.add('escondido');
            document.querySelector( 'div#benefits' ).classList.add('loading');
            }

            xhr.onload = function() {
                if( xhr.status === 200 ){
                    
                    console.log(xhr);
                }else{
                    alert('Ocorreu um erro. Tente novamente mais tarde.');
                } 

            };

            xhr.onloadend = function() {
            document.querySelector( 'div#benefits' ).classList.remove('loading');
            document.querySelector( '.save-benefit span.success' ).classList.remove('escondido');
            }

            xhr.send( data );

    }

    document.querySelector('#save-benefit').onclick = function(){
        var shipp_status = document.querySelector('.portlet-header input').checked;
        var values = document.querySelectorAll('.portlet-content input');
        // var min_value = '0';
        var max_value = values[0].value;
        var shipp_value = values[3].value;
        var shipp_type = document.querySelector('.dados-type input').checked;//se for falso, é porcentagem;
        var shipp_text = values[4].value;
        // if(shipp_status == 'true'){
            if(max_value && shipp_value && shipp_text){
                var regex_test = new RegExp(/^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/);
                if(!regex_test.test(max_value) || !regex_test.test(shipp_value)){
                    alert('Informe os campos corretamente');
                }else{
                    updateBenefit();
                }
            
                
            }else{
                alert('Informe os campos corretamente');
            }
        // }else{
        //     updateBenefit();
        // }


    };


    document.addEventListener('click', function(event){
        if(!event.target.parentNode.classList.contains('exclude-position') && !event.target.classList.contains('exclude-actions')){
            var exclude_actions = document.querySelectorAll('.exclude-actions');
            [].forEach.call(exclude_actions, function(el) {
                el.classList.remove("active");
            });
            var exclude_position = document.querySelectorAll('.exclude-position');
            [].forEach.call(exclude_position, function(el) {
                el.classList.remove("active");
            });
        }
        // console.log(event.target.parentNode.classList.contains);
    });


    // document.querySelector('.exclude-position').onclick = function(){
    //     this.classList.add('active');
    //     var elem_brod = this.nextElementSibling;
    //     if(elem_brod.classList.contains('active')){
    //         elem_brod.classList.remove('active');
    //         this.classList.remove('active');
    //     }else{
    //         elem_brod.classList.add('active');
    //     }
    // };

    // document.querySelector('.cancel-exclude').onclick = function(){
    //     this.closest('.exclude-actions').classList.remove('active');
    //     this.closest('.exclude-actions').previousElementSibling.classList.remove('active');
    // };

    // document.querySelector('.confirm-exclude').onclick = function(){
    //     this.closest('.exclude-actions').classList.remove('active');
    //     this.closest('.exclude-actions').previousElementSibling.classList.remove('active');
    //     var content_inputs = this.parentNode.parentNode.nextElementSibling.querySelectorAll('input');
    //     console.log(content_inputs);
        
        
    //     document.querySelector('.portlet-header input').checked = false;
    //     content_inputs[0].value = '';//var min_value
    //     content_inputs[1].value = '';//var max_value 
    //     content_inputs[2].value = '';//var shipp_value
    //     content_inputs[3].checked = true;//var fixed_shipp
    //     content_inputs[4].checked = false;//var fixed_shipp
    //     content_inputs[5].value = '';//var shipp_text

    //     updateBenefit();

    // };

});