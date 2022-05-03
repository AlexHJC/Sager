$base_url = window.location.protocol + "//" + window.location.host + "/"; 
$path_url = window.location.protocol + "//" +window.location.host + "/";
$("#quickreminder").validate({
        rules: {
            CatCode: {
                required: !0
            }
        },
        submitHandler: function(e) {
        $(".error").html("");
 $.post($base_url + "reminders/get_validation/", $("form#quickreminder").serialize(), function(a) {
        "1" != a ? $.each(a, function(e, a) {
		     $("span." + e).html(a)
			    }) : e.submit()
            },"json"), !1
        }
});

$("#dashboardsearch").validate({
        rules: {
            string: {
                required: !0
            }
        },errorPlacement: function(){
            return false;
        }, 
        submitHandler: function(e) {
 $.post($base_url + "dashboard/search/", $("form#dashboardsearch").serialize(), function(data) {
$("#showdocresult").html(data);
	 }), !1
        }
});
$( document ).ready(function() {
$( ".quickreminder" ).change(function(){
$("#quickreminderview").html("");	
$catcode=$(this).val();
if($catcode!='')
{
$.post($base_url + "dashboard/quickreminder//"+$catcode, function(data) {
$("#quickreminderview").html(data);
});
}else
{
$("#quickreminderview").html("");	
}
});
if($('.quickreminder').length > 0)
{
$( ".quickreminder" ).change();
}
//$( ".quickreminder" )
$("a.topopup").click(function() {
url=$(this).attr("hrefurl");
popup = window.open(url, "Reminder view", "height=512, width=512");
popup.blur();
window.focus();
});	
});
 