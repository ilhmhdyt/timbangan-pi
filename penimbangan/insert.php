<?php require_once('Connections/cnpenimbangan.php') ;

 		$nama_produk 		= $_GET['nama_produk'] ;
 		$nama_material		= $_GET['nama_material'];
 		$Netto				= $_GET['Netto'] ;
 		$Tara				= $_GET['Tara'] ;
 		$no_timbangan		= $_GET['no_timbangan'] ;
 		$jam_timbang		= $_GET['jam_timbang'] ;

 		$cetak2 = "INSERT INTO hasil " .
					"VALUES ( '" .
							$nama_produk .	"' , '" .
							$nama_material . 	"' , '" .
							$Netto .	"' , '" .
							$Tara .	"' , '" .
							$no_timbangan .	"' , '" .
							$jam_timbang .	"' , '" .
							"" .
						"' )" ;
        

 		if (mysqli_query($cnPenimbangan, $cetak2)) {
 			echo  "<b>Data Berhasil Disimpan!</b>" ;

 			echo "<meta http-equiv='refresh' content='1; URL=screen1.php'>" ;

 			}else{
 			echo "<b>Gagal Disave!</b>" ;
 			echo $cetak2;
 			echo "<meta http-equiv='refresh' content='1; URL=insert.php'>" ;
 		}
?> 