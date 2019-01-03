<?php require_once('Connections/cnpenimbangan.php') ?>
<?php 
if( !isset($_GET['idf']) ){
    header('location: pilihan.php');
}
//ambil id dari query string
$id = $_GET['idf'];
// buat query untuk ambil data dari database
$sql = "SELECT * FROM formula WHERE idf = '$id'";
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
	<img src="image/logo.jpg" class="logo">
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
	<div class="command-content">Tekan Tombol "TARE"</div>
</div>
<?php
	$sql = "SELECT * FROM status WHERE ids = '$id'";
	$result = mysqli_query($cnPenimbangan, $sql);
	$cetakStatus = mysqli_fetch_assoc($result);
  	$test = "abcd";

  	date_default_timezone_set('Asia/Jakarta');      
	$date=date("Y/m/d h:i:sa");
?>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div style="font-size: 15pt;margin: 5px auto 10px;"> Proses sedang berjalan...</div>
    <table width="400">
		  <tr>
		    <td width="93">Urutan </td>
		    <td width="1">:</td>
		    <td width="82"><?php echo $id?></td>
		  </tr>
		  <tr>
		    <td>Timbangan</td>
		    <td>:</td>
		    <td><?php echo $cetakStatus['no_timbangan_aktif']; ?></td>
		  </tr>
		  <tr>
		    <td>Nama Produk </td>
		    <td>:</td>
		    <td><span id="nama_produk"><?php echo $cetak['nama_produk']; ?></span></td>
		  </tr>
		  <tr>
		    <td>Netto</td>
		    <td>:</td>
		    <td><span id="Netto"><?php echo $cetak['netto']; ?></span></td>
		  </tr>
		  <tr>
		    <td>Tara</td>
		    <td>:</td>
		    <td>1.3</td>
		  </tr>
		  <tr>
		    <td>No Timbangan </td>
		    <td>:</td>
		    <td><span id="no_timbangan"><?php echo $cetak['no_timbangan']; ?></span></td>
		  </tr>
		  <tr>
		    <td>Waktu Timbang</td>
		    <td>:</td>
		    <td><span id="jam_timbang"></span>&nbsp;&nbsp;<span id="tanggal"></span></td>
		  </tr>
	</table>
		    	<a href="insert.php?nama_produk=<?php echo $cetak['nama_produk']; ?>&nama_material=<?php echo $cetak['nama_material']; ?>&Netto=<?php echo $cetak['netto']; ?>&Tara=1.3&no_timbangan=<?php echo $cetak['no_timbangan']; ?>&jam_timbang=<?php echo $date ?>" target='_blank'>
    			<button class="save-button">Save</button>
    			</a>
  </div>
</div>
<div class="bottom">
	<button class="button"> Timbang Ulang</button>
	<button id="myBtn" class="button">Submit</button>
</div>
<script>
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  var today = new Date();
		  var h = today.getHours();
		  var m = today.getMinutes();
		  var s = today.getSeconds();
		  m = checkTime(m);
		  s = checkTime(s);
  		document.getElementById('jam_timbang').innerHTML =
		h + ":" + m + ":" + s;
		  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
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
  var dt = new Date();
	var months = new Array();
	 months[0] = "Januari";
	 months[1] = "Februari";
	 months[2] = "Maret";
	 months[3] = "April";
	 months[4] = "Mei";
	 months[5] = "Juni";
	 months[6] = "Juli";
	 months[7] = "Augustus";
	 months[8] = "September";
	 months[9] = "Oktober";
	 months[10] = "November";
	 months[11] = "Desember";
	var month = months[dt.getMonth()];
	document.getElementById("tanggal").innerHTML = (("0"+dt.getDate()).slice(-2)) +" "+ month +" "+ (dt.getFullYear());
}
</script>

<!-- MQTT -->
<script src="js/mqttws31.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	var client = new Paho.MQTT.Client("127.0.0.1", 15675,"/ws", "clientId");
	client.onConnectionLost = onConnectionLost;
	client.onMessageArrived = onMessageArrived;
	client.connect({onSuccess:onConnect});
	function onConnect() {
	  console.log("onConnect");
	  client.subscribe("timbangan");
	}

	function onConnectionLost(responseObject) {
	  if (responseObject.errorCode !== 0) {
	    console.log("onConnectionLost:"+responseObject.errorMessage);
	  }
	}

	function onMessageArrived(message) {
	  console.log("onMessageArrived:"+message.payloadString);
	  $('.weight-num-aktual').text(message.payloadString);
	}
</script>
<script type="text/javascript">
	var funRequest = function( option, callback ){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
		    callback( JSON.parse(this.responseText) );	    
		  }
		};
		xmlhttp.open("GET", "api.php?tablename=" + option.tablename, true);
		xmlhttp.send();
	}
</script>
<script>
var currentState = 'idle';
var states = [
	'idle',
	'wadah',
	'tara',
	'material'
];
var flagReadyToWeight = false;
var ID_DEVICE = 1;
funRequest({tablename: 'formula'}, function( formula ){
	var formulaByProductName = {};
	formula.rows.forEach(function(e){
		formulaByProductName[e.nama_produk + '-' + e.no_urut]=e;
	});
	funRequest({tablename:'status'}, function( status ){
		var currentUrutanTimbang = status.rows[0]['No Urut'];
		var currentNamaProduk = status.rows[0]['Nama Produk Aktif'];
		if( (currentNamaProduk + "-" + currentUrutanTimbang) in formulaByProductName ) {
			if( formulaByProductName[currentNamaProduk + "-" + currentUrutanTimbang]['no_timbangan'] == ID_DEVICE.toString() ) {
				$('.top-nameBrand').text(formulaByProductName[currentNamaProduk + "-" + currentUrutanTimbang]['nama_produk']);
				$('.top-materialName').text(formulaByProductName[currentNamaProduk + "-" + currentUrutanTimbang]['nama_material']);
				$('.weight-num-target').text(formulaByProductName[currentNamaProduk + "-" + currentUrutanTimbang]['netto']);
				flagReadyToWeight = true;
			} else {
				flagReadyToWeight = false;
			}
		} else {
			flagReadyToWeight = false;
		}
	});
});

if( flagReadyToWeight ) {
	main = function( onState ){
		switch (onState) {
			case 'idle':
			case 'wadah':
			case 'tara':
			case 'material':
		} 
	}
}
</script>
</body>
</html>