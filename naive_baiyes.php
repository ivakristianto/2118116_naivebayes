<?php
require 'koneksi.php';

// Fungsi untuk menghitung total data training dari tabel handphone
function totalDataTraining(){
    global $con;
    return (int) mysqli_fetch_row(mysqli_query($con, "SELECT * FROM handphone"));
}
// var_dump(totalDataTraining());

// Fungsi untuk menghitung jumlah data untuk masing-masing kelas ('ya' dan 'tidak')
function jumlahDataKelas(){
    global $con;
    $query = "SELECT * FROM handphone where layak = ";

    $jumlahDataLayak['ya'] = (int) mysqli_fetch_row(mysqli_query($con, $query . "'ya'"))[0];
    $jumlahDataLayak['tidak'] = (int) mysqli_fetch_row(mysqli_query($con, $query . "'tidak'"))[0];
    return $jumlahDataLayak;
}

// Fungsi untuk menghitung prior probability dari masing-masing kelas ('ya' dan 'tidak')
function priorProbability(){
    $kelas['ya'] = jumlahDataKelas()['ya'] / totalDataTraining();
    $kelas['tidak'] = jumlahDataKelas()['tidak'] / totalDataTraining();
    return $kelas;
}

// Fungsi untuk menghitung conditional probability dari sebuah atribut (kolom) terhadap nilai tertentu
function conditionalProbability($nama_kolom, $nilai){
    global $con;
    $query = "SELECT COUNT($nama_kolom) FROM handphone WHERE $nama_kolom = '$nilai' AND layak=";

    $conditionalProbability['ya'] = (int) mysqli_fetch_row(mysqli_query($con, $query . "'ya'"))[0] / jumlahDataKelas()['ya'];
    $conditionalProbability['tidak'] = (int) mysqli_fetch_row(mysqli_query($con, $query . "'tidak'"))[0] / jumlahDataKelas()['tidak'];

    return $conditionalProbability;
}

// Fungsi untuk menghitung posterior probability dari data yang diberikan
function posteriorProbability($data){
    $atribut['kamera'] = conditionalProbability('kamera', $data['kamera']);
    $atribut['baterai'] = conditionalProbability('baterai', $data['baterai']);
    $atribut['harga'] = conditionalProbability('harga', $data['harga']);

    // Menghitung probabilitas posterior untuk kelas 'ya' dan 'tidak'
    $probabilitas['ya'] = $atribut['kamera']['ya'] * $atribut['baterai']['ya'] * $atribut['harga']['ya'] * priorProbability()['ya'];
    $probabilitas['tidak'] = $atribut['kamera']['tidak'] * $atribut['baterai']['tidak'] * $atribut['harga']['tidak'] * priorProbability()['tidak'];
    
    // Mengembalikan prediksi kelas berdasarkan probabilitas posterior yang lebih tinggi
    if($probabilitas['ya'] > $probabilitas['tidak']){
        return 'ya';
    } else if($probabilitas['ya'] < $probabilitas['tidak']){
        return 'tidak';
    }
}
?>