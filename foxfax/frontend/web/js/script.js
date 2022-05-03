 $( document ).ready(function() {

    $("#quickreminder").on("focus",".dp", function(e){ //user click on remove text
	    e.preventDefault();
	    $(this).datepicker({
	    format:"dd-mm-yyyy",  
	    autoclose: true
	    });
    });

    $('#alldocuments').dataTable({
		"bSort": true,
		"iDisplayLength": 50,
		// "dom": 'Bfrtip',
		"buttons": [
	        'copy', 'excel', 'pdf'
	    ]
	});


    $('.dp').datepicker({
      format:"yyyy-mm-dd",  
      // format:"dd-mm-yyyy",  
      defaultDate: new Date(),
      autoclose: true
    });


    $( ".btn.dropdown-toggle" ).click(function() {
      $(this).closest('.btn-group').find('.dropdown-menu').toggle();
    });

    $( "#addAtachBtn" ).click(function() {
        var le_input = $(this).closest('.input-group').find('input.form-control');
        var le_link = le_input.val();
        var random = (0|Math.random()*9e6).toString(36);
        if(le_link.length > 0){
            le_input.removeClass('required');
            var tr = '';
            tr += '<tr data-id="0">';
            tr += '<td>';
            tr += '<a href="'+le_link+'" target="_blank">'+le_link+'</a>';
            tr += '<input value="'+le_link+'" name="new_attach['+random+'][attach]" type="hidden">';
            tr += '</td>';
            tr += '<td>';
            tr += '<span class="rem_tr" onclick="remove_tr(this);"><i class="fa fa-trash-o"></i></span>';
            tr += '</td>';
            tr += '</tr>';

            $('#table_attach tr:last').after(tr);
            le_input.val('');
        }else{
            le_input.addClass('required');
        }
    });


    $( "#add_prod" ).click(function() {
        var le_input = $(this).closest('.attach_sp').find('#select_prod');
        var id = $(le_input).val();
        var  _csrf = $('meta[name="csrf-token"]').attr("content");
        var str_href = $(le_input).attr('data-url');
        var re = /le_ID/gi;
        var new_url = str_href.replace(re, id);

        // console.log(le_input.val());
        // console.log(new_url);
        
        $.ajax({
            url: new_url,
            type: "POST",
            data: {
                id    : id,
                _csrf : _csrf, 
            },
            dataType: "json",
            success: function (response) {
        		var random = (0|Math.random()*9e6).toString(36);
            var tr = '';

            $.each(response, function(index, element) {
                tr += '<tr data-id="0" class="active">';
                tr += '<td>';
                tr += element.title_en;
                tr += '<input value="'+element.id+'" name="new_prodd['+random+'][id]" type="hidden">';
                tr += '<input value="'+element.title_en+'" name="new_prodd['+random+'][title_en]" type="hidden">';
                tr += '<input value="'+element.title_fr+'" name="new_prodd['+random+'][title_fr]" type="hidden">';
                tr += '</td>';
                tr += '<td>';
                tr += element.title_fr;
                tr += '</td>';
                tr += '<td>';
                tr += '<span class="rem_tr" onclick="remove_tr(this);"><i class="fa fa-trash-o"></i></span>';
                tr += '</td>';
                tr += '</tr>';
            });
            
              $('#table_products_add tr:last').after(tr);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // swal("Error deleting!", "Please try again", "error");
            }
        });


        /*
        var le_link = le_input.val();
        var random = (0|Math.random()*9e6).toString(36);
        if(le_link.length > 0){
            le_input.removeClass('required');
            var tr = '';
            tr += '<tr data-id="0">';
            tr += '<td>';
            tr += '<a href="'+le_link+'" target="_blank">'+le_link+'</a>';
            tr += '<input value="'+le_link+'" name="new_attach['+random+'][attach]" type="hidden">';
            tr += '</td>';
            tr += '<td>';
            tr += '<span class="rem_tr" onclick="remove_tr(this);"><i class="fa fa-trash-o"></i></span>';
            tr += '</td>';
            tr += '</tr>';

            $('#table_attach tr:last').after(tr);
            le_input.val('');
        }else{
            le_input.addClass('required');
        }
        */
    });



    $( "#select_prod" ).change(function() {
        var id = $(this).val();
        var  _csrf = $('meta[name="csrf-token"]').attr("content");
        var str_href = $(this).attr('data-url');
        var re = /le_ID/gi;
        var new_url = str_href.replace(re, id);
        $.ajax({
            url: new_url,
            type: "POST",
            data: {
                id    : id,
                _csrf : _csrf, 
            },
            dataType: "json",
            success: function (response) {
                $('#t_en').val(response.title_en);
                $('#t_fr').val(response.title_fr);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // swal("Error deleting!", "Please try again", "error");
            }
        });
    });

    $('.js-sub-menu-toggle2').click(function() {
        $(this).closest('li').find('ul.sub-menu2').slideToggle();
        return false;
    });






}); 



function remove_tr(el){
    var id = $(el).closest('tr').attr('data-id');
    var random = (0|Math.random()*9e6).toString(36);

    if(id == 0){
        $(el).closest('tr').remove();
    }else{
        var tr = '';
        tr += '<tr>';
        tr += '<td>';
        tr += '<input type="hidden" name="remove_attach['+random+']" value="'+id+'">';
        tr += '</td>';
        tr += '</tr>';

        // console.log('BD TR');
        $('#attach_dell tr:last').after(tr);

        $(el).closest('tr').remove();
    }
}


function resendfunc(item){
    var  _csrf = $('meta[name="csrf-token"]').attr("content");
    var url = $(item).attr('data-url');

    $('#ajax_loading').css('display', 'block');

    $.ajax({
            url: url,
            type: "POST",
            data: {
                _csrf : _csrf, 
            },
            dataType: "json",
            success: function (response) {

                // console.log(response.status);
                $('#ajax_loading').css('display', 'none');
                $.pjax.reload({container:'#wgrid-pjax'});
                
                // $('#t_en').val(response.title_en);
                // $('#t_fr').val(response.title_fr);
                // console.log(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // swal("Error deleting!", "Please try again", "error");
            }
        });
}

$("input[type=radio][name=payment_type]").on('change', function () {
    var pType = $(this).val();
    var currPlan = $('a.current-plan').data('plan_cycle');
    if(currPlan == pType){
        $('a.current-plan').show();
        $('a.current-plan').next('a.apply-current-plan').hide();
    } else {
        $('a.current-plan').hide();
        $('a.apply-current-plan').removeClass('hidden').show();
    }

    $("div.toppart-freeplan").find('h4').addClass('hidden');
    $("h4#payment_type_" + pType).removeClass('hidden');
});


function getPaymentForm(elem) {
    if(elem){
        var nPlan = $(elem).data('package');
        var sPaymentType = $("input[type=radio][name=payment_type]:checked").val();
        var sUrl = $(elem).data('rel');
        var btn = $("#pay-upgrade").find(".btn-paypal");

        $(btn).attr('data-package',nPlan);
        $(btn).attr('data-payment_type',sPaymentType);
        $(btn).attr('data-rel',sUrl);

        $('#pay-upgrade').modal({
            show: true
        });
    }
    return false;
}

 function getPaypalUrl(elem) {
     $(elem).attr('disabled', true).text("please wait...");

     var nPlanId = $(elem).data('package');
     var sPaymentType = $("input[type=radio][name=payment_type]:checked").val();
     var sUrl = $(elem).data('rel');
     $.post(sUrl, {
         plan: nPlanId,
         type: sPaymentType,
     }, function(data) {
         if (data.status == 200) {
             window.location.href = data.url;
         } else {
             var msg = "PayPal App not set yet.";
             if(data.msg.error_description) {
                 msg = data.msg.error_description;
             }
             $(elem).attr('disabled', false).html(msg);
         }
     });
 }

 function bulkReminders(elem) {
     var  _csrf = $('meta[name="csrf-token"]').attr("content");
     var keys = $("#wgrid").yiiGridView("getSelectedRows");
     if(keys.length > 0) {
         $('#ajax_loading').css('display', 'block');
         var sUrl = $(elem).data('url');


         $.ajax({
             url: sUrl,
             type: "POST",
             data: {
                 _csrf : _csrf,
                 keys: keys,
             },
             dataType: "json",
             success: function (response) {
                 $('#ajax_loading').css('display', 'none');
                 $.pjax.reload({container:'#wgrid-pjax'});
             },
             error: function (xhr, ajaxOptions, thrownError) {
                  swal("Error deleting!", "Please try again", "error");
             }
         });



     }
 }
