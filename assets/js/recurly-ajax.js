jQuery(document).ready(function($) {

    //* Popup (will be move in next update) *//

    $('.recurlywp-modal-toggle').on('click', function(e) {
      e.preventDefault();
      $('.recurlywp-modal').toggleClass('is-visible');
      $("#recurlywp-quantity").val($(this).attr("data-quantity"));
      $("#recurlywp-uuid").val($(this).attr("data-uuid"));
    });

    $("#pay_n_recurly").click(function(){   
        $(".response-recurly").remove();
        $(".recurly-ui-block").show();      
        // This does the ajax request
        $.ajax({
            url: recurly_ajax_obj.ajaxurl,
            data: {
                'action': 'recurly_submit_ajax_process',
                'recurly' : $("#recurly_form").serialize(),
                'nonce' : recurly_ajax_obj.nonce
            },
            method : 'POST',
            dataType: 'json',
            success:function(data) {
                // This outputs the result of the ajax request
                if(data.type == "success"){
                    $("#success_order_message").trigger("click");
                    //$("#response_recurly").html('<div class="response-recurly response-success">'+data.message+'</div>');
                }
                if(data.type == "error"){
                    $("#response_recurly").html('<div class="response-recurly response-error">'+data.message+'</div>');
                }               
                $(".recurly-ui-block").hide();     
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });  
           
    });  


    $("a.recurlywp-change-card").click(function(){
        $(".card_update_process").slideToggle();
    });

    $("#update_recurly").click(function(){   
        $(".response-recurly").remove();
        $(".recurly-ui-block").show();      
        // This does the ajax request
        $.ajax({
            url: recurly_ajax_obj.ajaxurl,
            data: {
                'action': 'recurly_card_update_ajax_process',
                'recurly' : $("#update_recurly_payment").serialize(),
                'nonce' : recurly_ajax_obj.nonce
            },
            method : 'POST',
            dataType: 'json',
            success:function(data) {
                // This outputs the result of the ajax request
                if(data.type == "success"){
                    $("#success_order_message").trigger("click");
                    //$("#response_recurly").html('<div class="response-recurly response-success">'+data.message+'</div>');
                }
                if(data.type == "error"){
                    $("#response_recurly").html('<div class="response-recurly response-error">'+data.message+'</div>');
                }               
                $(".recurly-ui-block").hide();     
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });  
           
    });  

    $("#update_recurly_sub").click(function(){
        $(".recurly-ui-block").show();      
        // This does the ajax request
        $.ajax({
            url: recurly_ajax_obj.ajaxurl,
            data: {
                'action': 'recurly_update_ajax_subscription',
                'recurlyupdate' : $("#update_recurly_form").serialize(),
                'nonce' : recurly_ajax_obj.nonce
            },
            method : 'POST',
            dataType: 'json',
            success:function(data) {
                // This outputs the result of the ajax request
                if(data.type == "success"){
                    $("#response_recurly").html('<div class="response-recurly response-success">'+data.message+'</div>');
                    location.reload();
                }
                if(data.type == "error"){
                    $("#response_recurly").html('<div class="response-recurly response-error">'+data.message+'</div>');
                }               
                $(".recurly-ui-block").hide();     
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });  
    });

    $(".recurlywp-cancel").click(function(){   
        $(".response-recurly").remove();
        $(".recurly-ui-block").show();      
        // This does the ajax request
        $.ajax({
            url: recurly_ajax_obj.ajaxurl,
            data: {
                'action': 'recurly_cancel_ajax_subscription',
                'uuid' : $(this).attr("data-uuid"),
                'nonce' : recurly_ajax_obj.nonce
            },
            method : 'POST',
            dataType: 'json',
            success:function(data) {
                // This outputs the result of the ajax request
                if(data.type == "success"){
                    $("#response_recurly").html('<div class="response-recurly response-success">'+data.message+'</div>');
                    location.reload();
                }
                if(data.type == "error"){
                    $("#response_recurly").html('<div class="response-recurly response-error">'+data.message+'</div>');
                }               
                $(".recurly-ui-block").hide();     
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });  
           
    });  

});