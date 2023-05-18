<?php
$sqlitedb = new SQLite3("./db/record.db");

$doc_code = $_GET['code'];

$rs = $sqlitedb->query("SELECT COUNT(*) AS count FROM document where doc_code like '" . $doc_code . "'");
$data = $rs->fetchArray();
echo $data['count'];
?>