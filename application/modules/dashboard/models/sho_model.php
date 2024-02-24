<?php
class sho_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
    
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));
    
        $data = $this->get_level_user(); 
    
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['report'] = $this->tbl_get->report();
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function mget_grafik($data){
        $bbm = $data['BBM'];
        $bulan = $data['BULAN'];
        $tahun = $data['TAHUN'];
        $vlevel = $data['VLEVEL'];
        $vlevelid = $data['VLEVELID'];

        $sql = "CALL lap_sho_bbm2 ('$bbm', '$bulan', '$tahun', '$vlevel','$vlevelid')";
        $query = $this->db->query($sql);
        // print_r($this->db->last_query());
            
        return $query->result();
    }

    // public function mget_grafik($data) {
    //     $BBM = $data['BBM'];
    //     $BULAN = $data['BULAN'];
    //     $TAHUN = $data['TAHUN'];
    //     $VLEVEL = $data['VLEVEL'];
    //     $VLEVELID = $data['VLEVELID'];

    //     if($VLEVEL == 'Regional') {
    //         $PARAM = "F.ID_REGIONAL = '$VLEVELID'";
    //     } elseif ($VLEVEL == 'Level 1') {
    //         $PARAM = "E.COCODE= '$VLEVELID'";
    //     } elseif ($VLEVEL == 'Level 2') {
    //         $PARAM = "D.PLANT = '$VLEVELID'";
    //     } elseif ($VLEVEL == 'Level 3') {
    //         $PARAM = "C.STORE_SLOC = '$VLEVELID'";
    //     } elseif ($VLEVEL == 'Level 4') {
    //         $PARAM = "B.SLOC = '$VLEVELID'";
    //     } 

    //     if($VLEVEL == 'All') {
    //         $sql = "SELECT E.LEVEL1 UNIT,
    //                         A.ID_JNS_BHN_BKR,
    //                         A.NAMA_JNS_BHN_BKR,
    //                         A.TGL_MUTASI_PERSEDIAAN TGL_MUTASI_PERSEDIAAN,
    //                         A.BULAN,
    //                         A.STOCK_AKHIR_EFEKTIF,
    //                         CASE
    //                             WHEN C.VOLUME_MAX_PAKAI IS NULL
    //                             THEN
    //                                 (  SELECT VOLUME_MAX_PAKAI
    //                                     FROM MAX_PEMAKAIAN D
    //                                     WHERE     D.THBL_MAX_PAKAI <
    //                                                     DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,
    //                                                                 '%Y%m')
    //                                                 - 1
    //                                         AND D.SLOC = A.SLOC
    //                                         AND D.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR
    //                                         AND STATUS_MAX_PAKAI='1'
    //                                 ORDER BY D.THBL_MAX_PAKAI DESC LIMIT 1) ELSE C.VOLUME_MAX_PAKAI END MAX_PEMAKAIAN
    //                     FROM (
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('01','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'01')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('02','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'02')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('03','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'03')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('04','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'04')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR 
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('05','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'05')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('06','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'06')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('07','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'07')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('08','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'08')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('09','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'09')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('10','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'10')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('11','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'11')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('12','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'12')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     )  AS A
    //                 LEFT OUTER JOIN (
    //                     SELECT SLOC,ID_JNS_BHN_BKR,THBL_MAX_PAKAI,VOLUME_MAX_PAKAI  FROM MAX_PEMAKAIAN
    //                     WHERE STATUS_MAX_PAKAI='1'
    //                     ) C
    //                     ON C.SLOC = A.SLOC AND C.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND C.THBL_MAX_PAKAI = DATE_FORMAT(A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
    //                     INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC AND B.IS_AKTIF_LVL4='1'
    //                             INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
    //                             INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
    //                             INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
    //                             INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
    //                             INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR 
    //                 ) A
    //                 UNION ALL
    //                 SELECT 'Rata-rata SHO' UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR,TAHUN,ROUND(AVG(BLN_01),2) BLN_01,
    //                 ROUND(AVG(BLN_02),2) BLN_02,ROUND(AVG(BLN_03),2) BLN_03,ROUND(AVG(BLN_04),2) BLN_04,
    //                 ROUND(AVG(BLN_05),2) BLN_05,ROUND(AVG(BLN_06),2) BLN_06,ROUND(AVG(BLN_07),2) BLN_07,
    //                 ROUND(AVG(BLN_08),2) BLN_08,ROUND(AVG(BLN_09),2) BLN_09,ROUND(AVG(BLN_10),2) BLN_10,
    //                 ROUND(AVG(BLN_11),2) BLN_11,ROUND(AVG(BLN_12),2) BLN_12
    //                 FROM (
    //                 SELECT UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR,vthn TAHUN,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '01' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '01',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '01',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_01,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '02' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '02',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '02',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_02,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '03' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '03',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '03',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_03,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '04' THEN 
    //                 IFNULL(ROUND(SUM(IF(BULAN = '04',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '04',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_04,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '05' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '05',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '05',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_05,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '06' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '06',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '06',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_06,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '07' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '07',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '07',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_07,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '08' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '08',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '08',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_08,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '09' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '09',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '09',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_09,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '10' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '10',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '10',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_10,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '11' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '11',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '11',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_11,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '12' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '12',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '12',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_12  
    //             FROM (SELECT E.LEVEL1 UNIT,
    //                         A.ID_JNS_BHN_BKR,
    //                         A.NAMA_JNS_BHN_BKR,
    //                         A.TGL_MUTASI_PERSEDIAAN TGL_MUTASI_PERSEDIAAN,
    //                         A.BULAN,
    //                         A.STOCK_AKHIR_EFEKTIF,
    //                         CASE
    //                             WHEN C.VOLUME_MAX_PAKAI IS NULL
    //                             THEN
    //                                 (  SELECT VOLUME_MAX_PAKAI
    //                                     FROM MAX_PEMAKAIAN D
    //                                     WHERE     D.THBL_MAX_PAKAI <
    //                                                     DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,
    //                                                                 '%Y%m')
    //                                                 - 1
    //                                         AND D.SLOC = A.SLOC
    //                                         AND D.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR
    //                                         AND STATUS_MAX_PAKAI='1'
    //                                 ORDER BY D.THBL_MAX_PAKAI DESC LIMIT 1) ELSE C.VOLUME_MAX_PAKAI END MAX_PEMAKAIAN
    //                     FROM (
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('01','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'01')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('02','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'02')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('03','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'03')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('04','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'04')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR 
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('05','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'05')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('06','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'06')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('07','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'07')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('08','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'08')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('09','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'09')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('10','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'10')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('11','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'11')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('12','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'12')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     ) A
    //                 LEFT OUTER JOIN (
    //                     SELECT SLOC,ID_JNS_BHN_BKR,THBL_MAX_PAKAI,VOLUME_MAX_PAKAI  FROM MAX_PEMAKAIAN
    //                     WHERE STATUS_MAX_PAKAI='1'
    //                     ) C
    //                     ON C.SLOC = A.SLOC AND C.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND C.THBL_MAX_PAKAI = DATE_FORMAT(A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
    //                     INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC AND B.IS_AKTIF_LVL4='1'
    //                             INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
    //                             INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
    //                             INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
    //                             INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
    //                             INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                 ) A
    //                 GROUP BY UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR
    //                 ";

    //                 $query = $this->db->query($sql);

    //                 // print_r($query);die();

    //                 return $query->result();
    //     } else {
    //         $sql = "SELECT UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR,$TAHUN TAHUN,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '01' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '01',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '01',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_01,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '02' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '02',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '02',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_02,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '03' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '03',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '03',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_03,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '04' THEN 
    //                 IFNULL(ROUND(SUM(IF(BULAN = '04',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '04',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_04,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '05' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '05',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '05',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_05,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '06' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '06',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '06',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_06,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '07' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '07',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '07',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_07,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '08' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '08',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '08',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_08,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '09' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '09',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '09',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_09,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '10' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '10',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '10',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_10,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '11' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '11',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '11',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_11,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '12' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '12',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '12',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_12  
    //             FROM (SELECT E.LEVEL1 UNIT,
    //                         A.ID_JNS_BHN_BKR,
    //                         A.NAMA_JNS_BHN_BKR,
    //                         A.TGL_MUTASI_PERSEDIAAN TGL_MUTASI_PERSEDIAAN,
    //                         A.BULAN,
    //                         A.STOCK_AKHIR_EFEKTIF,
    //                         CASE
    //                             WHEN C.VOLUME_MAX_PAKAI IS NULL
    //                             THEN
    //                                 (  SELECT VOLUME_MAX_PAKAI
    //                                     FROM MAX_PEMAKAIAN D
    //                                     WHERE     D.THBL_MAX_PAKAI <
    //                                                     DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,
    //                                                                 '%Y%m')
    //                                                 - 1
    //                                         AND D.SLOC = A.SLOC
    //                                         AND D.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR
    //                                         AND STATUS_MAX_PAKAI='1'
    //                                 ORDER BY D.THBL_MAX_PAKAI DESC LIMIT 1) ELSE C.VOLUME_MAX_PAKAI END MAX_PEMAKAIAN
    //                     FROM (
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('01','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'01')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('02','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'02')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('03','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'03')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('04','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'04')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR 
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('05','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'05')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('06','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'06')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('07','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'07')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('08','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'08')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('09','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'09')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('10','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'10')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('11','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'11')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('12','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TAHUN,'12')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     ) A
    //                 LEFT OUTER JOIN (
    //                     SELECT SLOC,ID_JNS_BHN_BKR,THBL_MAX_PAKAI,VOLUME_MAX_PAKAI  FROM MAX_PEMAKAIAN
    //                     WHERE STATUS_MAX_PAKAI='1'
    //                     ) C
    //                     ON C.SLOC = A.SLOC AND C.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND C.THBL_MAX_PAKAI = DATE_FORMAT(A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
    //                     INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC AND B.IS_AKTIF_LVL4='1'
    //                             INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
    //                             INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
    //                             INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
    //                             INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
    //                             INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR 
    //                             WHERE $PARAM
    //                 ) A
    //                 UNION ALL
    //                 SELECT 'Rata-rata SHO' UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR,TAHUN,ROUND(AVG(BLN_01),2) BLN_01,
    //                 ROUND(AVG(BLN_02),2) BLN_02,ROUND(AVG(BLN_03),2) BLN_03,ROUND(AVG(BLN_04),2) BLN_04,
    //                 ROUND(AVG(BLN_05),2) BLN_05,ROUND(AVG(BLN_06),2) BLN_06,ROUND(AVG(BLN_07),2) BLN_07,
    //                 ROUND(AVG(BLN_08),2) BLN_08,ROUND(AVG(BLN_09),2) BLN_09,ROUND(AVG(BLN_10),2) BLN_10,
    //                 ROUND(AVG(BLN_11),2) BLN_11,ROUND(AVG(BLN_12),2) BLN_12
    //                 FROM (
    //                 SELECT UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR,vthn TAHUN,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '01' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '01',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '01',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_01,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '02' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '02',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '02',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_02,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '03' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '03',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '03',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_03,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '04' THEN 
    //                 IFNULL(ROUND(SUM(IF(BULAN = '04',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '04',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_04,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '05' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '05',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '05',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_05,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '06' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '06',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '06',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_06,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '07' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '07',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '07',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_07,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '08' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '08',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '08',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_08,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '09' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '09',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '09',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_09,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '10' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '10',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '10',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_10,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '11' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '11',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '11',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_11,
    //                 CASE WHEN DATE_FORMAT(SYSDATE(),'%m') >= '12' THEN
    //                 IFNULL(ROUND(SUM(IF(BULAN = '12',STOCK_AKHIR_EFEKTIF,'0'))/SUM(IF(BULAN = '12',MAX_PEMAKAIAN,'0')),2),0) END AS BLN_12  
    //             FROM (SELECT E.LEVEL1 UNIT,
    //                         A.ID_JNS_BHN_BKR,
    //                         A.NAMA_JNS_BHN_BKR,
    //                         A.TGL_MUTASI_PERSEDIAAN TGL_MUTASI_PERSEDIAAN,
    //                         A.BULAN,
    //                         A.STOCK_AKHIR_EFEKTIF,
    //                         CASE
    //                             WHEN C.VOLUME_MAX_PAKAI IS NULL
    //                             THEN
    //                                 (  SELECT VOLUME_MAX_PAKAI
    //                                     FROM MAX_PEMAKAIAN D
    //                                     WHERE     D.THBL_MAX_PAKAI <
    //                                                     DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,
    //                                                                 '%Y%m')
    //                                                 - 1
    //                                         AND D.SLOC = A.SLOC
    //                                         AND D.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR
    //                                         AND STATUS_MAX_PAKAI='1'
    //                                 ORDER BY D.THBL_MAX_PAKAI DESC LIMIT 1) ELSE C.VOLUME_MAX_PAKAI END MAX_PEMAKAIAN
    //                     FROM (
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('01','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'01')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('02','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'02')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('03','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'03')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('04','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'04')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR 
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('05','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'05')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('06','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'06')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('07','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'07')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('08','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'08')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('09','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'09')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('10','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'10')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('11','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'11')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     UNION ALL
    //                     SELECT A.SLOC,A.ID_JNS_BHN_BKR,G.NAMA_JNS_BHN_BKR,MAX(A.TGL_MUTASI_PERSEDIAAN) TGL_MUTASI_PERSEDIAAN,
    //                     DATE_FORMAT(STR_TO_DATE('12','%m'),'%m') BULAN,
    //                     SUBSTRING(MAX(CONCAT(FROM_UNIXTIME(A.TGL_MUTASI_PERSEDIAAN),A.STOCK_AKHIR_EFEKTIF)) FROM 20)  STOCK_AKHIR_EFEKTIF
    //                     FROM REKAP_MUTASI_PERSEDIAAN A
    //                     INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                     WHERE A.IS_AKTIF_MUTASI_PERSEDIAAN='1' AND DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m')<= CONCAT($TA,'12')
    //                     AND G.NAMA_JNS_BHN_BKR = $BBM
    //                     GROUP BY A.SLOC,G.NAMA_JNS_BHN_BKR,A.ID_JNS_BHN_BKR
    //                     ) A
    //                 LEFT OUTER JOIN (
    //                     SELECT SLOC,ID_JNS_BHN_BKR,THBL_MAX_PAKAI,VOLUME_MAX_PAKAI  FROM MAX_PEMAKAIAN
    //                     WHERE STATUS_MAX_PAKAI='1'
    //                     ) C
    //                     ON C.SLOC = A.SLOC AND C.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND C.THBL_MAX_PAKAI = DATE_FORMAT(A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
    //                     INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC AND B.IS_AKTIF_LVL4='1'
    //                             INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
    //                             INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
    //                             INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
    //                             INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
    //                             INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
    //                             WHERE $PARAM
    //                 ) A
    //                 GROUP BY UNIT,ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR";

    //                 $query = $this->db->query($sql);

    //                 // print_r($query);die();

    //                 return $query->result();
    //     }
    // }
  
    public function getVolMfo($data){
       
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        // MONTH(A.TGL_MUTASI_PERSEDIAAN) <= $BULAN AND YEAR(A.TGL_MUTASI_PERSEDIAAN) <= $TAHUN 
        $sql = "SELECT ifnull(SUM(B.SHO),0) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
                FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'MFO' AND 
                DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') = $TAHUN$BULAN
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

    }

    public function getVolHsd($data){
       
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT ifnull(SUM(B.SHO),0) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
                FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'HSD' AND 
                DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') = $TAHUN$BULAN 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getVolBio($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


       
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT ifnull(SUM(B.SHO),0) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
                FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'BIO' AND 
                DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') = $TAHUN$BULAN  
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }
    

     public function getVolHsdBio($data){
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


       
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT ifnull(SUM(B.SHO),0) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
                FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'HSD+BIO' AND 
                DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') = $TAHUN$BULAN  
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getVolIdo($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


        
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT ifnull(SUM(B.SHO),0) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
                FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'IDO' AND 
                DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') = $TAHUN$BULAN  
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getTableMfo($data)
     {
        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableBio($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableHsd($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }
        

     }

     public function getTableHsdBio($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableIdo($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;    
        }
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            return $option;    
        }
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            return $option;    
        }
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            return $option;    
        }
    }

    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['01'] = 'Januari';
        $option['02'] = 'Febuari';
        $option['03'] = 'Maret';
        $option['04'] = 'April';
        $option['05'] = 'Mei';
        $option['06'] = 'Juni';
        $option['07'] = 'Juli';
        $option['08'] = 'Agustus';
        $option['09'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_tahun() {
        $year = date("Y"); 

        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function get_level($lv='', $key=''){ 
        switch ($lv) {
            case "R":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "0":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "1":
                $q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_LEVEL1 D 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE COCODE='$key' ";
                break;
            case "2":
                $q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL2 C 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE PLANT='$key' ";
                break;
            case "3":
                $q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL3 B
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE STORE_SLOC='$key' ";
                break;
            case "4":
                $q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL4 A
                LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE SLOC='$key' ";
                break;
            case "5":
                $q = "SELECT a.LEVEL3, a.STORE_SLOC
                FROM MASTER_LEVEL3 a
                INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
                INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
                WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' ";
                break;
        } 

        $query = $this->db->query($q)->result();
        return $query;
    }
      
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */