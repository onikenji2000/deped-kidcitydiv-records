<?php
$sql = new SQLite3('./db/record.db');

$file = $_FILES['file_attachment']['tmp_name'];
$file_det = explode('.', $_FILES['file_attachment']['name']);
if(strcmp($file, '') != 0) {
	$file_type = $file_det[count($file_det) - 1];

	$doc_code = $_POST['barcode'];
	$date_rec = $_POST['date_rec'];
	///////////////////Upload File
	$datetrap = explode("-", $date_rec);
	$year = $datetrap[0];
	$mon = $datetrap[1];
	$dateObj = DateTime::createFromFormat('!m', $mon);
	$monthName = $dateObj->format('F');

	$dir = 'uploads/' . $year;
	$dir = $dir . "/" . $monthName;

	$file_name = $doc_code . "-" . (rand(1000, 9999)) . "." . $file_type;

	$file_dir = $dir . "/" . $file_name;
	move_uploaded_file($file, $file_dir);
	/////////////////////////////////////

	$save = $sql->exec("INSERT INTO doc_file(doc_code, file_name, file_type) VALUES('" . $doc_code . "', '" . $file_dir . "', '" . $file_type . "')");
	echo $save;
}
else echo 0;
?>