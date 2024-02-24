<link href="<?php echo base_url('assets/css/cf/jquery.dataTables.min.css');?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/cf/jquery.dataTables.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/cf/dataTables.fixedColumns.min.js');?>" type="text/javascript"></script>
<style>
    #chart {
        min-width: 200px;
        width: 97%;
        height: 400px;
    }
</style>
<div class="well">
    <div class="well-content clearfix">
        <?php echo form_open_multipart('', array('id' => 'filter')); ?>

            <button type="button" id="btn-collapse" class="btn btn-primary col-md-12" style="font-weight: bold;font-size: 16px">
                Fitur Pencarian
            </button>
            <br/>
            <div id="collapse" class="well-content" style="display: none;">
                <div class="form_row">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                        <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;" id="bln"'); ?>
                            <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;" id="thn"'); ?>
                        </div>
                    </div>

                    <br>
                    <div class="pull-left span3">
                        <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    </div>
                </div>
            </div>
            <br>

            <?php echo form_close(); ?>
    </div>

<form id="export_excel" action="<?php echo base_url('laporan/grafik_user/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4_nama">
    <input type="hidden" name="xbbm">
    <input type="hidden" name="xbbm_nama">
    <input type="hidden" name="xtgl">
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xCARI">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/grafik_user/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4_nama">
    <input type="hidden" name="pbbm">
    <input type="hidden" name="pbbm_nama">
    <input type="hidden" name="ptgl">
    <input type="hidden" name="pbln_nama">
    <input type="hidden" name="pthn">
    <input type="hidden" name="plvlid">
    <input type="hidden" name="pCARI">
</form>

<form id="export_csv" action="<?php echo base_url('laporan/grafik_user/generateXls'); ?>" method="post" target="_blank">
        <input type="hidden" name="clvl0">
        <input type="hidden" name="clvl1">
        <input type="hidden" name="clvl2">
        <input type="hidden" name="clvl3">
        <input type="hidden" name="clvl4">
        <input type="hidden" name="clvl0_nama">
        <input type="hidden" name="clvl1_nama">
        <input type="hidden" name="clvl2_nama">
        <input type="hidden" name="clvl3_nama">
        <input type="hidden" name="clvl4_nama">
        <input type="hidden" name="cbbm">
        <input type="hidden" name="cbbm_nama">
        <input type="hidden" name="ctgl">
        <input type="hidden" name="cbln_nama">
        <input type="hidden" name="cthn">
        <input type="hidden" name="clvlid">
        <input type="hidden" name="cCARI">
</form>

    <div class="well-content clearfix">
        <div id="chart">
        </div>
        <div id="divBawah">
            <div id="divTable" hidden>
                <div id="div_table"></div>
            </div>
        </div>
    </div>
</div>


<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth();
    var strMonth;
    var vJsonTable;

    month++;

    if (month < 10) {
        strMonth = '0' + month;
    } else {
        strMonth = month;
    }

    $('select[name="tahun"]').val(year);
    $('select[name="bulan"]').val(strMonth);

    getDataTable = function() {
        $('#divTable').show();
        $('html, body').animate({
            scrollTop: $("#divBawah").offset().top
        }, 1000);
    };

    var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

    btnGetDataTable.push({
        separator: true
    }, {
        text: "Lihat Data Tabel",
        onclick: getDataTable
    });

</script>

<script>

  $(document).ready(function() {

        var month = formatDate();
        var date = new Date();
        var year = date.getFullYear();
        $('#thn').val(year).trigger('change');
        // var t = $('#dataTable').DataTable({
        //     searching: false,
        //     bInfo: false,
        //     ordering:false
        // });

        // ajax(month, year);

        $('#button-filter').click(function() {

            var bulan = $('#bln').val();
            var tahun = $('#thn').val();

            if (bulan != '') {
                ajax(bulan, tahun);
            } else {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Bulan tidak boleh kosong ! --</div>', function() {});

            }
        })
    })

    function formatDate() {
        var d = new Date(),
            month = '' + (d.getMonth() + 1);

        if (month.length < 2) month = '0' + month;
        $('#bln').val(month).trigger('change');
        return month;
    }

    function ajax(bulan, tahun) {
        $('#divTable').hide();
        var nama_bulan = $('#bln option:selected').text();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('laporan/grafik_user/get_grafik'); ?>",
            data: {
                bln: bulan,
                thn: tahun
            },

            beforeSend: function() {
                bootbox.modal('<div class="loading-progress"></div>');
            },

            error: function() {
                bootbox.hideAll();
            },
            success: function(response) {
                bootbox.hideAll();

                var obj = JSON.parse(response);
                setGrafik(obj);
                setDataTable(bulan,tahun);
            }

        });
    }

    function setGrafik(obj) {
        var nama_bulan = $('#bln option:selected').text();
        Highcharts.chart('chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Penggunaan Aplikasi Per Bulan'
            },
            xAxis: {
                categories: [nama_bulan],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                pointFormatter: function() {
                    return this.series.name + ': ' + parseInt(this.y);
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        crop: false,
                        overflow: 'none'
                    }
                }
            },
            credits: {
                enabled: false,
            },
            series: obj
        });
    }
    // Change
    function setDataTable(bulan, tahun) {
        var userCounter = 1;
        var level = '<?php echo $this->session->userdata('level_user'); ?>'
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('laporan/grafik_user/get_table'); ?>",
            data: {
                bln: bulan,
                thn: tahun
            },

            beforeSend: function() {
                bootbox.modal('<div class="loading-progress"></div>');
            },

            error: function() {
                bootbox.hideAll();
            },
            success: function(response) {
                bootbox.hideAll();
                $('#div_table').html(response);                
            }

        });
    }

</script>

<script>
    jQuery(document).ready(function($) {
        $("#btn-collapse").click(function() {

            $("#collapse").slideToggle("slow");

            if ($("#btn-collapse").text() == "Pilih Pencarian") {
                $("#btn-collapse").text("Fitur Pencarian")
            } else {
                $("#btn-collapse").text("Pilih Pencarian")
            }

        });
    });
</script>
