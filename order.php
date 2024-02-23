<?php
include_once("ketnoi.php");

class modelOrder
{
    
    function SelectThanhToanByIdTaiKhoanAndIdDonHang($idTaiKhoan, $idThanhToan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM `thanhtoan` INNER JOIN chitietthanhtoan ON thanhtoan.idThanhToan = chitietthanhtoan.idThanhToan
         INNER JOIN taikhoan ON thanhtoan.idTaiKhoan = taikhoan.idTaiKhoan
         WHERE thanhtoan.idTaiKhoan =$idTaiKhoan AND thanhtoan.idThanhToan = $idThanhToan";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }


   


    function SelectSumOrderPayByidTaiKhoan($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT chitietdon.idMonAn ,SUM(chitietdon.soLuong) as soLuong, monan.tenMon, monan.gia FROM dondatmon 
        INNER JOIN chitietdon ON dondatmon.idDon=chitietdon.idDon 
        INNER JOIN monan ON chitietdon.idMonAn = monan.idMonAn WHERE idTaiKhoan = $idTaiKhoan AND  dondatmon.trangThaiThanhToan = 0
        GROUP BY chitietdon.idMonAn  ";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectOrderByidTaiKhoan($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM dondatmon        
        JOIN chitietdon ON dondatmon.idDon = chitietdon.idDon 
        JOIN monan ON chitietdon.idMonAn = monan.idMonAn WHERE dondatmon.idTaiKhoan = $idTaiKhoan ORDER BY dondatmon.ngayDat DESC";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectSumOrderByidTaiKhoan($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT Sum(tongTien) as TongTien FROM  dondatmon
         WHERE idTaiKhoan = '$idTaiKhoan' AND trangThaiThanhToan = 0 GROUP BY idTaiKhoan ";

        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectOrderByidTaiKhoanFind($idTaiKhoan, $trangThaiThanhToan, $duyetDon)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $find = '';
        if ($trangThaiThanhToan != '') {
            $find = " AND dondatmon.trangThaiThanhToan = $trangThaiThanhToan";
        }
        if ($duyetDon != '') {
            $find = "AND duyetDon= $duyetDon";
        }
        $tbl = "SELECT * FROM taikhoan 
    JOIN  dondatmon ON taikhoan.idTaiKhoan =  dondatmon.idTaiKhoan        
    JOIN chitietdon ON dondatmon.idDon = chitietdon.idDon 
    JOIN monan ON chitietdon.idMonAn = monan.idMonAn WHERE taikhoan.idTaiKhoan = '$idTaiKhoan'
    $find  ORDER BY dondatmon.ngayDat DESC";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectOrderDetail()
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM chitietdon INNER JOIN monan ON chitietdon.idMonAn=monan.idMonAn";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectAllOrder()
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM dondatmon";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }




    function SelectOrder()
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "WITH MaxTimestamp AS ( SELECT MAX(ngayDat) AS max_time FROM dondatmon ) 
        SELECT * FROM dondatmon WHERE ngayDat = (SELECT max_time FROM MaxTimestamp)";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }

    function SelectOrderNewCreateByIdTaiKhoan($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM dondatmon where idTaiKhoan = $idTaiKhoan ORDER BY ngayDat DESC LIMIT 1";
        $table = mysqli_query($connect, $tbl);
        $list_users = array();
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $list_users[] = $row;
            }
            return $list_users;
        }
        $p->dongketnoi($connect);
    }




    function SelectOrderSumTotal($ngayLenMon)
    {

       
}
