<?php 
declare(strict_types=1);
// Input (bisa dari URL, dengan nilai default untuk CLI)
$nama = $_GET['nama'] ?? 'Budi Santoso'; 
$nim  = $_GET['nim']  ?? '2211102001'; 
$ipk  = (float) ($_GET['ipk'] ?? 3.75);

const KODE_PRODI = 'IF';

// Turunkan tahun angkatan dari 2 digit pertama NIM 
$tahunAngkatan = 2000 + (int) substr($nim, 0, 2);
// Predikat berdasarkan IPK
 $predikat = $ipk >= 3.5 ? 'Cum Laude'
 : ($ipk >= 3.0 ? 'Sangat Memuaskan' 
 :($ipk >= 2.5 ? 'Memuaskan' : 'Perlu Perbaikan'));
 // Format keluaran
 $ipkTampil = number_format($ipk, 2, ',', '.');
 $namaAman  = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');

 echo "===== PROFIL MAHASISWA =====\n";
 echo "Nama         : ".$namaAman . "\n";  
  echo "NIM         : ". $nim . "\n"; 
   echo "Prodi       :" . KODE_PRODI . "\n";
   echo "Tahun Angkatan :" . $tahunAngkatan."\n";
   echo "IPK            :". $ipkTampil. "\n";
   echo "Predikat       : ".$predikat. "\n";
  