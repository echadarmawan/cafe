<?php
include "conn.php";

if(isset($_POST['input_order_validate'])){

    mysqli_begin_transaction($conn);

    try{

        $kode_pesanan = $_POST['kode_pesanan'];
        $waktu = $_POST['waktu'];
        $pelanggan = $_POST['pelanggan'];
        $meja = $_POST['meja'];
        $total = $_POST['total_pesanan'];

        $pelayan_id = $_POST['pelayan_id'];

        mysqli_query($conn,"
            INSERT INTO tb_pesanan
            (
                kode_pesanan,
                waktu,
                nama_pelanggan,
                meja,
                total,
                pelayan_id,
                status_pesanan,
                status_pembayaran
            )
            VALUES
            (
                '$kode_pesanan',
                '$waktu',
                '$pelanggan',
                '$meja',
                '$total',
                '$pelayan_id',
                0,
                0
            )
        ");

        $pesanan_id = mysqli_insert_id($conn);

        foreach($_POST['menu_id'] as $key => $menu_id){

            $harga = $_POST['harga'][$key];
            $qty = $_POST['qty'][$key];
            $subtotal = $_POST['subtotal'][$key];

            mysqli_query($conn,"
                INSERT INTO tb_detail
                (
                    pesanan_id,
                    menu_id,
                    harga,
                    kuantitas,
                    subtotal
                )
                VALUES
                (
                    '$pesanan_id',
                    '$menu_id',
                    '$harga',
                    '$qty',
                    '$subtotal'
                )
            ");

            mysqli_query($conn,"
                UPDATE tb_menu
                SET stok = stok - $qty
                WHERE id = '$menu_id'
            ");
        }

        mysqli_commit($conn);

        header("Location: ../order");
        exit;

    }catch(Exception $e){

        mysqli_rollback($conn);

        echo $e->getMessage();
    }
}
?>