
<!-- /**
	* @module PETA JALUR
	* @author  ADITYA NOMAN
*/ -->
<!-- <link rel="stylesheet" type="text/css" href="http://10.14.152.223/leaflet.css">
<script type="text/javascript" src="http://10.14.152.223/leaflet.js"></script> -->   

<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/> -->

<!-- <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script> -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/library/leaflet.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/library/maps/leaflet.js"></script>

<style>
   #map{
	   width:100%;
	   height:100%;
	   position:absolute;
   }
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
		</div>
	</div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div class="content_table">
                    <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                                </div>
                            </div>
                        </div><br/>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Pembangkit : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                            	<label for="password" class="control-label"><span class="required"></span></label>
                                <div class="controls">
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                </div>
                                <br>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                

                <div id="content_table" data-source="<?php echo $data_sourcesx; ?>" data-filter="#ffilter" hidden></div>

                <div class="well-content no-search" id="div_peta">
                    <div class="well" style="height:550px;">
                        <!-- <div class="pull-left"> -->
						<div id="map"></div>
                        <!-- </div>  --><!-- end pull left -->
					</div>
					<label><b>Legend :</b></label><br>
					<table>
						<tr>
							<td><label><i><img src="<?php echo base_url();?>assets/img/pltd1.png" style="width:15px;height:15px;"> - Depo</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url();?>assets/img/pltd2_merah.png" style="width:15px;height:15px;"> - Pembangkit (SHO 0-3 hari)</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url();?>assets/img/pltd2_kuning.png" style="width:15px;height:15px;"> - Pembangkit (SHO 4-6 hari)</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url();?>assets/img/pltd2.png" style="width:15px;height:15px;"> - Pembangkit (SHO >= 7 hari)</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url();?>assets/img/biru.png" style="width:15px;height:7px;"> - Jalur Terima</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url();?>assets/img/ungu.png" style="width:15px;height:7px;"> - Jalur Kirim</i></label></td>
						</tr>
					</table>
					<br>
					<label><i>(* Klik Logo Depo untuk melihat jalur pasokan)</i></label><br>
					<label><i>(* Klik Logo Pembangkit untuk melihat detail stok BBM dan jalur pasokan)</i></label><br>	
					<label><i>(* Klik Jalur Pasokan untuk melihat perolehan BBM)</i></label><br>
                    <label><i>(* SHO : Sisa Hari Operasi)</i></label></br>
                    <label><i>(* Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></label></br>
                    <label><i>(* Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></label></br>										
				</div> 
				<br><br>
			</div>		
		</div>
	</div>
    
</div>

<script type="text/javascript">
    jQuery(function ($) {
        load_table('#content_table', 1, '#ffilter');
        $('#button-filter').click(function () {
            getPeta();
        });
    }); 
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
</script>

<script type="text/javascript">
	var pltd1 = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd1.png',
	    // shadowUrl: 'leaf-shadow.png',
	    iconSize:     [17, 17], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2 = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd2.png',
	    // shadowUrl: 'leaf-shadow.png',
	    iconSize:     [17, 17], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2_kuning = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd2_kuning.png',
	    // shadowUrl: 'leaf-shadow.png',
	    iconSize:     [17, 17], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2_merah = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd2_merah.png',
	    // shadowUrl: 'leaf-shadow.png',
	    iconSize:     [17, 17], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var map = L.map('map', {
        zoomDelta: 0.25,
        zoomSnap: 0
    }).setView( [-1.9205768,118.5820232], 4.75  );

	// var layer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
	// 			    maxZoom: 27,
	// 			    id: 'mapbox.streets',
	// 			    accessToken: 'pk.eyJ1IjoiZmFqYXJ5dWR5IiwiYSI6ImNqbDZrZGMxNDBzb2UzeG50bXF3MnVzc3EifQ.IE6n-TkthG16ipaiYza4eQ'
	// 			}).addTo(map);

	var layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

	var _polylineArray = [];
	var _polylines = '';
	var _markerArray = [];
	var _markers = '';

	getPeta();
	function getPeta(){
		bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
		/*
			Loooping disini untuk draw Polyline dan Juga Membuat Marker Pembangkit dan Depo
		*/
		setGarisHapusSemua();
		seMarkerHapus();
		$('html, body').animate({scrollTop: $("#div_peta").offset().top}, 1000);

        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val(); 

		var vlink_url = '<?php echo base_url()?>dashboard/peta_jalur/get_peta/';
		$.ajax({
		    url: vlink_url,
		    type: "POST",
		    dataType: "json",
		    data: {"ID_REGIONAL": lvl0,
                   "COCODE": lvl1,
                   "PLANT": lvl2,
                   "STORE_SLOC": lvl3,
                   "SLOC": lvl4,
            },
		    success:function(data) {
		    	bootbox.hideAll();

				if (data == "" || data == null) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
                }

		        $.each(data, function(key, value) {

		        	//depo
		        	if ((value.LAT_DEPO)&&(value.LOT_DEPO)){
		        		var lbl_depo = 'DEPO';
		        		var lbl_stok = '';
			        	var icon_depo = pltd1;
			        	var jenis_depo = "depo";
			        	var id_depo = value.ID_DEPO; 
			        	var btn_garis_terima = '';
			        	var btn_hapus_terima = '';				        	
			        	// if (value.ID_DEPO=='000'){
			        	if (value.NAMA_PEMASOK=='PT PLN (PERSERO)'){
			        		lbl_depo = 'PEMBANGKIT';
			        		icon_depo = pltd2;
			        		jenis_depo = "unit_pln";
			        		// id_depo = value.SLOC_UNIT_PLN;

				        	// btn_garis_terima = '<button id="T_'+id_depo+'" id_val="'+id_depo+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Terima</button>';
				        	// btn_hapus_terima = '<button id="HT_'+id_depo+'" jenis="sloc" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';				        	
			        	}

		        		var btn_garis = '<button id="K_'+id_depo+'" id_val="'+id_depo+'" jenis="'+jenis_depo+'" warna="purple" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Kirim</button>';		        		
			        	var btn_hapus = '<button id="HK_'+id_depo+'" jenis="'+jenis_depo+'" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';

			        	var det_depo = '<strong>'+lbl_depo+'</strong><br>'+value.NAMA_DEPO+'<br><br><br>'+btn_garis+' '+btn_hapus+'<br>'+btn_garis_terima+' '+btn_hapus_terima;

						try {
							var a = L.marker([parseFloat(value.LAT_DEPO), parseFloat(value.LOT_DEPO)], {icon: icon_depo}).bindPopup(det_depo).openPopup();

				        	if (value.NAMA_PEMASOK=='PT PLN (PERSERO)'){
					        	var btn_garis_terima_d = '<button id="T_'+id_depo+'" id_val="'+id_depo+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Terima</button>';
					        	var btn_hapus_terima_d = '<button id="HT_'+id_depo+'" jenis="sloc" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';	

				        		var btn_garis_d = '<button id="K_'+id_depo+'" id_val="'+id_depo+'" jenis="'+jenis_depo+'" warna="purple" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Kirim</button>';		        		
					        	var btn_hapus_d = '<button id="HK_'+id_depo+'" jenis="'+jenis_depo+'" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';					        	

								a.on('click',function(){
									obj = this;
								    // function getStok(id){ 
								    	var det_stok = '';

								    	var _id = value.ID_DEPO;
								    	var _jenis = 'sloc';
								        
								        var lvl0 = $('#lvl0').val(); 
								        var lvl1 = $('#lvl1').val(); 
								        var lvl2 = $('#lvl2').val(); 
								        var lvl3 = $('#lvl3').val(); 
								        var lvl4 = $('#lvl4').val(); 

									    // var data_kirim = "id="+_id+'&jenis='+_jenis;

									    var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

									    // bootbox.modal('<div class="loading-progress"></div>');
									    $.ajax({
									    type: 'POST',
									    url: url,
									    // data: data_kirim,
							    	    data: {"id": _id,
									    	   "jenis": _jenis,
									    	   "ID_REGIONAL": lvl0,
								               "COCODE": lvl1,
								               "PLANT": lvl2,
								               "STORE_SLOC": lvl3,
								               "SLOC": lvl4
								        },
									    dataType:'json',
									        error: function(data) {
									            // bootbox.hideAll();	       
									            pesanGagal('Proses data gagal hapus jalur');
									        },
									        success: function(data) {
									            // bootbox.hideAll();
									            // map.closePopup();
									            $.each(data, function(key, value) {

										        	var _SA_HSD='' , _SA_MFO='' , _SA_HSDBIO='' , _SA_BIO='' , _SA_IDO= '';
									        		var _SHO_HSD=0, _SHO_MFO=0 , _SHO_HSDBIO=0 , _SHO_BIO=0, _SHO_IDO=0, _SHO_MIN = 999999;

										        	if (value.SA_HSD!=null){
										        		_SA_HSD = '<br>HSD: '+toRp(value.SA_HSD)+' L '+
																		'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSD)+' Hari)';

														if (value.SHO_HSD!=null){
															_SHO_HSD = value.SHO_HSD;	
														}							
														_SHO_MIN = _SHO_HSD;
										        	}

										        	if (value.SA_MFO!=null){
										        		_SA_MFO = '<br>MFO: '+toRp(value.SA_MFO)+' L '+
																		'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_MFO)+' Hari)';
														
														if (value.SHO_MFO!=null){
															_SHO_MFO = value.SHO_MFO;	
														}
														if (_SHO_MFO < _SHO_MIN) { _SHO_MIN = _SHO_MFO;}
										        	}

										        	if (value.SA_HSDBIO!=null){
										        		_SA_HSDBIO = '<br>HSD+BIO: '+toRp(value.SA_HSDBIO)+' L '+
																		'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSDBIO)+' Hari)';
														
														if (value.SHO_HSDBIO!=null){
															_SHO_HSDBIO = value.SHO_HSDBIO;	
														}
														if (_SHO_HSDBIO < _SHO_MIN) { _SHO_MIN = _SHO_HSDBIO;}
										        	}

										        	if (value.SA_BIO!=null){
										        		_SA_BIO = '<br>BIO: '+toRp(value.SA_BIO)+' L '+
																		'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_BIO)+' Hari)';
														
														if (value.SHO_BIO!=null){
															_SHO_BIO = value.SHO_BIO;	
														}
														if (_SHO_BIO < _SHO_MIN) { _SHO_MIN = _SHO_BIO;}
										        	}

										        	if (value.SA_IDO!=null){
										        		_SA_IDO = '<br>IDO: '+toRp(value.SA_IDO)+' L '+
																		'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_IDO)+' Hari)';
														
														if (value.SHO_IDO!=null){
															_SHO_IDO = value.SHO_IDO;	
														}
														if (_SHO_IDO < _SHO_MIN) { _SHO_MIN = _SHO_IDO;}
										        	}

													// Ini data untuk yg peta jalur pasokan
													// 0 - 3 MERAH
													// 4 - 6 KUNING
													// > 7 Hijau							

													if (_SHO_MIN <=3){
														icon_depo = pltd2_merah;
													} else if (_SHO_MIN <=6){
														icon_depo = pltd2_kuning;
													} else {
														icon_depo = pltd2;
													}

										        	var lbl_stok_d = _SA_HSD+_SA_MFO+_SA_HSDBIO+_SA_BIO+_SA_IDO;
				    						    
										        	var det_depo_d = '<strong>'+lbl_depo+'</strong><br>'+value.UNIT+'<br>'+lbl_stok_d+'<br><br>'+btn_garis_d+' '+btn_hapus_d+'<br>'+btn_garis_terima_d+' '+btn_hapus_terima_d;						            							
									            	obj.bindPopup(det_depo_d);
									            });
									        }    
									    })
								    // } 
								});						        				        	
				        	}
							

							_markerArray.push(a);
							_markers = L.layerGroup(_markerArray);
							_markers.addTo(map);	
						} catch (err) {
							pesanGagal('<strong>'+lbl_depo+'</strong><br>'+value.NAMA_DEPO+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
						}				
					}

					//pltd
		        	if ((value.LAT_LVL4)&&(value.LOT_LVL4)){ 			        	
			        	var btn_garis = '<button id="'+value.SLOC+'" id_val="'+value.SLOC+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)">Jalur Terima</button>';
			        	// var btn_hapus = '<button onclick="setGarisHapus()">Hapus Jalur</button>';
			        	var btn_hapus = '<button id="HP_'+value.SLOC+'" jenis="sloc" id_depo="'+value.SLOC+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';

			        	var _SA_HSD='' , _SA_MFO='' , _SA_HSDBIO='' , _SA_BIO='' , _SA_IDO= '';
			        	var _SHO_HSD=0, _SHO_MFO=0 , _SHO_HSDBIO=0 , _SHO_BIO=0, _SHO_IDO=0, _SHO_MIN = 999999;

			        	
			        	if (value.SA_HSD!=null){
			        		_SA_HSD = '<br>HSD: '+toRp(value.SA_HSD)+' L '+
											'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSD)+' Hari)';

							if (value.SHO_HSD!=null){
								_SHO_HSD = value.SHO_HSD;	
							}							
							_SHO_MIN = _SHO_HSD;
			        	}

			        	if (value.SA_MFO!=null){
			        		_SA_MFO = '<br>MFO: '+toRp(value.SA_MFO)+' L '+
											'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_MFO)+' Hari)';
							
							if (value.SHO_MFO!=null){
								_SHO_MFO = value.SHO_MFO;	
							}
							if (_SHO_MFO < _SHO_MIN) { _SHO_MIN = _SHO_MFO;}
			        	}

			        	if (value.SA_HSDBIO!=null){
			        		_SA_HSDBIO = '<br>HSD+BIO: '+toRp(value.SA_HSDBIO)+' L '+
											'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSDBIO)+' Hari)';
							
							if (value.SHO_HSDBIO!=null){
								_SHO_HSDBIO = value.SHO_HSDBIO;	
							}
							if (_SHO_HSDBIO < _SHO_MIN) { _SHO_MIN = _SHO_HSDBIO;}
			        	}

			        	if (value.SA_BIO!=null){
			        		_SA_BIO = '<br>BIO: '+toRp(value.SA_BIO)+' L '+
											'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_BIO)+' Hari)';
							
							if (value.SHO_BIO!=null){
								_SHO_BIO = value.SHO_BIO;	
							}
							if (_SHO_BIO < _SHO_MIN) { _SHO_MIN = _SHO_BIO;}
			        	}

			        	if (value.SA_IDO!=null){
			        		_SA_IDO = '<br>IDO: '+toRp(value.SA_IDO)+' L '+
											'&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_IDO)+' Hari)';
							
							if (value.SHO_IDO!=null){
								_SHO_IDO = value.SHO_IDO;	
							}
							if (_SHO_IDO < _SHO_MIN) { _SHO_MIN = _SHO_IDO;}
			        	}

						// Ini data untuk yg peta jalur pasokan
						// 0 - 3 MERAH
						// 4 - 6 KUNING
						// > 7 Hijau

						var pltd_SHO = '';

						if (_SHO_MIN <=3){
							pltd_SHO = pltd2_merah;
						} else if (_SHO_MIN <=6){
							pltd_SHO = pltd2_kuning;
						} else {
							pltd_SHO = pltd2;
						}

			        	var det_pemasok = '<strong>PEMBANGKIT</strong><br>'+value.UNIT+'<br>'+
											_SA_HSD+
											_SA_MFO+
											_SA_HSDBIO+
											_SA_BIO+
											_SA_IDO+
								        	'<br><br><br>'+btn_garis+' '+btn_hapus;

						try {
				           var a = L.marker([parseFloat(value.LAT_LVL4), parseFloat(value.LOT_LVL4)], {icon: pltd_SHO}).bindPopup(det_pemasok).openPopup();
									
							_markerArray.push(a);
							_markers = L.layerGroup(_markerArray);
							_markers.addTo(map);
						} catch (err) {
							pesanGagal('<strong>PEMBANGKIT</strong><br>'+value.UNIT+'<br>'+
											_SA_HSD+
											_SA_MFO+
											_SA_HSDBIO+
											_SA_BIO+
											_SA_IDO+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
						}												
					}
		        });
		    }
		});

		map.panTo(new L.LatLng(-1.9205768,118.5820232));
	}
	
	/*
		End Looping Draw Polyline
	*/

    function setMultigaris(id){ 
    	var _id = $('#'+id).attr('id_val');
    	var _jenis = $('#'+id).attr('jenis');
    	var _warna = $('#'+id).attr('warna');

        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val(); 
	    // var data_kirim = "id="+_id+'&jenis='+_jenis;

	    var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

	    bootbox.modal('<div class="loading-progress"></div>');
	    $.ajax({
	    type: 'POST',
	    url: url,
	    // data: data_kirim,
	    data: {"id": _id,
	    	   "jenis": _jenis,
	    	   "ID_REGIONAL": lvl0,
               "COCODE": lvl1,
               "PLANT": lvl2,
               "STORE_SLOC": lvl3,
               "SLOC": lvl4
        },	    
	    dataType:'json',
	        error: function(data) {
	            bootbox.hideAll();	       
	            pesanGagal('Proses data gagal setMultigaris');
	        },
	        success: function(data) {
	            bootbox.hideAll();
	            map.closePopup();
	            var ket = '';
	            
	            $.each(data, function () {
	            	ket = '<strong>PEMBANGKIT</strong><br>'+this.UNIT+'<br>'+
	            		'Pemasok : '+this.NAMA_PEMASOK+'<br>'+
	            		'Depo : '+this.NAMA_DEPO+'<br>'+
	            		'Transportir : '+this.NAMA_TRANSPORTIR+'<br><br>'+
			        	'Moda Transportasi : '+this.JENIS_PASOKAN+'<br>'+
			        	'Jarak tempuh : '+toRp(this.JARAK_TEMPUH)+' (KM atau ML)<br>'+
			        	'Ongkos angkut per liter : Rp '+toRp(this.ONGKOS_ANGKUT)+'  (+PPN 10%)<br>'+
			        	// 'Nilai kontrak : Rp '+toRp(this.NILAI_KONTRAK)+'<br>'+
			        	'Nomor Kontrak : '+this.NOMOR_KONTRAK;

					try {
						if ((this.NOMOR_KONTRAK=='') || (this.NOMOR_KONTRAK==null)){							
							pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> JALUR TIDAK TERSEDIA KARENA KONTRAK TRANSPORTIR SUDAH TIDAK BERLAKU/EXPIRED');
						} else									
						if ((this.LAT_LVL4=='') || (this.LOT_LVL4=='') || (this.LAT_LVL4==null) || (this.LOT_LVL4==null)){
							pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Pembangkit tidak tersedia');
							// pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Tidak Ada Jalur Pasokan Pada Kontrak Transportir Yang Berlaku');
						} else 
						if ((this.LAT_DEPO=='') || (this.LOT_DEPO=='') || (this.LAT_DEPO==null) || (this.LOT_DEPO==null)){
							pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Depo tidak tersedia');
							// pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Tidak Ada Jalur Pasokan Pada Kontrak Transportir Yang Berlaku');
						} else {
							setGaris(this.LAT_LVL4,this.LOT_LVL4,this.LAT_DEPO,this.LOT_DEPO,ket,_warna);	
						}
					} catch (err) {
						pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
					}
	            });    

	            if (data.length==0){
	            	pesanGagal('Tidak ada jalur pasokan');
	            }
	        }    
	    })
    } 

	function setGaris(a_lat, a_lot, b_lat, b_lot, ket, warna){
		if ((a_lat !== null) && (a_lot !== null) && (b_lat !== null) && (b_lot !== null)){
			var toUnion = [[a_lat, a_lot],[b_lat, b_lot]];			
	   		var a = L.polyline(toUnion,{color:warna,opacity:1});

	   		// polyline.bindTooltip('stuff')
	   		a.bindTooltip("Klik untuk melihat Detil Kontrak");

	   		// a.bindTooltip("Klik untuk melihat Detil Kontrak").openTooltip();

			a.on('click',function(){
			  this.bindPopup(ket);
			});			

			_polylineArray = [];
	   		_polylineArray.push(a);
	   		_polylines = L.layerGroup(_polylineArray);
	   		_polylines.addTo(map);   		
		}
	}

    function setGarisHapus(id){ 
    	var _id = $('#'+id).attr('id_depo');
    	var _jenis = $('#'+id).attr('jenis');

        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val();

	    // var data_kirim = "id="+_id+'&jenis='+_jenis;

	    var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

	    bootbox.modal('<div class="loading-progress"></div>');
	    $.ajax({
	    type: 'POST',
	    url: url,
	    // data: data_kirim,
	    data: {"id": _id,
	    	   "jenis": _jenis,
	    	   "ID_REGIONAL": lvl0,
               "COCODE": lvl1,
               "PLANT": lvl2,
               "STORE_SLOC": lvl3,
               "SLOC": lvl4
        },		    
	    dataType:'json',
	        error: function(data) {
	            bootbox.hideAll();	       
	            // pesanGagal('Proses data gagal setGarisHapus');
	        },
	        success: function(data) {
	            bootbox.hideAll();
	            map.closePopup();
	            var ket = '';
	            
	            $.each(data, function () {
					try {
					    setHapusGarisByLatLng(this.LAT_LVL4,this.LOT_LVL4,this.LAT_DEPO,this.LOT_DEPO);
					} catch (err) {
						pesanGagal('<strong>PESAN GAGAL :</strong><br>'+err.message);
					}
	            });    

	            if (data.length==0){
	            	pesanGagal('Tidak ada jalur pasokan');
	            }
	        }    
	    })
    } 

	function setGarisHapusX(){
		clearMap();
		// console.log(_polylines);
		// map.removeLayer(_polylines);
		// _polylines = '';
		// _polylineArray = [];
		// map.closePopup();
	}

	function setGarisHapusSemua() {
	    for(i in map._layers) {
	        if(map._layers[i]._path != undefined) {
	            try {
	                map.removeLayer(map._layers[i]);
	            }
	            catch(e) {
	                console.log("problem with " + e + map._layers[i]);
	            }
	        }
	    }
	}

	function setHapusGarisByLatLng(a_lat, a_lng, b_lat, b_lng) {
	    for(i in map._layers) {
	        if(map._layers[i]._path != undefined) {
	            try {
	            	if ((a_lat==map._layers[i]._latlngs[0].lat) && (a_lng==map._layers[i]._latlngs[0].lng) &&
	            		(b_lat==map._layers[i]._latlngs[1].lat) && (b_lng==map._layers[i]._latlngs[1].lng)){
	            		map.removeLayer(map._layers[i]);	
	            	}                
	            }
	            catch(e) {
	                console.log("problem with " + e + map._layers[i]);
	            }
	        }
	    }
	}

	function seMarkerHapus(){
		try {
        	map.removeLayer(_markers);
	   		_markers = '';
	   		_markerArray = [];              
        }
        catch(e) {
            console.log("problem with seMarkerHapus " + e );
        }
   		
	}

    function toRp(angka){
        var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
        bilangan = bilangan.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            bilangan = bilangan.replace("-", "");
            isMinus = '-';
        }
        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        if ((rupiah=='') || (rupiah==0)) {rupiah='0,00'}
        rupiah = isMinus+''+rupiah;

        return rupiah;
    }

    function pesanGagal(vPesan){
	    var icon = 'icon-remove-sign'; 
	    var color = '#ac193d;';
	    var message = '';

	    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> Proses Gagal</div>';
	    message += vPesan;

	    bootbox.alert(message, function() {});
	}

</script>

<script type="text/javascript">
	function setDefaultLv1(){
	    $('select[name="COCODE"]').empty();
	    $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
	}

	function setDefaultLv2(){
	    $('select[name="PLANT"]').empty();
	    $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
	}

	function setDefaultLv3(){
	    $('select[name="STORE_SLOC"]').empty();
	    $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
	}

	function setDefaultLv4(){
	    $('select[name="SLOC"]').empty();
	    $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
	}

	$('select[name="ID_REGIONAL"]').on('change', function() {
	    var stateID = $(this).val();
	    var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
	    setDefaultLv1();
	    setDefaultLv2();
	    setDefaultLv3();
	    setDefaultLv4();
	    if(stateID) {
	        bootbox.modal('<div class="loading-progress"></div>');
	        $.ajax({
	            url: vlink_url,
	            type: "GET",
	            dataType: "json",
	            success:function(data) {
	                $.each(data, function(key, value) {
	                    $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
	                });
	                bootbox.hideAll();
	            }
	        });
	    }
	});

	$('select[name="COCODE"]').on('change', function() {
	    var stateID = $(this).val();
	    var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv2/'+stateID;
	    setDefaultLv2();
	    setDefaultLv3();
	    setDefaultLv4();
	    if(stateID) {
	        bootbox.modal('<div class="loading-progress"></div>');
	        $.ajax({
	            url: vlink_url,
	            type: "GET",
	            dataType: "json",
	            success:function(data) {
	                $.each(data, function(key, value) {
	                    $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
	                });
	                bootbox.hideAll();
	            }
	        });
	    }
	});

	$('select[name="PLANT"]').on('change', function() {
	    var stateID = $(this).val();
	    var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv3/'+stateID;
	    setDefaultLv3();
	    setDefaultLv4();
	    if(stateID) {
	        bootbox.modal('<div class="loading-progress"></div>');
	        $.ajax({
	            url: vlink_url,
	            type: "GET",
	            dataType: "json",
	            success:function(data) {
	                $.each(data, function(key, value) {
	                    $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
	                });
	                bootbox.hideAll();
	            }
	        });
	    }
	});

	$('select[name="STORE_SLOC"]').on('change', function() {
	    var stateID = $(this).val();
	    var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv4/'+stateID;
	    setDefaultLv4();
	    if(stateID) {
	        bootbox.modal('<div class="loading-progress"></div>');
	        $.ajax({
	            url: vlink_url,
	            type: "GET",
	            dataType: "json",
	            success:function(data) {
	                $.each(data, function(key, value) {
	                    $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
	                });
	                bootbox.hideAll();
	            }
	        });
	    }
	});
</script>