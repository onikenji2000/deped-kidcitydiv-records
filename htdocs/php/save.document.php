<?php
$sqlitedb = new SQLite3("./db/record.db");

$date_rec = $_POST['date_rec'];
$doc_code = $_POST['doc_code'];
$title = $_POST['title'];
$prep_by = $_POST['rec_prepared'];
$courier = $_POST['author'];

$files = $_FILES['upload_file']['tmp_name'];
$file_type = explode(".", $_FILES['upload_file']['name']);
$file_type = $file_type[count($file_type) - 1];

$doc_type = $_POST['rec_type'];
$tags = explode(",", $_POST['doc_tags']);

$save = $sqlitedb->exec("INSERT INTO document(doc_code, date_rec, doc_no, title, doc_type, prepared_by, courier_author) VALUES".
		"('" . $doc_code . "', '" . $date_rec . "', 0, '" . $title . "', '" . $doc_type . "', '" . $prep_by . "', '" . $courier . "')");

if($save) {
	$datetrap = explode("-", $date_rec);
	$year = $datetrap[0];
	$mon = $datetrap[1];
	$dateObj = DateTime::createFromFormat('!m', $mon);
	$monthName = $dateObj->format('F');
	
	$dir = 'uploads/' . $year;
	mkdir($dir);
	$dir = $dir . "/" . $monthName;
	mkdir($dir);
	
	$file_name = $doc_code . "-" . (rand(1000, 9999)) . "." . $file_type;
	
	$file_dir = $dir . "/" . $file_name;
	move_uploaded_file($files, $file_dir);
	
	$save = $sqlitedb->exec("INSERT INTO doc_file (doc_code, file_name, file_type) VALUES('" . $doc_code . "', '" . $file_dir . "', '" . $file_type . "')");
	for($i = 0; $i < count($tags); $i++) {
		$save += $sqlitedb->exec("INSERT INTO doc_tag (doc_code, tag_name) VALUES ('" . $doc_code . "', '" . $tags[$i] . "')");
	}
	echo $save;
}
?>