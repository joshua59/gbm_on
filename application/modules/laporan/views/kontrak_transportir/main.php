<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    tr {background-color: #CED8F6;}
    table {
        border-collapse: collapse;
        width:100%;
    }
    td.tengah {text-align: center;}
    td.kanan {text-align: right;}

    .label_ket {
    font-size: 10px;
    }

    .cls_modal{
      width: 90%;
      height: 700px;
      left: 5%;
      margin: auto;
      /*left: 0%;
      margin: 0 auto;*/
    }    
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <button class="btn btn-default" id="btn-awal">Kontrak Awal</button>
            <button class="btn btn-default" id="btn-adendum">Kontrak Adendum</button>
        </div>
        <br>
        <div id="content_table">
        </div>
        <br>
    </div>
</div>

<script type="text/javascript">
   
    $(document).ready(function() {

        $('#btn-awal').click(function(){
            loadKontrakAwal();
        });

        $('#btn-adendum').click(function(){
            loadKontrakAdendum();
        });

    })

    function loadKontrakAwal() {

        var vlink_url = '<?php echo base_url() ?>laporan/kontrak_transportir/loadKontrakAwal'
        $.ajax({
            url: vlink_url,
            type: "POST", 
            data : '',    
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>Proses gagal ! </div>', function() {});
            }, 
            success:function(data) {
                $('#content_table').html(data);
                bootbox.hideAll();
            }
        });
    }

    function loadKontrakAdendum() {
        var vlink_url = '<?php echo base_url() ?>laporan/kontrak_transportir/loadKontrakAkhir'
        $.ajax({
            url: vlink_url,
            type: "POST", 
            data : '',    
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>Proses gagal ! </div>', function() {});
            }, 
            success:function(data) {
                $('#content_table').html(data);
                bootbox.hideAll();
            }
        });
    }

    function setCekTgl(){
        var dateStart = $('#tglawal').val();
        var dateEnd = $('#tglakhir').val();

        if (dateEnd < dateStart){
            $('#tglakhir').datepicker('update', dateStart);
        }
    }

    function convertToRupiah(angka){
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


</script>

