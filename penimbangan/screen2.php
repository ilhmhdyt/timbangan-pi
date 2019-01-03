<?php require_once('Connections/cnpenimbangan.php') ?>
<?php 
if( !isset($_GET[$id]) ){
    header('location: screen1.php');
}
//ambil id dari query string
$id1 = $_GET[$id];
// buat query untuk ambil data dari database
$sql = "SELECT * FROM formula WHERE idf = '$id1'";
$query = mysqli_query($cnPenimbangan, $sql);
$cetak = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css-screen/style.css">
	<title>Screen</title>
</head>
<body>
<div class="top">
	<!-- <img src="image/logo.jpg" class="logo"> -->
	<div class="top-border">
		<div class="top-nameBrand"> SWAN </div>
	</div>
	<div class="top-material"> Material </div>
	<div class="top-materialName"><?php echo $cetak['nama_material']; ?></div>
</div>
<div class="middle-top">
	<div class="weight-target"> 
		<div class="weight-font-target">Berat Target</div>
		<div class="weight-num-target"><?php echo $cetak['netto']; ?>.00</div>
		<div class="unit-target">Kg</div>
	</div>
	
	<div class="weight-aktual"> 
		<div class="weight-font-aktual">Berat Aktual</div>
		<div class="weight-num-aktual"> 99.99 </div>
		<div class="unit-aktual">Kg</div>
	</div>
</div>
<div class="middle-bottom">
	<div class="command">PERINTAH</div>
	<div class="command-content">Tekan Tombol "TARA"</div>
</div>
<?php
	$sql = "SELECT * FROM status WHERE idf = '$id'";
	$result = mysqli_query($cnPenimbangan, $sql);
	$cetak = mysqli_fetch_assoc($result);
?>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Proses sedang berjalan...</p>
    <p>Urutan : <?php echo $id1?></p>
    <p>Timbangan : <?php echo $cetak['no_timbangan_aktif']; ?></p>
    <br><br>
    <div><a href="screen2.php?idf='.$cetak['$id1'].'" target="_blank" ><button>Save</button></a></div>
  </div>
</div>
<div class="bottom">
	<button> Timbang Ulang</button>
	<button id="myBtn">Submit</button>
</div>
<script>
// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>