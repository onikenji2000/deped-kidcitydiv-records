var doc_nos = {};
$('a[name=generate_code]').on('click', function(){
	$.get('./php/code.generator.php',
	{
		venn: 'nada'
	},
	function(data, status) {
		doc_nos = data.split(',');
		$('#code_num').val(parseInt(doc_nos[0]) + 1);
		var dates = new Date();
		var now = new Date();
		
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		$('.datePicker').val(today);
		
		generate();
	});
});

$("#barcodeForm").submit(function(evt){
	evt.preventDefault();
	$("#hidablepanel").fadeToggle("fast");
	$("#initBarcodeForm").fadeToggle("fast");
	$.get("./php/check.code.php",
	{
		code: $("#mainBarcode").val()
	},
	function(data, status) {
		if(data == 0) {
			newCode();
		} else if(data > 0) {
			existCode($("#mainBarcode").val());
		}
	}
	)
});

//If the Document Code is not recorded yet call this function
function newCode() {
	$.get("./php/new.code.php",
	{
		code: $("#mainBarcode").val()
	},
	function(data, status){
		$("#barView").slideToggle();
		$("#updaterdiv").slideToggle();
		$("#updaterdiv").html(data);
		
		$("#upload_file").change(function() {
			$("#file_to_upload").html("File: " + $("#upload_file").val());
		});
		$("#doc_tags").tagsinput("refresh");
		$("#newCodeForm").submit(function(evt){
			evt.preventDefault();
			var frm = new FormData($(this)[0]);
			save_records(frm);
		});
	});
}

//If the Document code has an equivalent in the database call this function
function existCode(datas) {
	$.get("./php/existing.code.php",
	{
		code: datas
	},
	function(data, status){
		$("#barView").slideToggle();
		$("#updaterdiv").slideToggle();
		$("#updaterdiv").html(data);
		
		$("#upload_file").change(function() {
			$("#file_to_upload").html("File: " + $("#upload_file").val());
		});
		$("#doc_tags").tagsinput("removeAll");
		swapQR();
		$("#file_uform").submit(function(evt){
			evt.preventDefault();
			add_attachment();
		});
	});
}

//Save the new entry in the records
function save_records(form_data) {
	$.ajax({
		url: "./php/save.document.php",
		type: "POST",
		data: form_data,
		async: false,
		success: function(data, status) {
			$("#updaterdiv").slideToggle();
			$("#updaterdiv").html(data);
			$("#updaterdiv").slideToggle();
			if(parseInt(data) > 0) {
				location.reload();
			}
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

//Open File from the file-opener
function open_file(file_name, file_type) {
	
	var divstr = "";
	if(file_type == "pdf") {
		divstr = '<object data="php/' + file_name + '" type="application/pdf" width="100%" height="100%">\n' +
		'alt: <a href="php/' + file_name + '">File Attachment cant be read click here to view</a>\n' +
		'</object>';
	} else if(file_type == 'png' || file_type == 'jpg' || file_type == ' bmp' || file_type == 'gif') {
		divstr = '<img src="php/' + file_name + '" width="100%" height="100%">';
	}
	
	$('#file_holder').html(divstr);
}

//Show the user qr code
function swapQR() {
	var qrme = $('.qrme');
	for(var i = 0; i < qrme.length; i++) {
		var qr = qrme.eq(i).html();
		qrme.eq(i).html('');
		var qrcodeid = 'qrcode' + (i + 1);
		var qrcode = new QRCode(document.getElementById(qrcodeid), {width: 50, height: 50});
		qrcode.makeCode(qr);
	}
}

//This function runs when attach selected file button is pressed
function add_attachment() {
	
	var shodata = new FormData(document.getElementById('file_uform'));
	shodata.append('barcode', $('#doc_code_label').html());
	shodata.append('date_rec', $('#date_rec').html());
	
	$.ajax({
		type: "POST",
		url: "./php/attach.file.php",
		data: shodata,
		processData:false,
		contentType: false,
		cache: false,
		success: function(data, status){
			if(data != '0') {
				location.reload();
			}
		}
	});
}

//----------------------------------------------------------CODE GENERATOR --------------------------------------------------------
$("#generate_code_Modal").on("change", function() {
	//generate()
	
	$.get('./php/code.generator.php',
	{
		venn: 'nada'
	},
	function(data, status) {
		doc_nos = data.split(',');
		$('#code_num').val(parseInt(doc_nos[0]) + 1);
		var dates = new Date();
		var now = new Date();
		
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		$('.datePicker').val(today);
		
		generate();
	});
});

function generate(){
	$('#code_num').val(parseInt(doc_nos[parseInt($('#code_type').val()) - 1]) + 1);
	var codeDate = new Date();
	var codeYear = codeDate.getFullYear();

	var code_type = $("#code_type").val();

	var code_number = String($("#code_num").val());
	while (code_number.length < (4 || 2)) {code_number = "0" + code_number;}

	var code_year = codeYear;
	var code_author = $("#code_prepared").val();

	var barcode = code_type + "-" + code_number + "-" + code_year + "-" + code_author; 

	JsBarcode("#barcode1", barcode, {
		format: "CODE128",
		displayValue: true,
		textAlign: "center",
		fontSize: 9,
		width: 2,
		height: 15
	});
}

function editDocument(doc_code) {
	$.get('./php/new.code.php',
	{
		doc_code: doc_code
	},
	function(data, status) {
		$('#updaterdiv').html(data);
		$("#doc_tags").tagsinput("refresh");
	});
}