<?php
include_once("ketnoi.php");

class modelOrder
{
    
    function SelectOrderByNgayLenMon($ngayLenMon)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM taikhoan 
        JOIN  dondatmon ON taikhoan.idTaiKhoan =  dondatmon.idTaiKhoan        
        JOIN chitietdon ON dondatmon.idDon = chitietdon.idDon 
        JOIN monan ON chitietdon.idMonAn = monan.idMonAn WHERE chitietdon.ngayLenMon = '$ngayLenMon'";
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

    function SelectThanhToanByIdTaiKhoan($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = "SELECT * FROM `thanhtoan` INNER JOIN chitietthanhtoan ON thanhtoan.idThanhToan = chitietthanhtoan.idThanhToan
         INNER JOIN taikhoan ON thanhtoan.idTaiKhoan = taikhoan.idTaiKhoan
         WHERE thanhtoan.idTaiKhoan =$idTaiKhoan";
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
       
}
