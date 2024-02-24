
function load_level(url, idllevel, idcbo, idlabel){
	bootbox.modal('<div class="loading-progress"></div>');
    $.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		$(idcbo).html("");
		$(idlabel).show();
		if (idllevel == "1"){
			$("#level1").show();
		}
		else if(idllevel == "2"){
			$("#level1").show();
			$("#level2").show();
		}
		else if(idllevel == "3"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
		}else if (idllevel == "4"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
			$("#level4").show();
		}			
		
		$(idcbo).append("<option value=''>--Pilih Level--</option>");
		for (var i=0; i <= result.length - 1; i++){
			$(idcbo).append("<option value='"+result[i].kode+"'>" + result[i].nama + "</option>");
		}
	});
}

function load_dynamic_levelgroup(url, kodelevel, idcbo, level){
	spltidcbo = idcbo.split(",");
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		if (level == "R"){
			$("#regional").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (kodelevel == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
		}
		if (level === "1"){
			$("#regional").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (kodelevel == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			
		}
		if (level === "2"){
			$("#regional").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (kodelevel == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}	
		}
		
		if (level === "3"){
			$("#regional").show();
			$(spltidcbo[3]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[3]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (result["idlevel2"] == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}
			$("#level3").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 3--</option>");
			for (var i=0; i <= result["level3"].length - 1; i++){
				select = '';
				if (kodelevel == result["level3"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level3"][i].kode+"'>" + result["level3"][i].nama + "</option>");
			}
			
		}
		if (level === "4"){
			$("#regional").show();
			$(spltidcbo[4]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[4]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[3]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[3]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (result["idlevel2"] == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}
			$("#level3").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 3--</option>");
			for (var i=0; i <= result["level3"].length - 1; i++){
				select = '';
				if (result["idlevel3"] == result["level3"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level3"][i].kode+"'>" + result["level3"][i].nama + "</option>");
			}
			$("#level4").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 4--</option>");
			for (var i=0; i <= result["level4"].length - 1; i++){
				select = '';
				if (kodelevel == result["level4"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level4"][i].kode+"'>" + result["level4"][i].nama + "</option>");
			}
			
		}
		
	});
}

function load_jenis_bbm(url, id){
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		html = '';
		$(id).html("");
		for (val in result){
			html += "<option value='"+val+"'>" + result[val] + "</option>";
		}
		$(id).html(html);
		$(id).data("placeholder","Select").trigger('liszt:updated');
	});
}

function load_jenis_bbm_def(url, id, def){
    bootbox.modal('<div class="loading-progress"></div>');
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json"
    }).done(function(result) {
        $(".bootbox").modal("hide");
        html = '';
        $(id).html("");
        for (val in result){
            html += "<option value='"+val+"'>" + result[val] + "</option>";
        }
        $(id).html(html);
        $(id).val(def);
        $(id).data("placeholder","Select").trigger('liszt:updated');
    });
}

function check_jenis_bbm(url, div_komponen, cbo_komponen){
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		html = "";
		$("#ismix").val("0");
		if (Object.keys(result).length > 1){
			$(div_komponen).show();
			for (val in result){
				html += "<option value='"+val+"'>" + result[val] + "</option>";
			}
			$("#ismix").val("1");
			$(cbo_komponen).html(html);
			$(cbo_komponen).data("placeholder","Select").trigger('liszt:updated');
		}else
			$(div_komponen).hide();
	});
}

function lihat_dokumen(id){
	// header("Access-Control-Allow-Methods: GET, OPTIONS");
	// header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
	// bootbox.modal('<div class="loading-progress"></div>');
	var modul = $("#"+id).data("modul");
	var url = $("#"+id).data("url");
	var filename = $("#"+id).data("filename");
	var vfolder = '';

	// var callback = 'jQuery1102010264193475672823_1522649420876';
	// var id = '1522649420877';

	switch (modul) {
	    case 'MINTA': vfolder = 'permintaan'; break;
	    case 'SO': vfolder = 'stockopname'; break;
	    case 'KONTRAKPEMASOK': vfolder = 'kontrak_pemasok'; break;
	    case 'KONTRAKTRANSPORTIR': vfolder = 'kontrak_transportir'; break;
	    case 'TANGKI': vfolder = 'tangki'; break;
	    default: vfolder = "";
	}

	var url = "/gbm/dashboard/get_file_prod";
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		type: "POST",
		url: url,
		data: { modul: modul, filename : filename},
		dataType:"json",
		success: function (data) {
			bootbox.hideAll();
			if (data){
				window.open('/gbm/assets/upload/'+vfolder+'/'+filename);
				// window.location.href = '/gbm/assets/upload/'+vfolder+'/'+filename;
			} else {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --File Tidak ditemukan-- </div>', function() {});	
			}
			// preventDefault(); 
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --File Tidak ditemukan-- </div>', function() {});	
		}
	});
			 


	
	// window.open('/gbm/assets/upload/'+vfolder+'/'+filename);
	// preventDefault(); 
	// window.location.href ='http://10.1.18.204/gbm/assets/upload/'+vfolder+'/'+filename;
	// $(".bootbox").modal("hide");

	// var link = '://10.1.18.204/gbm/assets/upload/'+vfolder+'/'+filename; 
	// var open = "<script>setTimeout(function(){var x = 'http'; window.open('+x+"+link+"');},20000)</script>";

    // var set_url = new_url+"?callback=jQuery110204219264456862809_1522654608012&modul="+modul+"&filename="+filename+"&_=1522654608013";
    // var myWindow = window.open(set_url, "MsgWindow", "width=100,height=100");
    // myWindow.document.write("Loading...");

    // myWindow.document.write(open);
 	// myWindow.document.write(x);
    
	// setTimeout(function(){myWindow.close();},20000);
	// setTimeout(function(){window.open('http://10.1.18.204/gbm/assets/upload/'+vfolder+'/'+filename);},20000);
	// setTimeout(function(){$(".bootbox").modal("hide");},20000);
	// return;

	// // setTimeout(function(){window.location.href = 'http://10.1.18.204/gbm/assets/upload/permintaan/'+filename;},7000);
	// // setTimeout(function(){myWindow.window.location.href = 'http://10.1.18.204/gbm/assets/upload/permintaan/'+filename;},7000);
	

	// $.ajax({
		// url: url,
		// method: "POST",
		// crossDomain: true,
		// dataType: 'jsonp',
		// data:{"modul": modul, "filename":encodeURI(filename)}
	// }).done(function(result) {
		// $(".bootbox").modal("hide");
		// console.log(result);
		// window.open(result, '_blank');
	// }).type("text");

	// $.ajax({
 //          url: url,
 //          type: 'POST',
 //          dataType: 'jsonp',
 //          cors: true ,
 //          crossDomain: true,
 //          contentType:'application/json',
	// 	  data:{"modul": modul, "filename":encodeURI(filename)},
 //          secure: true,
 //                    headers: {
 //                        'Access-Control-Allow-Origin': '*',
 //                    },
 //          beforeSend: function (xhr) {
 //              xhr.setRequestHeader ("Authorization", "Basic " + btoa(""));
	// 		  $(".bootbox").modal("hide");
 //          },
 //          success: function (data){
	// 		$(".bootbox").modal("hide");
 //          }
 //      })
}

