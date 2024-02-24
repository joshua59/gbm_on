<link href="<?php echo base_url(); ?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"> -->
<script src="<?php echo base_url(); ?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>


<style>
    #exampleModal {
        width: 100%;
        left: 0%;
        margin: 0 auto;
    }

    .detail-kosong {
        display: none;
    }

    .dataTables_filter {
        display: none;
    }

    .auto {
        width: 100%;
    }

    .period-hide {
        display: none;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    .dataTables_scrollHeadInner table {
        width: 100% !important;
    }
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Penerimaan BBM'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content clearfix">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <!-- Regional -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                    </div>
                </div>

                <!-- Level 1 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>

                <!-- Level 2 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>
                </div>
            </div><br />
            <div class="form_row">
                <!-- Level 3 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>

                <div class="pull-left span3">
                    <label for="password" class="control-label">Pembangkit<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <!-- jenis bahan bakar -->
                <!-- <div class="pull-left span3">
                    <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div> -->
            </div><br />
            <div class="form_row">
                <!-- Level 3 -->

                <div class="pull-left">
                    <!-- <label for="" class="control-label" style="margin-left:1px;">Tampil data</label>
                  <div class="controls">
                    <?php echo form_dropdown('tampilData', array(
                        '-Tampilkan Data-' => 'Tampilkan Data',
                        '25'              => '25 data',
                        '50'              => '50 data',
                        '100'             => '100 data',
                        '200'             => '200 data'
                    ), '', 'style="margin-left:1px;" id="tampilData"') ?>
                  </div> -->
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <!-- <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Unit"> -->
                        <?php echo form_dropdown('SLOC_CARI', $lv4_options_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="cariPembangkit" class="chosen span3"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                        <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>
                </div>

                <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                        <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                            'class' => 'btn',
                            'id'    => 'button-excel'
                        )); ?>
                        <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                            'class' => 'btn',
                            'id'    => 'button-pdf'
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="form_row">
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                        <!-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#exampleModal' name="button">TSest</button> -->
                        <?php echo anchor(null, "<i class='icon'></i> Detail", array(
                            'class'       => 'btn green detail-kosong',
                            'id'          => 'button-detail'
                            // 'data-toggle' => 'modal',
                            // 'data-target' => '#exampleModal'
                        )); ?>
                    </div>
                </div>
                <!-- Tampilan modal detail -->
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                        <!-- <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                                    'class' => 'btn',
                                    'id'    => 'button-excel'
                                )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?> -->
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <br>

        <div class="well-content no-search" id="divTable">
            <div class="table-responsive">
                <div id="table_pembangkit"></div>
            </div>
            
        </div>

    </div>
</div>
<br>

<form id="export_excel" action="<?php echo base_url('laporan/supply_bbm/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xlvl">
    <input type="hidden" name="xcari">

</form>
<form id="export_pdf" action="<?php echo base_url('laporan/supply_bbm/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="plvlid">
    <input type="hidden" name="plvl">
    <input type="hidden" name="pcari">
</form>


<script type="text/javascript">
    $('html, body').animate({
        scrollTop: $("#divTop").offset().top
    }, 1000);

    $(document).ready(function() {

        function setCekTgl() {
            var dateStart = $('#tglawal').val();
            var dateEnd = $('#tglakhir').val();

            if (dateEnd < dateStart) {
                $('#tglakhir').datepicker('update', dateStart);
            }
        }

    });

    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    function load_data() {

        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var cari = $('#cariPembangkit').val();

        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
            get_data(lvl0, vlevelid, cari)
        } else {
            if (lvl0 == '') {
                lvl0 = 'All';
                vlevelid = $('#lvl0').val();
                get_data(lvl0, vlevelid, "")
                // bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {}); 
            }
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
                if (vlevelid == "00") {
                    lvl0 = "Pusat";
                }
            }
            if (lvl1 !== "") {
                lvl0 = 'Level 1';
                vlevelid = $('#lvl1').val();
            }
            if (lvl2 !== "") {
                lvl0 = 'Level 2';
                vlevelid = $('#lvl2').val();
            }
            if (lvl3 !== "") {
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            get_data(lvl0, vlevelid, cari)
        }
    };


    function get_data(lvl0, vlevelid, cari) {


        $.ajax({
            type: "POST",
            url: "<?php echo base_url('laporan/supply_bbm/get_data'); ?>",
            data: {
                "vlevel": lvl0,
                "vlevelid": vlevelid,
                'cari': cari
            },
            beforeSend: function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error: function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {
                    bootbox.hideAll();
                });
            },
            success: function(data) {
                bootbox.hideAll();
                $('#table_pembangkit').html(data);
            }
        });
    }


    $('#button-load').click(function(e) {
        var lvl0 = $('#lvl0').val();
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            load_data()
        }
        
    });
    /**
     * check is numeric or not
     */

    //Untuk button tampilkan data


    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
                if (vlevelid == "00") {
                    lvl0 = "Pusat";
                }
            }
            if (lvl1 !== "") {
                lvl0 = 'Level 1';
                vlevelid = $('#lvl1').val();
            }
            if (lvl2 !== "") {
                lvl0 = 'Level 2';
                vlevelid = $('#lvl2').val();
            }
            if (lvl3 !== "") {
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }

            $('input[name="xlvl0"]').val($('#lvl0').val());
            $('input[name="xlvl1"]').val($('#lvl1').val());
            $('input[name="xlvl2"]').val($('#lvl2').val());
            $('input[name="xlvl3"]').val($('#lvl3').val());

            $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="xlvl4"]').val($('#lvl4').val()); // 183130
            // $('input[name="xbbm"]').val(bbm); // 001

            $('input[name="xlvlid"]').val(vlevelid);
            $('input[name="xlvl"]').val(lvl0);
            $('input[name="xcari"]').val($('#cariPembangkit').val());

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if (e) {
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
                if (vlevelid == "00") {
                    lvl0 = "Pusat";
                }
            }
            if (lvl1 !== "") {
                lvl0 = 'Level 1';
                vlevelid = $('#lvl1').val();
            }
            if (lvl2 !== "") {
                lvl0 = 'Level 2';
                vlevelid = $('#lvl2').val();
            }
            if (lvl3 !== "") {
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
            if (bbm !== "") {
                bbm = $('#bbm').val();
                if (bbm == '001') {
                    bbm = 'MFO';
                } else if (bbm == '002') {
                    bbm = 'IDO';
                } else if (bbm == '003') {
                    bbm = 'BIO';
                } else if (bbm == '004') {
                    bbm = 'HSD+BIO';
                } else if (bbm == '005') {
                    bbm = 'HSD';
                }
            }
            if (bbm == '') {
                bbm = '-';
            }

            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());
            $('input[name="pbbm"]').val(bbm);

            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="plvl"]').val(lvl0);
            $('input[name="pcari"]').val($('#cariPembangkit').val());
            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if (e) {
                    $('#export_pdf').submit();
                }
            });
        }
    });

    // Button excel dan pdf di modal
</script>

<script type="text/javascript">
    jQuery(function($) {
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
            $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
        }

        function disabledDetailButton() {
            $('#button-detail').removeClass('disabled');
            $('#button-detail').addClass('disabled');
        }

        $('select[name="ID_REGIONAL"]').on('change', function() {

            var stateID = $(this).val();
            // console.log(stateID);
            var vlink_url = '<?php echo base_url() ?>laporan/persediaan_bbm/get_options_lv1/' + stateID;
            disabledDetailButton();

            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if (stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="COCODE"]').append('<option value="' + value.COCODE + '">' + value.LEVEL1 + '</option>');
                        });
                    }
                });
            }
        });

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url() ?>laporan/persediaan_bbm/get_options_lv2/' + stateID;
            disabledDetailButton();

            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if (stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="PLANT"]').append('<option value="' + value.PLANT + '">' + value.LEVEL2 + '</option>');
                        });
                    }
                });
            }
        });

        $('select[name="PLANT"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url() ?>laporan/persediaan_bbm/get_options_lv3/' + stateID;
            disabledDetailButton();

            setDefaultLv3();
            setDefaultLv4();
            if (stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="STORE_SLOC"]').append('<option value="' + value.STORE_SLOC + '">' + value.LEVEL3 + '</option>');
                        });
                    }
                });
            }
        });

        $('select[name="STORE_SLOC"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url() ?>laporan/persediaan_bbm/get_options_lv4/' + stateID;
            disabledDetailButton();

            setDefaultLv4();
            if (stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="SLOC"]').append('<option value="' + value.SLOC + '">' + value.LEVEL4 + '</option>');
                        });
                    }
                });
            }
        });


    });
</script>