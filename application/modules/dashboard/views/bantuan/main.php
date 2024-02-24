<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

<link href="<?php echo base_url();?>assets/css/cf/font-awesome.min.css" rel="stylesheet" type="text/css" />

<style>
    .accordion {
        background-color: #ddd;
        color: #444;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 13px;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel_acc {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        /*font-size: 13px;*/
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
            <div class="span6">
                <div class="well-content no-search">
                    <div class="well">

                            <div class="row">
                                <div class="col-lg-3 col-md-6" id="pnl_1"><br>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" style="background-color:#28a745">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-laptop fa-4x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divBio">

                                                    </div>
                                                    <div><h4>GBMO</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                         <a onclick="setPilihPanel('pnl_1');" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#28a745">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6" id="pnl_2"><br>
                                    <div class="panel panel-success">
                                        <div class="panel-heading" style="background-color:#dc3545">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-book fa-4x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divHsdBio">
													</div>
                                                    <div><h4>Manual Book</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                       <a onclick="setPilihPanel('pnl_2');" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#dc3545">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
								 <div class="col-lg-3 col-md-6" id="pnl_3"><br>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style="background-color:#04B4AE">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-info-circle fa-4x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divIdo">

                                                   </div>
                                                    <div><h4>SOP</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                          <a onclick="setPilihPanel('pnl_3');" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#04B4AE">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6" id="pnl_4"><br>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" style="background-color:#ffc107">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-comments fa-4x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divMfo">

                                                    </div>
                                                    <div><h4>FAQ</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                         <a onclick="setPilihPanel('pnl_4');" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#ffc107">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- /.row -->
                        <!-- </div>  --><!-- end pull left -->
                    </div>
                    <div class="well">
                        <div class="row-fluid" id="div_pnl_1" hidden>
                            <h4>GBMO</h4>
                            <p>
&nbsp; &nbsp; &nbsp; &nbsp; Aplikasi Gas dan Bahan Bakar Minyak (GBM) Online adalah Aplikasi yang mengakomodir pencatatan transaksi dan laporan persediaan Bahan Bakar Minyak dan Gas pada Pembangkit PT. PLN (Persero) yang dibangun oleh PT Indonesia Comnets Plus.<br>
Latar belakang terciptanya aplikasi GBM Online ini untuk memenuhi kebutuhan PT PLN (Persero) terhadap monitoring bahan bakar minyak yang dimiliki untuk operasional pembangkit listrik seluruh Indonesia.<br>
Adapun proses yang dapat dilakukan pada aplikasi ini meliputi transaksi.

<ol>
  <li>Nominasi (Permintaan)</li>
  <li>Mutasi Penerimaan</li>
  <li>Mutasi Pemakaian</li>
  <li>Stock Opname</li>
  <li>Data Tangki</li>
  <li>Kontrak Transportir</li>
  <li>Laporan -  Laporan</li>
  <li>Grafik</li>
</ol> 

&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dengan adanya aplikasi GBM Online, diharapkan dapat membantu seluruh proses operasional yang ada pada PT PLN (Persero) dalam hal monitoring persediaan bahan bakar minyak.
<br><br>
Terima Kasih.   
</p>
<br>

Download Materi Kickoff Aplikasi GBM Online&nbsp;
    <!-- dokumen -->
    <?php  
        if ($this->laccess->is_prod()){ ?>
            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_KICKOFF) ? $default->PATH_KICKOFF : '';?>"><i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } else { ?>
            <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_KICKOFF;?>" target="_blank">
                                <i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } ?>
    <!-- end dokumen -->
<br>
Download Materi Pelatihan Aplikasi GBM Online&nbsp;
    <!-- dokumen -->
    <?php  
        if ($this->laccess->is_prod()){ ?>
            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_PELATIHAN) ? $default->PATH_PELATIHAN : '';?>"><i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } else { ?>
            <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_PELATIHAN;?>" target="_blank">
                                <i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } ?>
    <!-- end dokumen -->
<br>
Download Template Data Cutoff, List Unit dan User&nbsp;
    <!-- dokumen -->
    <?php  
        if ($this->laccess->is_prod()){ ?>
            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_CUTOFF) ? $default->PATH_CUTOFF : '';?>"><i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } else { ?>
            <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_CUTOFF;?>" target="_blank">
                                <i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } ?>
    <!-- end dokumen -->

                        </div>
                        <div class="row-fluid" id="div_pnl_2" hidden>
                            <h4>Manual Book</h4>
                            Download Manual Book Aplikasi GBM Online&nbsp;
    <!-- dokumen -->
    <?php  
        if ($this->laccess->is_prod()){ ?>
            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_MANUAL_BOOK) ? $default->PATH_MANUAL_BOOK : '';?>"><i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } else { ?>
            <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_MANUAL_BOOK;?>" target="_blank">
                                <i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } ?>
    <!-- end dokumen -->
                        </div>
                        <div class="row-fluid" id="div_pnl_3" hidden>
                            <h4>SOP</h4>
                            Download SOP Aplikasi GBM Online&nbsp;
    <!-- dokumen -->
    <?php  
        if ($this->laccess->is_prod()){ ?>
            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_SOP) ? $default->PATH_SOP : '';?>"><i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } else { ?>
            <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_SOP;?>" target="_blank">
                                <i class="fa fa-download" style="font-size:18px"></i></a>
    <?php } ?>
    <!-- end dokumen -->

                        </div>
                        <div class="row-fluid" id="div_pnl_4" hidden>
                            <h4>Frequently Asked Questions (FAQ)</h4>
                            <!-- <br> -->
                            <div class="well-content clearfix">
                                <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                <table>
                                    <tr>
                                        <td colspan=2><label>Cari :</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
                                        <td> &nbsp </td>
                                        <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                                    </tr>
                                </table>
                            <?php echo form_close(); ?>
                            </div><br>
                        
                            <div class="questions">
                                <div>
                                    <button class="accordion">Section 1</button>
                                    <div class="panel_acc">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br><br>
                                      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <button class="accordion">Section 1</button>
                                    <div class="panel_acc">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                 </div>
            </div>

        </div>
    </div>

</div>


<script type="text/javascript">
    setPilihPanel('pnl_1');

    function setPilihPanel(vPanel){
        document.getElementById("pnl_1").removeAttribute("style");
        document.getElementById("pnl_2").removeAttribute("style");
        document.getElementById("pnl_3").removeAttribute("style");
        document.getElementById("pnl_4").removeAttribute("style");

        document.getElementById(vPanel).style.backgroundColor  = "#B0C4DE";
        document.getElementById(vPanel).style.opacity = "0.7";

        $('#div_pnl_1').hide();
        $('#div_pnl_2').hide();
        $('#div_pnl_3').hide();
        $('#div_pnl_4').hide();
        
        $('#div_'+vPanel).show();
    }
</script>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight){
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      });
    }
</script>


<script type="text/javascript">
    get_data_faq();

    $('#button-filter').click(function(e) {
        get_data_faq();        
    });

    function get_data_faq(){
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        $.ajax({
            type: "POST",
            data: {
                "kata_kunci": $('input[name="kata_kunci"]').val(),
            },
            url : "<?php echo base_url('dashboard/bantuan/get_data_faq'); ?>",
            success:function(response) {
                var obj = JSON.parse(response);
                $('.questions').empty();

                 $.each(obj, function (index, val) {
                    var JUDUL = val.JUDUL == null ? "" : val.JUDUL;
                    var KETERANGAN = val.KETERANGAN == null ? "" : val.KETERANGAN;

                    var cari = $('input[name="kata_kunci"]').val();
                    var regex = new RegExp(cari, "gi");
                    var KETERANGAN = KETERANGAN.replace(regex, "<b><i>"+cari+"</i></b>");

                    var cari = '\n';
                    var regex = new RegExp(cari, "gi");
                    var KETERANGAN = KETERANGAN.replace(regex, "<br>");

                    var newDiv = "<div> "+
                                    "<button class='accordion'>" +JUDUL+ "</button>"+
                                    "<div class='panel_acc'>"+
                                      "<p>"+KETERANGAN+"</p>"+
                                    "</div>"+
                                 "</div>";

                    $('.questions').append(newDiv)
                    
                    var acc = document.getElementsByClassName("accordion");

                    acc[acc.length-1].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        if (panel.style.maxHeight){
                            panel.style.maxHeight = null;
                        } else {
                            panel.style.maxHeight = panel.scrollHeight + "px";
                        } 
                    });

                  });

                  bootbox.hideAll();

                  if (obj == "" || obj == null) {
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                  }
                  
                }        
        });
    }

</script>

