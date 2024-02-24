<!DOCTYPE html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title><?php echo $app_parameter['nama_aplikasi'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php
        echo $css_header;
        echo $js_header;
        echo $favicon;
        ?>

        <script type="text/javascript">
            var $ = jQuery;
        </script>

        <script src="<?php echo base_url();?>assets/js/cf/jquery.pause.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/cf/jquery.marquee.js" type="text/javascript"></script>

        <style type="text/css">
        .marquee {
            width: 100%;
            overflow: hidden;
            padding: 10px 0 0 0;
            font-family: arial; 
            font-size: 12px; 
        }    
</style>
    </head>

    <body>
        <header class="blue"> <!-- Header start -->
            <a href="#" class="logo_image"><span class="hidden-480"></span></a>
            <ul class="header_actions pull-left hidden-480 hidden-768">
                <li rel="tooltip" data-placement="bottom" title="Hide/Show main navigation" ><a href="#" class="hide_navigation"><i class="icon-chevron-left"></i></a></li>
            </ul>
            <ul class="header_actions pull-left hidden-768">
                <li><a class="app_name"></a></li>
            </ul>
            <ul class="header_actions">

            <?php
                $roles = $this->session->userdata('roles_id');
                // kirim
                if (($roles=='08') || ($roles=='17') || ($roles=='28') || ($roles=='30') || ($roles=='32') || ($roles=='20')){
                    $notif_roles = '0';
                    $notif_roles_cls = '4';
                }

                //approve
                if (($roles=='13') || ($roles=='29') || ($roles=='13') || ($roles=='34')){
                    $notif_roles = '1';
                    $notif_roles_cls = '5';
                }                
            ?>                    
                <!-- <li rel="tooltip" data-placement="bottom" title="Notifikasi" class="messages"> -->
                <li id="nf_notif" style="display: none;" data-placement="bottom" title="Klik untuk detail notifikasi" class="messages">    
                    <a class="iconic" href="#"><i id="nf_icon" class="icon-bell" style="color:orange;"></i><nf id="nf_total" style="color:orange; font-weight: bold">2</nf></a>
                    <ul class="dropdown-menu pull-right messages_dropdown">
                        <li>
                            <div class="details">
                                <div class="name"><b><u><div id="nf_judul">Notifikasi</div></u></b></div>
                                <a href="<?php echo base_url() ?>data_transaksi/permintaan/notif/<?php echo $notif_roles;?>"><div id="nf_permintaan" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/penerimaan/notif/<?php echo $notif_roles;?>"><div id="nf_penerimaan" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/pemakaian/notif/<?php echo $notif_roles;?>"><div id="nf_pemakaian" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/stock_opname/notif/<?php echo $notif_roles;?>"><div id="nf_stock_opname" class="name"></div></a>
                                <?php if($this->session->userdata('roles_id') == 38 || $this->session->userdata('roles_id') == 30) { ?>
                                    <a href="<?php echo base_url() ?>data_transaksi/coq/notif">
                                        <div id="nf_coq_kirim" class="name"></div>
                                    </a>
                                <?php 
                                    } else if ($this->session->userdata('roles_id')==20) { ?>
                                        <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/0"><div id="nf_harga" class="name"></div></a>
                                        <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/9"><div id="nf_harga_koreksi" class="name"></div></a>
                                        <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/notif/0"><div id="nf_harga_nr" class="name"></div></a>
                                <?php
                                    } else if ($this->session->userdata('roles_id')==34) { ?>
                                        <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/1"><div id="nf_harga" class="name"></div></a>
                                        <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/10"><div id="nf_harga_koreksi" class="name"></div></a>
                                <?php } ?>
                                
                                <a href="<?php echo base_url() ?>data_transaksi/permintaan/notif/<?php echo $notif_roles_cls;?>"><div id="nf_permintaan_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/penerimaan/notif/<?php echo $notif_roles_cls;?>"><div id="nf_penerimaan_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/pemakaian/notif/<?php echo $notif_roles_cls;?>"><div id="nf_pemakaian_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/stock_opname/notif/<?php echo $notif_roles_cls;?>"><div id="nf_stock_opname_c" class="name"></div></a>

                                <div id="line"></div>

                                <div id="koreksi" hidden>
                                    <div class="name">
                                        <b><u><div id="nf_judul_koreksi">Notifikasi Untuk Dikoreksi</div></u></b>
                                    </div>
                                    <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/8">
                                        <div id="nf_koreksi" class="name"></div>
                                    </a>
                                    <!-- <br> -->
                                </div>

                                <div id="coq" hidden>
                                    <div class="name">
                                        <b><u><div id="nf_judul_coq">Notifikasi Belum Review</div></u></b>
                                    </div>
                                    <a href="<?php echo base_url() ?>data_transaksi/verifikasi_coq/notif">
                                        <div id="nf_coq" class="name"></div>
                                    </a>
                                </div>

                                <div id="line_tolak"></div>
                                <div id="tolak" hidden>
                                    <div class="name">
                                        <b><u><div id="nf_judul_tolak">Notifikasi Data Ditolak</div></u></b>
                                    </div>
                                    <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/3">
                                        <div id="nf_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga/notif/12">
                                        <div id="nf_tolak_koreksi" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/notif/3">
                                        <div id="nf_tolak_nr" class="name"></div>
                                    </a>

                                    <a href="<?php echo base_url() ?>data_transaksi/permintaan/notif/3">
                                        <div id="nf_permintaan_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/penerimaan/notif/3">
                                        <div id="nf_penerimaan_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/pemakaian/notif/3">
                                        <div id="nf_pemakaian_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/stock_opname/notif/3">
                                        <div id="nf_stock_opname_tolak" class="name"></div>
                                    </a>

                                    <a href="<?php echo base_url() ?>data_transaksi/permintaan/notif/7">
                                        <div id="nf_permintaan_c_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/penerimaan/notif/7">
                                        <div id="nf_penerimaan_c_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/pemakaian/notif/7">
                                        <div id="nf_pemakaian_c_tolak" class="name"></div>
                                    </a>
                                    <a href="<?php echo base_url() ?>data_transaksi/stock_opname/notif/7">
                                        <div id="nf_stock_opname_c_tolak" class="name"></div>
                                    </a>                                    
                                    
                                </div>

                                <!-- <div class="name">aaa</div>                                    
                                <div class="message">
                                    Lorem ipsum Commodo quis nisi...
                                </div> -->
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" style="min-width: 150px;display: block;">
                        <span style="float: left;"> <?php echo $this->session->userdata('user_name'); ?></span> 
                        <span style="float: right"><i style="padding-left: 20px;"></i> <i class="icon-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url() ?>user_management/user/profil"><i class="icon-user"></i> User Profil</a></li>
                        
                        <li><a href="<?php echo base_url() ?>user_management/user/ganti_password"><i class="icon-key"></i> Ganti Password</a></li>
                        <li><a href="<?php echo base_url() ?>dashboard/bantuan"><i class="icon-info-sign"></i> Bantuan</a></li>
                        <li><a href="javascript:void(0);" id="btn_berita"><i class="icon-bullhorn"></i> <in id="in_berita">Hide Berita</in></a></li>
                        <li><a href="<?php echo base_url() ?>login/stop"><i class="icon-signout"></i> Logout</a></li>
                    </ul>
                </li>
                <li rel="tooltip" data-placement="bottom" title="Waktu Sekarang" class="messages hidden-480 hidden-768">
                    <a href="javascript:void(0);">
                        <i class="icon-time"></i>
                        <span id="date_time"></span>
                    </a>
                    <script type="text/javascript">window.onload = date_time('date_time');</script>
                </li>
                <li data-placement="bottom" title="Waktu Sekarang" style="display: none;" class="messages show-480 show-767">
                    <a href="javascript:void(0);"><i class="icon-time"></i></a>
                    <ul class="dropdown-menu pull-right messages_dropdown">
                        <li>
                            <a href="#">
                                <div class="details">
                                    <div class="message">
                                        <span id="date_time2"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <script type="text/javascript">window.onload = date_time('date_time2');</script>
                </li>
                <li class="responsive_menu"><a class="iconic" href="#"><i class="icon-reorder"></i></a></li>
            </ul>
        </header>

        <div id="main_navigation" class="blue"> <!-- Main navigation start -->
            <div class="inner_navigation">
                <?php echo $main_menu; ?>
            </div>
        </div>  

        <div id="content" <?php echo isset($sidebar_content)? "class='sidebar'" :"";?>> 
            <?php isset($page_content) ? $this->load->view($page_content) : 'Silahkan set $data["page_content"] = ""; '; ?>
        </div>
        <footer id="fberita">
            <!-- <span class="hidden-480">&copy; ICON+</span> -->
            <div class='marquee' id='div_berita'></div>
        </footer>
    </body>
</html>

<script type="text/javascript">
    // get_berita();

    function get_berita() {
        $.post("<?php echo base_url()?>dashboard/get_berita/", function (data) {
            var get_data = (JSON.parse(data));
            
            $('#div_berita').html(get_data);

            $(function () {
                $('.marquee').marquee({
                    duration: 25000,
                    pauseOnHover: true,
                    // duplicated: true
                });
            });
            
        });
    }

    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    function get_notif_kirim(vjenis) {
        var data = {jenis: vjenis};

        $.post("<?php echo base_url()?>template/template/get_notif_kirim/", data, function (data) {
            var get_data = (JSON.parse(data));

            for (i = 0; i < get_data.length; i++) {
                var TOTAL = get_data[i].TOTAL; 
                var PERMINTAAN = get_data[i].PERMINTAAN; 
                var PEMAKAIAN  = get_data[i].PEMAKAIAN; 
                var PENERIMAAN = get_data[i].PENERIMAAN; 
                var STOCK_OPNAME = get_data[i].STOCK_OPNAME; 
                var PERMINTAAN_CLOSING = get_data[i].PERMINTAAN_CLOSING; 
                var PEMAKAIAN_CLOSING  = get_data[i].PEMAKAIAN_CLOSING; 
                var PENERIMAAN_CLOSING = get_data[i].PENERIMAAN_CLOSING; 
                var STOCK_OPNAME_CLOSING = get_data[i].STOCK_OPNAME_CLOSING;
                var HITUNG_HARGA = get_data[i].HITUNG_HARGA;
                var KOREKSI = get_data[i].KOREKSI;
                var HITUNG_HARGA_KOREKSI = get_data[i].HITUNG_HARGA_KOREKSI; 
                var TOLAK_HARGA = get_data[i].TOLAK_HARGA; 
                var TOLAK_HARGA_KOREKSI = get_data[i].TOLAK_HARGA_KOREKSI;
                var TOLAK_HARGA_NON_REGULER = get_data[i].TOLAK_HARGA_NON_REGULER; 
                var HITUNG_HARGA_NON_REGULER = get_data[i].HITUNG_HARGA_NON_REGULER;

                var PERMINTAAN_TOLAK = get_data[i].PERMINTAAN_TOLAK;
                var PEMAKAIAN_TOLAK = get_data[i].PEMAKAIAN_TOLAK;
                var PENERIMAAN_TOLAK = get_data[i].PENERIMAAN_TOLAK;
                var STOCK_OPNAME_TOLAK = get_data[i].STOCK_OPNAME_TOLAK; 

                var PERMINTAAN_CLOSING_TOLAK = get_data[i].PERMINTAAN_CLOSING_TOLAK;
                var PEMAKAIAN_CLOSING_TOLAK = get_data[i].PEMAKAIAN_CLOSING_TOLAK;
                var PENERIMAAN_CLOSING_TOLAK = get_data[i].PENERIMAAN_CLOSING_TOLAK;
                var STOCK_OPNAME_CLOSING_TOLAK = get_data[i].STOCK_OPNAME_CLOSING_TOLAK;
                var COQ = get_data[i].COQ;
            }

            
            if (TOTAL > 0) {
                $('#nf_judul').html('Notifikasi Belum '+vjenis);
                $('#nf_total').html(formatNumber(TOTAL));
                if (PERMINTAAN>0){$('#nf_permintaan').html('Data Permintaan : '+formatNumber(PERMINTAAN));}
                if (PEMAKAIAN>0){$('#nf_pemakaian').html('Data Pemakaian : '+formatNumber(PEMAKAIAN));}
                if (PENERIMAAN>0){$('#nf_penerimaan').html('Data Penerimaan : '+formatNumber(PENERIMAAN));}
                if (STOCK_OPNAME>0){$('#nf_stock_opname').html('Stock Opname : '+formatNumber(STOCK_OPNAME));}
                if (HITUNG_HARGA>0){$('#nf_harga').html('Perhitungan Harga : '+formatNumber(HITUNG_HARGA));}
                if (HITUNG_HARGA_NON_REGULER>0){$('#nf_harga_nr').html('Perhitungan Harga NR : '+formatNumber(HITUNG_HARGA_NON_REGULER));}

                if (HITUNG_HARGA_KOREKSI>0){$('#nf_harga_koreksi').html('Perhitungan Harga Koreksi : '+formatNumber(HITUNG_HARGA_KOREKSI));}

                if (COQ > 0){$('#nf_coq_kirim').html('COQ : '+formatNumber(COQ));}
                
                var vLine = 1;
                if ((PERMINTAAN==0) && (PEMAKAIAN==0) && (PENERIMAAN==0) && (STOCK_OPNAME==0 &&(HITUNG_HARGA==0) && (HITUNG_HARGA_KOREKSI==0) && (HITUNG_HARGA_NON_REGULER==0) && (COQ==0))){
                    $('#nf_judul').html('');
                    vLine = 0;
                    
                }

                if (KOREKSI>0){
                    if (vLine){
                        // $('#line').html('<br>');  
                    }
                    $('#nf_koreksi').html('Perhitungan Harga : '+formatNumber(KOREKSI));
                    $('#koreksi').show();
                }   

                var vRoles = "<?php echo $this->session->userdata('roles_id'); ?>";

                if(vRoles == 20) {
                    if (COQ > 0){
                        $('#nf_coq').html('Verifikasi COQ : '+formatNumber(COQ));
                        $('#coq').show();
                    }  
                }

                // if(vRoles == 34) {
                //     if ((PERMINTAAN==0) && (PEMAKAIAN==0) && (PENERIMAAN==0) && (STOCK_OPNAME==0 &&(HITUNG_HARGA==0) && (HITUNG_HARGA_KOREKSI==0) && (HITUNG_HARGA_NON_REGULER==0) && (COQ > 0))){
                //     $('#nf_judul').html('');
                //     vLine = 1;
                //     $('#nf_coq').html('Verifikasi COQ : '+formatNumber(COQ));
                //     $('#coq').show();
                    
                //     }
                // }  

                if(vRoles == 34) {
                    if(COQ > 0) {
                        if ((PERMINTAAN==0) && (PEMAKAIAN==0) && (PENERIMAAN==0) && (STOCK_OPNAME==0 &&(HITUNG_HARGA==0) && (HITUNG_HARGA_KOREKSI==0) && (HITUNG_HARGA_NON_REGULER==0))){
                            $('#nf_judul').html('');
                            vLine = 1;
                            $('#nf_coq').html('Verifikasi COQ : '+formatNumber(COQ));
                            $('#coq').show();
                        } else {
                            vLine = 1;
                            $('#nf_coq').html('Verifikasi COQ : '+formatNumber(COQ));
                            $('#coq').show();
                        }

                    }                    
                }    
                                       

                // if (vjenis=='Kirim'){
                    if (PERMINTAAN_CLOSING>0){$('#nf_permintaan_c').html('Data Permintaan Closing : '+formatNumber(PERMINTAAN_CLOSING));}
                    if (PEMAKAIAN_CLOSING>0){$('#nf_pemakaian_c').html('Data Pemakaian Closing : '+formatNumber(PEMAKAIAN_CLOSING));}
                    if (PENERIMAAN_CLOSING>0){$('#nf_penerimaan_c').html('Data Penerimaan Closing : '+formatNumber(PENERIMAAN_CLOSING));}
                    if (STOCK_OPNAME_CLOSING>0){$('#nf_stock_opname_c').html('Stock Opname Closing : '+formatNumber(STOCK_OPNAME_CLOSING));} 

                // }

                if ((TOLAK_HARGA>0) || (TOLAK_HARGA_NON_REGULER>0) || (TOLAK_HARGA_KOREKSI>0) || (PERMINTAAN_TOLAK>0) || (PENERIMAAN_TOLAK>0) || (PEMAKAIAN_TOLAK>0) || (STOCK_OPNAME_TOLAK>0)){

                    if (TOLAK_HARGA>0){$('#nf_tolak').html('Perhitungan Harga : '+formatNumber(TOLAK_HARGA));}
                    if (TOLAK_HARGA_KOREKSI>0){$('#nf_tolak_koreksi').html('Perhitungan Harga Koreksi : '+formatNumber(TOLAK_HARGA_KOREKSI));}
                    if (TOLAK_HARGA_NON_REGULER>0){$('#nf_tolak_nr').html('Perhitungan Harga NR : '+formatNumber(TOLAK_HARGA_NON_REGULER));}

                    if (PERMINTAAN_TOLAK>0){$('#nf_permintaan_tolak').html('Tolak Permintaan : '+formatNumber(PERMINTAAN_TOLAK));}
                    if (PENERIMAAN_TOLAK>0){$('#nf_penerimaan_tolak').html('Tolak Penerimaan : '+formatNumber(PENERIMAAN_TOLAK));}
                    if (PEMAKAIAN_TOLAK>0){$('#nf_pemakaian_tolak').html('Tolak Pemakaian : '+formatNumber(PEMAKAIAN_TOLAK));}
                    if (STOCK_OPNAME_TOLAK>0){$('#nf_stock_opname_tolak').html('Tolak Stock Opname : '+formatNumber(STOCK_OPNAME_TOLAK));}

                    if (PERMINTAAN_CLOSING_TOLAK>0){$('#nf_permintaan_c_tolak').html('Tolak Permintaan Closing : '+formatNumber(PERMINTAAN_CLOSING_TOLAK));}
                    if (PENERIMAAN_CLOSING_TOLAK>0){$('#nf_penerimaan_c_tolak').html('Tolak Penerimaan Closing : '+formatNumber(PENERIMAAN_CLOSING_TOLAK));}
                    if (PEMAKAIAN_CLOSING_TOLAK>0){$('#nf_pemakaian_c_tolak').html('Tolak Pemakaian Closing : '+formatNumber(PEMAKAIAN_CLOSING_TOLAK));}
                    if (STOCK_OPNAME_CLOSING_TOLAK>0){$('#nf_stock_opname_c_tolak').html('Tolak Stock Opname Closing : '+formatNumber(STOCK_OPNAME_CLOSING_TOLAK));}

                    $('#tolak').show();
                }

                $('#nf_notif').show();

                // setNotif();
                // setInterval(setNotif, 5000);
            }
        });
    }

    cek_notif();
    function cek_notif(){
        $('#nf_notif').hide();
        var vRoles = "<?php echo $this->session->userdata('roles_id'); ?>";

        //kirim
        if ((vRoles=='08') || (vRoles=='17') || (vRoles=='28') || (vRoles=='30') || (vRoles=='32') || (vRoles=='20') || (vRoles=='38')){
            get_notif_kirim('Kirim');
        }

        //approve
        if ((vRoles=='13') || (vRoles=='29') || (vRoles=='13') || (vRoles=='34') || (vRoles == 20)){
            get_notif_kirim('Approve');
            if(vRoles == 20) {
                $('#nf_judul').hide();
            }
                   
        }
    }

    function setNotif() {
      // setTimeout(function () {
      //     $('#nf_total').hide();
      //   }, 1000);
      // setTimeout(function () {
      //     $('#nf_total').show();
      //   }, 2000);
      setTimeout(function () {
          $('#nf_total').hide();
        }, 3000);
      setTimeout(function () {
          $('#nf_total').show();
        }, 4000);
    }

    var in_berita = "<?php echo $this->session->userdata('in_berita'); ?>";
    $('#in_berita').html(in_berita);

    if ($('#in_berita').html()=='Hide Berita'){
        $('#fberita').show();
        get_berita();
    } else {
        $('#fberita').hide();  
    }
    
    $('#btn_berita').click(function(e) {
        bootbox.confirm('Apakah yakin akan '+$('#in_berita').html()+' ?', "Tidak", "Ya", function(e) {
            if(e){
                if ($('#in_berita').html()=='Hide Berita'){
                    $('#fberita').hide();
                    $('#in_berita').html('Show Berita');
                } else {
                    $('#fberita').show();
                    $('#in_berita').html('Hide Berita');
                    get_berita();
                    
                }
                var url = "<?php echo base_url() ?>template/template/sess";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "in_berita="+$('#in_berita').html(),
                    dataType:"json",
                    success: function (data) {
                        // alert(data);
                    }
                });
            }
        });
    });

</script>
