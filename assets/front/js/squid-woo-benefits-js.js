document.addEventListener("DOMContentLoaded", function() {

    var barra_frete = document.getElementById('headerSquidWooBenefits');
    if(document.body.contains(barra_frete)){
    try {

        let xhr         = new XMLHttpRequest();
        let data        = new FormData();
    
        data.append( 'action', 'get_squid_woo_benefits' );
    
        xhr.open( 'POST', ajax_object.ajaxurl, true );    
    
     
    
        xhr.onload = function() {
    
            if( xhr.status === 200 ){
    
                var last_char = xhr.response.substr(-1);
                var new_response;
    
                if(last_char == '0'){
    
                    var new_response = xhr.response.slice(0, xhr.response.length-1);
                    var new_response = JSON.parse(new_response);
    
                }else{
    
                    new_response = xhr.response;
    
                }
    
                document.getElementsByClassName('loading-bar')[0].style.width = new_response.dimensions+'%';
                
                document.getElementsByClassName('info-benefit')[0].innerHTML = new_response.return_msg;
    
            }else{
    
                alert('Ocorreu um erro. Tente novamente mais tarde.');
    
            } 
    
    
        }
        
        xhr.send( data );
    
    
    
    
    
    
    
    
    // save the real open
    
    var oldOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function() {
    
        stopAjax = false;
    
        // when an XHR object is opened, add a listener for its readystatechange events
    
        this.addEventListener( "readystatechange", function onStateChange(event) {
    
                                    // fires on every readystatechange ever
    
                                    // use `this` to determine which XHR object fired the change event
    
                                    // console.log(event.target.responseURL);
    
            if(event.target.responseURL.includes('wc-ajax')){
    
                if(stopAjax == false) {
    
                    let xhr         = new XMLHttpRequest();
                    let data        = new FormData();
    
                    data.append( 'action', 'get_squid_woo_benefits' );
    
                    xhr.open( 'POST', ajax_object.ajaxurl, true );    
    
                        // xhr.responseType = 'json';
    
                        xhr.onloadstart = function(){
    
                
                        }
    
    
                    xhr.onload = function() {
    
                        if( xhr.status === 200 ){
    
                            var last_char = xhr.response.substr(-1);
                            var new_response;
    
                            if(last_char == '0'){
    
                                var new_response = xhr.response.slice(0, xhr.response.length-1);
                                var new_response = JSON.parse(new_response);
    
                            }else{
    
                                new_response = xhr.response;
    
                            }
    
                            document.getElementsByClassName('loading-bar')[0].style.width = new_response.dimensions+'%';
                            document.getElementsByClassName('info-benefit')[0].innerHTML = new_response.return_msg;
    
                        }else{
    
                            alert('Ocorreu um erro. Tente novamente mais tarde.');
    
                        } 
    
            
    
                    };
    
            
    
                    xhr.onloadend = function() {
    
            
    
                    }
    
            
    
                    xhr.send( data );
    
                    stopAjax = true;
    
                }
    
            }
    
        }
    
        )
        // run the real `open`
    
        oldOpen.apply(this, arguments);
    
    }
    
        
    } catch (error) {
        console.log(error);
    }
    }

   
});