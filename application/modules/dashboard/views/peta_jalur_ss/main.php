<!-- /**
	* @module PETA JALUR
	* @author  ADITYA NOMAN
*/ -->
<!-- <link rel="stylesheet" type="text/css" href="http://10.14.152.223/leaflet.css">
<script type="text/javascript" src="http://10.14.152.223/leaflet.js"></script> -->

<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/> -->

<!-- <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script> -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/library/leaflet.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/library/maps/leaflet.js"></script>
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/library/leaflet-cluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/library/leaflet-cluster/dist/MarkerCluster.Default.css" />
<script src="<?php echo base_url();?>assets/js/library/leaflet-cluster/dist/leaflet.markercluster-src.js"></script> -->

<style>
	#map {
		width: 100%;
		height: 100%;
		position: absolute;
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
						</div><br />
						<div class="form_row">
							<!-- <div class="pull-left span3">
								<label for="password" class="control-label">Level 3 : </label>
								<div class="controls">
									<?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
								</div>
							</div> -->
							<div class="pull-left span3">
								<label for="password" class="control-label">Pembangkit : </label>
								<div class="controls">
									<?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
								</div>
							</div>
							<div class="pull-left span3">
                                <label for="password" class="control-label">HOP Pembangkit : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('HOP', $hop, !empty($default->HOP) ? $default->HOP : '', 'id="hop"'); ?>
                                </div>
                            </div>
							<div class="pull-left span3">
								<label for="password" class="control-label"><span class="required"></span></label>
								<div class="controls">
									<?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
									&ensp;
									<?php echo anchor(NULL, "View Depo & Jalur Pasokan", hidden, array('class' => 'btn dark blue', 'id' => 'button-depo')); ?>
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
						<!-- </div>  -->
						<!-- end pull left -->
					</div>
					<label><b>Legend :</b></label><br>
					<table>
						<tr>
							<!-- <td><label><i><img src="<?php echo base_url(); ?>assets/img/pltd1.png" style="width:15px;height:15px;"> - Depo</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> -->
							<td><label><i><img src="<?php echo base_url(); ?>assets/img/pltd2_merah.png" style="width:15px;height:15px;"> HOP Kritis</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url(); ?>assets/img/pltd2_kuning.png" style="width:15px;height:15px;"> HOP Siaga</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url(); ?>assets/img/pltd2.png" style="width:15px;height:15px;"> HOP Aman</i></label></td>
							<!-- <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url(); ?>assets/img/pltd2_biru.png" style="width:15px;height:15px;"> - Pembangkit (SHO <span id="param_blue"></span> hari)</i></label></td> -->
							<!-- <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> -->
							<!-- <td><label><i><img src="<?php echo base_url(); ?>assets/img/biru.png" style="width:15px;height:7px;"> - Jalur Terima</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label><i><img src="<?php echo base_url(); ?>assets/img/ungu.png" style="width:15px;height:7px;"> - Jalur Kirim</i></label></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> -->

						</tr>
					</table>
					<br>
					<table class="table table-bordered" style="width: 100%;text-align:center;">
						<thead>
							<tr>
								<td>
									<img src="<?php echo base_url(); ?>assets/img/pltd2_merah.png" style="width:15px;height:15px;">
									<b><span id="param_red1"></span></b>
								</td>
								<td>
									<img src="<?php echo base_url(); ?>assets/img/pltd2_kuning.png" style="width:15px;height:15px;">
									<b><span id="param_yellow1"></span></b>
								</td>
								<td>
									<img src="<?php echo base_url(); ?>assets/img/pltd2.png" style="width:15px;height:15px;">
									<b><span id="param_green1"></span></b>
								</td>
								<!-- <td>
									<img src="<?php echo base_url(); ?>assets/img/pltd2_biru.png" style="width:15px;height:15px;">
									<b>(<span id="param_blue1"></span> Hari)</b>
								</td> -->
								<!-- <td>
									<img src="<?php echo base_url(); ?>assets/img/pltd1.png" style="width:15px;height:15px;"> -->
									<!-- <b>(<span id="param_blue"></span> Hari)</b> -->
								<!-- </td> -->
								<td><b>Total</b></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b id="merah"> 0 </b> Unit</td>
								<td><b id="kuning"> 0 </b> Unit</td>
								<td><b id="hijau"> 0 </b> Unit</td>
								<!-- <td><b id="biru"> 0 </b> Unit</td>
								<td><b id="dep"> 0 </b> Unit</td> -->
								<td><b id="total_pembangkit"> 0 </b> Unit</td>
							</tr>
							<tr>
								<td><b id="persen_merah"> 0 </b></td>
								<td><b id="persen_kuning"> 0 </b></td>
								<td><b id="persen_hijau"> 0 </b></td>
								<!-- <td><b id="persen_biru"> 0 </b></td>
								<td><b id="total_dep"> 0 </b></td> -->
								<td><b id="persen_total"> 0 </b></td>
							</tr>
						</tbody>
					</table>
					<br>
					<label><i>(* HOP : Hari Operasi Pembangkit)</i></label></br>
					<label><i>(* Hari Operasi Pembangkit (Hari) : untuk pembangkit selain PLTU)</i></label></br>
					<label><i>(* Hari Operasi Pembangkit (kali start) : untuk pembangkit PLTU)</i></label></br>
				</div>
				<br><br>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	jQuery(function($) {
		load_table('#content_table', 1, '#ffilter');
		// getHOP();
		$('#button-filter').click(function() {
			getPeta();
		});
	});
	$('html, body').animate({
		scrollTop: $("#divTop").offset().top
	}, 1000);
</script>

<script type="text/javascript">
	function getHOP() {
		var url = "<?php echo base_url(); ?>dashboard/peta_jalur/get_hop";
		$.ajax({
			type: "GET",
			url: url,
			success: function(data) {
				var obj = JSON.parse(data);
				// console.log(data);
				document.getElementById("param_red").innerHTML = obj.FROM_DAY_RED;
				document.getElementById("param_red1").innerHTML = obj.FROM_DAY_RED;
				document.getElementById("param_yellow").innerHTML = obj.FROM_DAY_YELLOW;
				document.getElementById("param_yellow1").innerHTML = obj.FROM_DAY_YELLOW;
				document.getElementById("param_green").innerHTML = obj.FROM_DAY_GREEN;
				document.getElementById("param_green1").innerHTML = obj.FROM_DAY_GREEN;
				document.getElementById("param_blue").innerHTML = obj.FROM_DAY_BLUE;
				document.getElementById("param_blue1").innerHTML = obj.FROM_DAY_BLUE;
			}
		});
	}

	var pltd1 = L.icon({
		iconUrl: '<?php echo base_url() ?>assets/img/pltd1.png',
		// shadowUrl: 'leaf-shadow.png',
		iconSize: [17, 17], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
		// shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor: [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2 = L.icon({
		iconUrl: '<?php echo base_url() ?>assets/img/pltd2.png',
		// shadowUrl: 'leaf-shadow.png',
		iconSize: [17, 17], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
		// shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor: [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2_kuning = L.icon({
		iconUrl: '<?php echo base_url() ?>assets/img/pltd2_kuning.png',
		// shadowUrl: 'leaf-shadow.png',
		iconSize: [17, 17], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
		// shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor: [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2_merah = L.icon({
		iconUrl: '<?php echo base_url() ?>assets/img/pltd2_merah.png',
		// shadowUrl: 'leaf-shadow.png',
		iconSize: [17, 17], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
		// shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor: [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2_biru = L.icon({
		iconUrl: '<?php echo base_url() ?>assets/img/pltd2_biru.png',
		// shadowUrl: 'leaf-shadow.png',
		iconSize: [17, 17], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
		// shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor: [-3, -13] // point from which the popup should open relative to the iconAnchor
	});

	var map = L.map('map', {
		zoomDelta: 0.25,
		zoomSnap: 0
	}).setView([-1.9205768, 118.5820232], 4.75);

	// var layer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
	// 			    maxZoom: 27,
	// 			    id: 'mapbox.streets',
	// 			    accessToken: 'pk.eyJ1IjoiZmFqYXJ5dWR5IiwiYSI6ImNqbDZrZGMxNDBzb2UzeG50bXF3MnVzc3EifQ.IE6n-TkthG16ipaiYza4eQ'
	// 			}).addTo(map);

	var layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

	// var markers = L.markerClusterGroup();
	var _polylineArray = [];
	var _polylines = '';
	var _markerArray = [];
	var _markers = '';

	getPeta();

	function getPeta() {
		bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
		/*
			Loooping disini untuk draw Polyline dan Juga Membuat Marker Pembangkit dan Depo
		*/
		// setGarisHapusSemua();
		seMarkerHapus();
		$('html, body').animate({
			scrollTop: $("#div_peta").offset().top
		}, 1000);

		var lvl0 = $('#lvl0').val();
		var lvl1 = $('#lvl1').val();
		var lvl2 = $('#lvl2').val();
		var lvl3 = $('#lvl3').val();
		var lvl4 = $('#lvl4').val();
		var hop = $('#hop').val();

		var vlink_url = '<?php echo base_url() ?>dashboard/peta_jalur_ss/get_peta_ss/';
		$.ajax({
			url: vlink_url,
			type: "POST",
			dataType: "json",
			data: {
				"ID_REGIONAL": lvl0,
				"COCODE": lvl1,
				"PLANT": lvl2,
				"STORE_SLOC": lvl3,
				"SLOC": lvl4,
				"HOP": hop,
			},
			success: function(data) {
				bootbox.hideAll();
				datanew = data.filter(x => x.SHO_HSDBIO >= 15);

				if (data == "" || data == null) {
					bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
					$('html, body').animate({
						scrollTop: $("#divTop").offset().top
					}, 1000);
				}
				var merah = 0;
				var kuning = 0;
				var hijau = 0;
				var biru = 0;
				var dep = 0;
				var arr_merah = [];
				var arr_kuning = [];
				var arr_hijau = [];
				var arr_biru = [];
				var arr_dep = [];

				var depo = data.filter((data, index, self) =>
					index === self.findIndex((t) => (t.ID_DEPO == data.ID_DEPO)))

				var pembangkit = data.filter((data, index, self) =>
					index === self.findIndex((t) => (t.level4 == data.level4)))

				console.log(pembangkit);

				$.each(pembangkit, function(key, value) {
					//pltd
					if ((value.latitude) && (value.longitude)) {
						// var btn_garis = '<button id="' + value.SLOC + '" id_val="' + value.SLOC + '" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)">Jalur Terima</button>';
						// var btn_hapus = '<button onclick="setGarisHapus()">Hapus Jalur</button>';
						// var btn_hapus = '<button id="HP_' + value.SLOC + '" jenis="sloc" id_depo="' + value.SLOC + '" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';

						var _SA_HSD = '',
							_SA_MFO = '',
							_SA_HSDBIO = '',
							_SA_BIO = '',
							_SA_IDO = '';
						var _SHO_HSD = 0,
							_SHO_MFO = 0,
							_SHO_HSDBIO = 0,
							_SHO_BIO = 0,
							_SHO_IDO = 0,
							_SHO_MIN = 999999;
							_SHO_MIN_ = '';


						if (value.SA_HSD != null) {
							_SA_HSD = '<br>HSD: ' + toRp(value.SA_HSD) + ' L ' +
								'&nbsp;&nbsp;&nbsp;(HOP: ' + toRp(value.HOP_HSD) +  value.satuan + ')' +
								"<br><i style='font-size: 8px;'>Last Update: " + value.TGL_HSD + '</i>';
						} 
						if (value.SA_MFO != null) {
							_SA_MFO = '<br>MFO: ' + toRp(value.SA_MFO) + ' L ' +
								'&nbsp;&nbsp;&nbsp;(HOP: ' + toRp(value.HOP_MFO) +  value.satuan + ')' +
								"<br><i style='font-size: 8px;'>Last Update: " + value.TGL_MFO + '</i>';
						}
						if (value.SA_HSD_BIO != null) {
							_SA_HSDBIO = '<br>HSD+BIO: ' + toRp(value.SA_HSD_BIO) + ' L ' +
								'&nbsp;&nbsp;&nbsp;(HOP: ' + toRp(value.HOP_HSD_BIO) +  value.satuan + ')' +
								"<br><i style='font-size: 8px;'>Last Update: " + value.TGL_HSD_BIO + '</i>';
						}
						if (value.SA_IDO != null) {
							_SA_IDO = '<br>IDO: ' + toRp(value.SA_IDO) + ' L ' +
								'&nbsp;&nbsp;&nbsp;(HOP: ' + toRp(value.HOP_IDO) +  value.satuan + ')' +
								"<br><i style='font-size: 8px;'>Last Update: " + value.TGL_IDO + '</i>';
						}

						var pltd_SHO = '';

						
						if (value.warna == 'kuning') {
							pltd_SHO = pltd2_kuning;
							if (!arr_kuning.includes(value.level4)) {
								arr_kuning.push(value.level4);
								kuning++;
							}
						} else if (value.warna == 'merah') {
							pltd_SHO = pltd2_merah;
							if (!arr_merah.includes(value.level4)) {
								arr_merah.push(value.level4);
								merah++;
							}
						} else if (value.warna == 'hijau') {
							pltd_SHO = pltd2;
							if (!arr_hijau.includes(value.level4)) {
								arr_hijau.push(value.level4);
								hijau++;
							}
						}
						

						var det_pemasok = '<strong>PEMBANGKIT</strong><br>' + value.level4 + '<br>' +
							_SA_HSD +
							_SA_MFO +
							_SA_HSDBIO +
							_SA_IDO;

						try {
							var a = L.marker([parseFloat(value.latitude), parseFloat(value.longitude)], {
								icon: pltd_SHO
							}).bindPopup(det_pemasok).openPopup();
							_markerArray.push(a);
							_markers = L.layerGroup(_markerArray);
							_markers.addTo(map);
						} catch (err) {
							pesanGagal('<strong>PEMBANGKIT</strong><br>' + value.level4 + '<br>' +
								_SA_HSD +
								_SA_MFO +
								_SA_HSDBIO +
								_SA_IDO + '<br><br> <strong>PESAN GAGAL :</strong><br>' + err.message);
						}
					}
				});

				var total_pembangkit = merah + kuning + hijau;
				var total_depo = parseFloat((dep / dep) * 100)
				var persen_merah = parseFloat((merah / total_pembangkit) * 100).toFixed(2)
				var persen_kuning = parseFloat((kuning / total_pembangkit) * 100).toFixed(2)
				var persen_hijau = parseFloat((hijau / total_pembangkit) * 100).toFixed(2)
				var persen_biru = parseFloat((biru / total_pembangkit) * 100).toFixed(2)
				var persen_total = parseFloat((merah / total_pembangkit * 100) + (kuning / total_pembangkit * 100) + (hijau / total_pembangkit * 100));

				$('#merah').text('0')
				$('#kuning').text('0')
				$('#hijau').text('0')
				$('#biru').text('0')
				$('#dep').text('0')
				$('#persen_merah').text('0%')
				$('#persen_kuning').text('0%')
				$('#persen_hijau').text('0%')
				$('#persen_biru').text('0%')
				$('#total_pembangkit').text('0')
				$('#total_dep').text('0')
				$('#persen_total').text('0')

				$('#merah').text(merah)
				$('#kuning').text(kuning)
				$('#hijau').text(hijau)
				$('#biru').text(biru)
				$('#dep').text(dep)
				$('#persen_merah').text(persen_merah + "%")
				$('#persen_kuning').text(persen_kuning + "%")
				$('#persen_hijau').text(persen_hijau + "%")
				$('#persen_biru').text(persen_biru + "%")
				$('#total_pembangkit').text(total_pembangkit)
				$('#total_dep').text(total_depo + "%")
				$('#persen_total').text(persen_total + "%")
			}
		});

		map.panTo(new L.LatLng(-1.9205768, 118.5820232));
	}

	function seMarkerHapus() {
		try {
			map.removeLayer(_markers);
			_markers = '';
			_markerArray = [];
		} catch (e) {
			console.log("problem with seMarkerHapus " + e);
		}

	}

	function toRp(angka) {
		var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
		bilangan = bilangan.replace(".", ",");
		var isMinus = '';

		if (bilangan.indexOf('-') > -1) {
			bilangan = bilangan.replace("-", "");
			isMinus = '-';
		}
		var number_string = bilangan.toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

		if ((rupiah == '') || (rupiah == 0)) {
			rupiah = '0,00'
		}
		rupiah = isMinus + '' + rupiah;

		return rupiah;
	}

	function pesanGagal(vPesan) {
		var icon = 'icon-remove-sign';
		var color = '#ac193d;';
		var message = '';

		message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> Proses Gagal</div>';
		message += vPesan;

		bootbox.alert(message, function() {});
	}
</script>

<script type="text/javascript">
	function setDefaultLv1() {
		$('select[name="COCODE"]').empty();
		$('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
	}

	function setDefaultLv2() {
		$('select[name="PLANT"]').empty();
		$('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
	}

	function setDefaultLv3() {
		$('select[name="STORE_SLOC"]').empty();
		$('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
	}

	function setDefaultLv4() {
		$('select[name="SLOC"]').empty();
		$('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
	}

	$('select[name="ID_REGIONAL"]').on('change', function() {
		var stateID = $(this).val();
		var vlink_url = '<?php echo base_url() ?>dashboard/peta_jalur_ss/get_options_lv1/' + stateID;
		setDefaultLv1();
		setDefaultLv2();
		setDefaultLv3();
		setDefaultLv4();
		if (stateID) {
			bootbox.modal('<div class="loading-progress"></div>');
			$.ajax({
				url: vlink_url,
				type: "GET",
				dataType: "json",
				success: function(data) {
					$.each(data, function(key, value) {
						$('select[name="COCODE"]').append('<option value="' + value.COCODE + '">' + value.LEVEL1 + '</option>');
					});
					bootbox.hideAll();
				}
			});
		}
	});

	$('select[name="COCODE"]').on('change', function() {
		var stateID = $(this).val();
		var vlink_url = '<?php echo base_url() ?>dashboard/peta_jalur_ss/get_options_lv2/' + stateID;
		setDefaultLv2();
		setDefaultLv3();
		setDefaultLv4();
		if (stateID) {
			bootbox.modal('<div class="loading-progress"></div>');
			$.ajax({
				url: vlink_url,
				type: "GET",
				dataType: "json",
				success: function(data) {
					$.each(data, function(key, value) {
						$('select[name="PLANT"]').append('<option value="' + value.PLANT + '">' + value.LEVEL2 + '</option>');
					});
					bootbox.hideAll();
				}
			});
		}
	});

	$('select[name="PLANT"]').on('change', function() {
		var stateID = $(this).val();
		var vlink_url = '<?php echo base_url() ?>dashboard/peta_jalur_ss/get_options_lv4/' + stateID;
		setDefaultLv4();
		if (stateID) {
			bootbox.modal('<div class="loading-progress"></div>');
			$.ajax({
				url: vlink_url,
				type: "GET",
				dataType: "json",
				success: function(data) {
					$.each(data, function(key, value) {
						$('select[name="SLOC"]').append('<option value="' + value.SLOC + '">' + value.LEVEL4 + '</option>');
					});
					bootbox.hideAll();
				}
			});
		}
	});

	$('select[name="STORE_SLOC"]').on('change', function() {
		var stateID = $(this).val();
		var vlink_url = '<?php echo base_url() ?>laporan/persediaan_bbm/get_options_lv4/' + stateID;
		setDefaultLv4();
		if (stateID) {
			bootbox.modal('<div class="loading-progress"></div>');
			$.ajax({
				url: vlink_url,
				type: "GET",
				dataType: "json",
				success: function(data) {
					$.each(data, function(key, value) {
						$('select[name="SLOC"]').append('<option value="' + value.SLOC + '">' + value.LEVEL4 + '</option>');
					});
					bootbox.hideAll();
				}
			});
		}
	});
</script>