<?php

$data = [];

function input($t) { echo "$t: "; return trim(fgets(STDIN)); }

function tampil($d) {
    echo "\nNo  NPM         Nama              Jurusan        Angkatan\n" . str_repeat('-', 58) . "\n";
    foreach ($d as $i => $m) printf("%-4s%-12s%-18s%-15s%-8s\n", $i+1, $m[0], $m[1], $m[2], $m[3]);
}

while (true) {
    echo "\n1.Tampil\n  2.Tambah\n  0.Keluar\n";
    $p = input("Pilih");

    if ($p == 1) empty($data) ? print("Belum ada data.\n") : tampil($data);
    elseif ($p == 2) { $data[] = [input("NPM"), input("Nama"), input("Jurusan"), input("Angkatan")]; echo "Tersimpan!\n"; }
    elseif ($p == 0) { echo "Sampai jumpa!\n"; break; }
}