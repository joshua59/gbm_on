<style type="text/css">
  #exampleModal{
      width: 100%;
      left: 0%;
      margin: 0 auto;
    }
</style>
<?php
echo form_open_multipart($form_action, array('id' => 'frm-add'));
?>
  <button type="submit" class="btn btn-default pull-right">Kirim</button>
    <table class="display" id="dataTable" style="width: auto">
      <thead>
        <tr>
          <th>No</th>
          <th>Report Number</th>
          <th>Tanggal COQ</th>
          <th>Jenis / Komponen <br>BBM</th>
          <th>Pemasok</th>
          <th>Depo</th>
          <th>Shore Tank</th>
          <th>Jumlah Pembangkit</th>
          <th>Hasil</th>
          <th>File</th>
          <th>Created By</th>
          <th>Created Date</th>
          <th>Status Review</th>
          <th>Aksi</th>
          <th><input type="checkbox" id="check_all"></th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($list as $value) { 

        $REPORT = $value['NO_REPORT']; ?>

          <tr>
            <td style="text-align: center"><?php echo $no ?></td>
            <td style="text-align: center"><?php echo $value['NO_REPORT'] ?></td>
            <td style="text-align: center"><?php echo $value['TGL_COQ'] ?></td>
            <td style="text-align: center"><?php echo $value['NAMA_BBM'] ?></td>
            <td style="text-align: center"><?php echo $value['NAMA_PEMASOK'] ?></td>
            <td style="text-align: center"><?php echo $value['NAMA_DEPO'] ?></td>
            <td style="text-align: center"><?php echo $value['SHORE_TANK'] ?></td>
            <td style="text-align: center"><?php echo $value['TOTAL']." Pembangkit"?></a></td>
            <td style="text-align: center"><button type="button" class="btn btn-default" onclick="get_pembangkit_by_trxid('<?php echo $value['NO_REPORT'] ?>','<?php echo $value['SHORE_TANK'] ?>','<?php echo $value['ID_TRANS'] ?>')">VIEW</button></td>
            <td style="text-align: center">
              <?php  
                if ($this->laccess->is_prod()){ ?>
                  <div class="controls" id="dokumen">
                      <button type="button" onclick="download_doc('<?php echo $url_getfile;?>','<?php echo !empty($value['PATH_DOC']) ? $value['PATH_DOC'] : '';?>','KONTRAKTRANSPORTIR')"><i class="icon-download"></i></button>
                  </div> 
              <?php } else { ?>
                  <div class="controls" id="dokumen">
                    <button type="button" class="btn btn-default" onclick="window.open('<?php echo base_url()?>assets/upload/kontrak_transportir/<?php echo $value['PATH_DOC'] ?>')"><i class='icon-download'></i></button>
                  </div>
              <?php } ?>
            </td>
            <td style="text-align: center"><?php echo $value['CD_BY'] ?></td>
            <td style="text-align: center"><?php echo $value['CD_DATE'] ?></td>
            <td style="text-align: center"><?php echo $value['STATS'] ?></td>
            <td style="text-align: center">
              <?php if($value['STATUS_REVIEW'] == 1 || $value['STATUS_REVIEW'] == 2) { ?>
                <?php if($value['CD_BY'] == $this->session->userdata('user_name')) { ?>
                  <a href="#" class="btn transparant" onclick="edit('<?php echo $value['ID_TRANS'] ?>')"><i class="icon-edit"></i></a>
                  <a href="#" class="btn transparant" onclick="hapus('<?php echo $value['ID_TRANS'] ?>')"><i class="icon-trash"></i></a>
                <?php } ?>
              <?php } ?>
            </td>
            <td style="text-align: center">
            <?php if($value['STATUS_REVIEW'] == 1 || $value['STATUS_REVIEW'] == 2) { ?>
                <?php if($value['CD_BY'] == $this->session->userdata('user_name')) { ?>
                  <input type="checkbox" name="checkbox[]" value="<?php echo $value['ID_TRANS'] ?>">
                <?php } ?>
            <?php } ?>
            </td>
            
          </tr>
          
        <?php $no++;} ?>
      </tbody>
    </table>
<?php echo form_close(); ?>
  
  <div id="form-content" class="modal fade modal-xlarge"></div>
  <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>             
        <div class="modal-body">
          <div id="modal_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function() {
   
    var t = $('#dataTable').DataTable({
        "scrollY": "450px",
        "searching": false,
        "scrollX": true,
        "scrollCollapse": false,
        "bPaginate": true,
        fixedHeader: {
          header: true,
          footer: true
        },
        "ordering" : true,
        "bLengthChange": true,
        "bSearch" :true,
        "bFilter": false,
        "bInfo": true,
        "ordering" :false,
        "bAutoWidth": true,
        "fixedHeader": true,
        "language": {
          "decimal": ",",
          "thousands": ".",
          "emptyTable": "Tidak ada data untuk ditampilkan",
          "info": "Total Data: _MAX_",
          "infoEmpty": "Total Data: 0",
          "lengthMenu": "Jumlah Data _MENU_"
        },
        "columnDefs": [
            {
                "className": "dt-left",
                "targets": [1,4,5,6,7]
            },
            {
              "className" : "dt-center",
              "targets" : [0,2,3,10,11,12,13]
            },
            
          ]
    });

    $('#check_all').attr('checked', false);

    $("#check_all").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });
  });

  $("#frm-add").validate({    
    submitHandler: function(form) {
      bootbox.confirm('Anda yakin akan mengirim data ?', "Tidak", "Ya", function(e) {
        if(e){
          var data = new FormData(form);
          $.ajax({
            type: 'POST',
            url: $("#frm-add").attr('action'),
            data: data,
            contentType: false,
            processData: false,
            beforeSend:function(data){
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error: function(data) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div>', function() {});
                bootbox.hideAll();
            },
            success: function(data) {
              var obj = JSON.parse(data)
              if(obj[0] == true) {
                bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>&nbsp'+obj[2]+'</div>', function() {
                    load_table();
                    if (typeof cek_notif !== 'undefined' && $.isFunction(cek_notif)) {
                      cek_notif();
                    }
                });
              } else {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div><div>'+obj[2]+'</div>', function() {
                    bootbox.hideAll();
                });
              }
            }
          })
        }
      });
      
      return false;
    }
  });

  function get_pembangkit_by_trxid(no_report,shore_tank,id) {

    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#ID_JNS_BHN_BKR').val(); //bahanBakar dropdown
    var cari = $('#kata_kunci').val();
    var tanggal_coq = $('#tanggal_coq').val();
    
    if (lvl0=='') {
        lvl0 = 'All';
        vlevelid = $('#lvl0').val();
    }
    else {
      if (lvl0 == '') {
        lvl0 = 'All';
        vlevelid = $('#lvl0').val();

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
      if (lvl3 !== ""){
        lvl0 = 'Level 3';
        vlevelid = $('#lvl3').val();
      }
      if (lvl4 !== "") {
        lvl0 = 'Level 4';
        vlevelid = $('#lvl4').val();
      }
    }  
    var vlink_url = '<?php echo base_url()?>data_transaksi/coq/get_pembangkit_by_trxid';
    $.ajax({
      url: vlink_url,
      data : {
        id       : id,
        p_level  : lvl0,
        p_unit   : vlevelid,
        p_jnsbbm : bbm,
        p_tgl    : tanggal_coq,
        p_cari   : cari
      },
      type: "POST",
      beforeSend:function(data) {
          bootbox.modal('<div class="loading-progress"></div>');
      },
      error:function(data) {
          bootbox.hideAll();
          alert('Data Gagal Proses');
      },
      success:function(data) {
        $('#no_report').text(no_report);
        $('#shore_tank').text(shore_tank);
        $('#exampleModal').modal('show');
        $('#modal_content').html(data);
        bootbox.hideAll();
      }
    });
  }

  function hapus(id_trx) {
    var link = '<?php echo base_url()?>data_transaksi/coq/delete/'
    bootbox.confirm('Apakah yakin akan menghapus data ?', "Tidak", "Ya", function(e) {
      if(e) {
        $.ajax({
          url: link,
          type: "POST",
          data: {
            id : id_trx
          },
          error: function (xhr, ajaxOptions, thrownError) {
            
          },
          success: function (data) {
            var obj = JSON.parse(data);
            if(obj[0] == 1) {
              bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>'+obj[2]+'</div>', function() {load_table();});
              

            } else {
              bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>'+obj[2]+'</div>', function() {});
            }
          }
          
        });
      }
    }); 
  }

  function edit(id_trx) {
    $('#con').hide();
    var link = '<?php echo base_url()?>data_transaksi/coq/edit/'
    $.ajax({
      url: link,
      type: "POST",
      data: {
        id : id_trx
      },
       beforeSend:function(data) {
        bootbox.modal('<div class="loading-progress"></div>');
      },
      error: function (xhr, ajaxOptions, thrownError) {
        bootbox.hideAll();
      },
      success: function (data) {
        $('#content_data').html(data);
        bootbox.hideAll();
      }
      
    });
  }

  function download_doc(url,filename,modul){

    var vfolder = '';
    switch (modul) {
        case 'KONTRAKTRANSPORTIR': vfolder = 'kontrak_transportir'; break;
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
        } else {
                  bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --File Tidak ditemukan-- </div>', function() {});  
        }
        // preventDefault(); 
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --File Tidak ditemukan-- </div>', function() {});  
      }
    });
       
  }

</script>
