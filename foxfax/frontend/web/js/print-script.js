$base_url=window.location.protocol+'//'+window.location.host+'/index.php/';
$path_url=window.location.protocol+'//'+window.location.host+'/';
function printDiv(divName) {
	var divToPrint =$("#"+divName);
	//svar pagetitle =$(".page-title").html();
	divToPrint=divToPrint.html();
	var mywindow = window.open('', 'Documents Report', 'height=600,width=800');
	mywindow.document.write('<html><head><title>Documents Report</title><link href="'+$path_url+'css/appcss/printing.css" rel="stylesheet" type="text/css" media="all" >');
	mywindow.document.write('</head><body onload="window.print()" >');
	//mywindow.document.write(pagetitle);
	mywindow.document.write(divToPrint);
	mywindow.document.write('</body></html>');
	mywindow.document.close(); // necessary for IE >= 10
	mywindow.focus(); // necessary for IE >= 10
	
	//mywindow.print();
	mywindow.document.close();
	return true; 
}

$("#btnExport").click(function(e) {
	//getting values of current time for generating the file name
	var dt = new Date();
	var day = dt.getDate();
	var month = dt.getMonth() + 1;
	var year = dt.getFullYear();
	var hour = dt.getHours();
	var mins = dt.getMinutes();
	var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
	//creating a temporary HTML link element (they support setting file names)
	var a = document.createElement('a');
	//getting data from our div that contains the HTML table
	var data_type = 'data:application/vnd.ms-excel';
	var table_div = document.getElementById('alldocuments');
	// var table_div = document.getElementById('print_table');
	var table_html = table_div.outerHTML.replace(/ /g, '%20');
	a.href = data_type + ', ' + table_html;
	//setting the file name
	a.download = 'exported_table_' + postfix + '.xls';
	//triggering the function
	a.click();
	//just in case, prevent default behaviour
	e.preventDefault();
});



$(".exp_by_tb").click(function(e) {
	table_ID = $(this).attr('data-id');
	//getting values of current time for generating the file name
	var dt = new Date();
	var day = dt.getDate();
	var month = dt.getMonth() + 1;
	var year = dt.getFullYear();
	var hour = dt.getHours();
	var mins = dt.getMinutes();
	var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
	//creating a temporary HTML link element (they support setting file names)
	var a = document.createElement('a');
	//getting data from our div that contains the HTML table
	var data_type = 'data:application/vnd.ms-excel';
	var table_div = document.getElementById(table_ID);
	// var table_div = document.getElementById('print_table');
	var table_html = table_div.outerHTML.replace(/ /g, '%20');
	a.href = data_type + ', ' + table_html;
	//setting the file name
	a.download = 'exported_table_' + postfix + '.xls';
	//triggering the function
	a.click();
	//just in case, prevent default behaviour
	e.preventDefault();
});


