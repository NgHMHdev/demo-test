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

        $ngayAn = '';
        if (!empty($ngayLenMon)) {
            $ngayAn = "WHERE dondatmon.ngayLenMon='$ngayLenMon'";
        }

        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $tbl = " SELECT taikhoan.hoTen, maNhanVien, soDienThoai, ngayLenMon,trangThaiThanhToan,tongTien, duyetDon, SUM(tongSoLuong) AS TongSoLuong FROM dondatmon INNER JOIN taikhoan ON
         dondatmon.idTaiKhoan = taikhoan.idTaiKhoan $ngayAn GROUP BY dondatmon.idTaiKhoan, ngayLenMon;";
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





    function InsertOrder($idTaiKhoan, $result, $tongTien, $ngayDat)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $insert = "INSERT INTO dondatmon (`idDon`, `idTaiKhoan`, `tongSoLuong`, `tongTien`, `ngayLenMon`, `ngayDat`) 
  VALUES ";

        foreach ($result as $item) {

            $tongSoLuong = $item['soLuong'];
            $ngayLenMon = $item['ngayLenMon'];


            $idDon  = rand(0, 1000000);
            $idDon = $_SESSION['is_login']['idTaiKhoan'] . $idDon;
            $insert .= "($idDon, $idTaiKhoan, '$tongSoLuong', '$tongTien', '$ngayLenMon', '$ngayDat'),";
        }


        $insert = rtrim($insert, ", ");
        $kq = mysqli_query($connect,  $insert);
        $p->dongketnoi($connect);
        return $kq;
    }


    function InsertOrderDetail($listCart, $listOrder)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();
        $insert = "INSERT INTO chitietdon (`idDon`, `idMonAn`, `soLuong`, `ngayLenMon`) VALUES";

        foreach ($listCart as $item) {
            foreach ($listOrder as $order) {
                if ($item['ngayLenMon'] == $order['ngayLenMon'] && $item['idTaiKhoan'] == $order['idTaiKhoan']) {


                    $idmon = $item['idMonAn'];
                    $soLuong = $item['soLuong'];
                    $ngayLenMon =  $item['ngayLenMon'];
                    $idDon = $order['idDon'];
                    $insert .= "($idDon, $idmon, $soLuong, '$ngayLenMon'),";
                }
            }
        }
        $insert = rtrim($insert, ", ");
        $kq = mysqli_query($connect,  $insert);
        $p->dongketnoi($connect);
        return $kq;
    }

    function ApproveOrder($approve, $ngayLenMon)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $update = '';
        foreach ($approve as $item) {
            $idTaiKhoan =  $item['idTaiKhoan'];
            $duyetDon =  $item['duyeton'];
            $update .= "UPDATE dondatmon SET duyetDon = $duyetDon WHERE idTaiKhoan = $idTaiKhoan and ngayLenMon = '$ngayLenMon'; ";
        }

        $kq = mysqli_multi_query($connect, $update);
        $p->dongketnoi($connect);
        return $kq;
    }


    function UpdateTotalOrder($totalByDonId)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $update = '';
        foreach ($totalByDonId as $idDon => $total) {
            $update .= "UPDATE dondatmon SET `tongTien` = $total WHERE idDon = $idDon; ";
        }

        $kq = mysqli_multi_query($connect, $update);
        $p->dongketnoi($connect);
        return $kq;
    }

    function UpdateTotalAndQuantityOrder($totalByDonId)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $update = '';
        foreach ($totalByDonId as $idDon => $item) {
            $total = $item['TongTien'];
            $soLuong = $item['soLuong'];
            $update .= "UPDATE dondatmon SET `tongTien` = $total, tongSoLuong = $soLuong WHERE idDon = $idDon; ";
        }

        $kq = mysqli_multi_query($connect, $update);
        $p->dongketnoi($connect);
        return $kq;
    }

    function PaymentSuccess($idTaiKhoan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $update = "UPDATE dondatmon SET `TrangThaiThanhToan` = 1 WHERE idTaiKhoan = $idTaiKhoan";


        $kq = mysqli_multi_query($connect, $update);
        $p->dongketnoi($connect);
        return $kq;
    }


    
    function InsertThanhToan($idThanhToan, $ngayThanhToan, $soTien, $idTaiKhoan, $hinhThucThanhToan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $insert = "INSERT INTO thanhtoan(idThanhToan, ngayThanhToan, soTien, idTaiKhoan, hinhThucThanhToan)
        VALUES ('$idThanhToan', '$ngayThanhToan', '$soTien', '$idTaiKhoan', '$hinhThucThanhToan')";

        $kq = mysqli_query($connect, $insert);
        $p->dongketnoi($connect);
        return $kq;
    }

    function InsertChiTietThanhToan($dish, $idThanhToan)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $insert = "INSERT INTO chitietthanhtoan(tenMon,gia, soLuong, idThanhToan)  VALUES";
        foreach ($dish  as $item) {
            $tenMon = $item['tenMon'];
            $soLuong = $item['soLuong'];
            $gia = $item['gia'];
            $insert .= "('$tenMon','$gia', '$soLuong', '$idThanhToan'), ";
        }
        
        $insert = rtrim($insert, ", ");
    echo "<script>alert('$insert')</script>";

        $kq = mysqli_multi_query($connect, $insert);
        $p->dongketnoi($connect);
        return $kq;
    }


    function DeleteDishNoMenu($resultArray)
    {
        $p = new clsketnoi();
        $connect = $p->ketnoiDB();

        $Delete = '';
        foreach ($resultArray as $item) {
            $idMonAn = $item['idMonAn'];
            $idDon = $item['idDon'];
            $Delete .= "DELETE FROM chiTietDon WHERE idMonAn =$idMonAn AND idDon = $idDon; ";
        }
        

        $kq = mysqli_multi_query($connect, $Delete);
        $p->dongketnoi($connect);
        return $kq;
    }
}
