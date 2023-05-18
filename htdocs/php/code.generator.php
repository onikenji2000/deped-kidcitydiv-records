<?php
$sql = new SQLite3('./db/record.db');

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Division Memo' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Division Advisory' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Office Memo' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Deped Order' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Deped Memo' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Deped Advisory' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Regional Memo' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Regional Advisory' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Communication' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1] . ',';
else echo '0,';

$rs = $sql->query("SELECT * FROM document WHERE doc_type LIKE 'Report' ORDER BY doc_code DESC");
if($rs = $rs->fetchArray()) echo explode('-', $rs['doc_code'])[1];
else echo '0,';
?>