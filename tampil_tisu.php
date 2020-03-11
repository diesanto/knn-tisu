<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		table.data{
			border-collapse: collapse;
			margin-bottom: 5px;
			margin-top: 25px;
			width: 50%;
		}
		table.data td{
			padding: 3px 7px;

		}

		table.data td.textcenter{
			text-align: center;
			font-weight: bold;

		}
	</style>
</head>
<body>
	<table class="data" border="1">
	<tr>
		<th width="60px">No.</th>
		<th>X1 (Daya tahan asam (detik))</th>
		<th>X2 (Kekuatan (Kg/m2))</th>
		<th>Y (Klasifikasi)</th>
	</tr>

	<?php
	include 'koneksi.php';

	$sql = mysqli_query($con, "SELECT * FROM kualitas_tisu") or die(mysqli_error($con));
	if(mysqli_num_rows($sql) > 0){
		$no = 0;
		$basis_kasus = array();
		$label_kasus = array();
		while ($data = mysqli_fetch_array($sql)) {
			$basis_kasus[$no][0] = $data['x1'];
			$basis_kasus[$no][1] = $data['x2'];
			$label_kasus[$no] = $data['y'];
			
			echo '<tr><td class="textcenter">'.++$no.'</td>
			<td>'.$data['x1'].'</td>
			<td>'.$data['x2'].'</td>
			<td>'.$data['y'].'</td>
			</tr>';
			
		}
	}
	?>	
	</table>

	<table>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<tr>
			<td>X1 (Daya tahan asam (detik))</td>
			<td>:</td>
			<td><input type="text" name="x1" value="<?php echo isset($_POST['x1']) ? $_POST['x1'] : '';?>"></td>
		</tr>
		<tr>
			<td>X2 (Kekuatan (Kg/m2))</td>
			<td>:</td>
			<td><input type="text" name="x2" value="<?php echo isset($_POST['x2']) ? $_POST['x2'] : '';?>"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td><input type="submit" name="submit" value="Prediksi"></td>
		</tr>	
	</form>
	</table><br/>

	<?php
	if (isset($_POST['submit'])):
		require_once('knn.php');
		require_once('distance.php');
		
		$kasus_baru[0] = $_POST['x1'];
		$kasus_baru[1] = $_POST['x2'];
	?>

	<table class="data" border="1">
	<tr>
		<th width="60px">No.</th>
		<th>X1 (Daya tahan asam (detik))</th>
		<th>X2 (Kekuatan (Kg/m2))</th>
		<th>Y (Klasifikasi)</th>
		<th width="180px">Jarak</th>
	</tr>

	<?php
		$sql = mysqli_query($con, "SELECT * FROM kualitas_tisu") or die(mysqli_error($con));
		if(mysqli_num_rows($sql) > 0){
			$no = 0;
			while ($data = mysqli_fetch_array($sql)) {
				array_push($basis_kasus, array($data['x1'], $data['x2']));
				array_push($label_kasus, $data['y']);

				$distance = new Distance();
				$jarak = $distance->squaredEuclidean($basis_kasus[$no], $kasus_baru);

				$rumus = cetak_rumus_jarak($basis_kasus[$no], $kasus_baru, 'squaredEuclidean');

				echo '<tr><td class="textcenter">'.++$no.'</td>
				<td>'.$data['x1'].'</td>
				<td>'.$data['x2'].'</td>
				<td>'.$data['y'].'</td>
				<td>'.$rumus.' = '.round($jarak,0).'</td>
				</tr>';
			}
		}
?>
	</table>

	<table class="data" border="1">
	<tr>
		<th width="60px">Data No.</th>
		<th>X1 (Daya tahan asam (detik))</th>
		<th>X2 (Kekuatan (Kg/m2))</th>
		<th>Y (Klasifikasi)</th>
		<th width="180px">Jarak</th>
	</tr>
	<?php
		$ranking = array();
		$jarak   = array();

		$knn = new knn($basis_kasus, $kasus_baru, 3,'squaredEuclidean');
		$rangking = $knn->get_knn();
		$jarak = $knn->get_distance();
		
		$i = 0;
		
		foreach ($rangking as $key => $value) {
			echo '<tr><td class="textcenter">'.($value+1).'</td>
					<td>'.$basis_kasus[$value][0].'</td>
					<td>'.$basis_kasus[$value][1].'</td>
					<td>'.$label_kasus[$value].'</td>
					<td>'.$jarak[$i].'</td>
					</tr>';
			$i++;
		}

	?>		
	</table>

<?php endif;?>
</body>
</html>


<?php

function cetak_rumus_jarak($basis_kasus, $kasus_baru, $distanceMethode = 'euclidean'){
	$text = '';
	$jum_kasus = count($basis_kasus);
    
    switch ($distanceMethode) {
        case 'euclidean':
        	$text .= '&#8730';
            for ($i = 0; $i < $jum_kasus; $i++) {
				$text .= '('.$basis_kasus[$i].'-'.$kasus_baru[$i].')<sup>2</sup>';
				
				if($i <> ($jum_kasus-1)) $text .= ' + ';
			}        
            break;
        case 'squaredEuclidean':
            for ($i = 0; $i < $jum_kasus; $i++) { 
				$text .= '('.$basis_kasus[$i].'-'.$kasus_baru[$i].')<sup>2</sup>';
				
				if($i <> ($jum_kasus-1)) $text .= ' + ';
			}
            break;
        case 'manhattan':
            for ($i = 0; $i < $jum_kasus; $i++) { 
				$text .= 'abs('.$basis_kasus[$i].'-'.$kasus_baru[$i].')';
				
				if($i <> ($jum_kasus-1)) $text .= ' + ';
			}
            break;
        case 'cosinus':
            break;
    }

	return $text;
}
?>