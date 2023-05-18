<?php

$sqlitedb = new SQLite3("./db/record.db");
$doc_code = $_GET['code'];
$first_file = '';
$first_type = '';
$rs = $sqlitedb->query("SELECT * FROM document WHERE doc_code LIKE '" . $doc_code . "'");

$document = $rs->fetchArray();
?>
<div class="row">
	<div class="col-md-8">
		<div class="row hodor">
			<div class="col-sm-5">
				<div class="form-group">
					<label>Document Code:<label>
					<label><h4 id="doc_code_label"><?php echo $document['doc_code']; ?></h4></label>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="form-group">
					<label>Date Received:</label>
					<label><h4 id="date_rec"><?php echo $document['date_rec']; ?></h4></label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="form-group">
					<button class="badge" onclick="editDocument(<?php echo "'" . $doc_code . "'";?>)">edit</button>
				</div>
			</div>
		</div>
		<div class="row hodor">
			<div class="col-sm-8">
				<div class="form-group">
					<label>Document Title:</label>
					<label><h4><?php echo $document['title']; ?></h4></label>
				</div>
			</div>
		</div>
		<div class="row hodor">
			<div class="col-sm-5">
				<div class="form-group">
					<label>Origin:</label>
					<label><h4><?php echo $document['prepared_by']; ?></h4></label>
					<label class="badge"><?php echo $document['courier_author']; ?></label>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="form-group">
					<label>Document Type</label>
					<label><?php echo $document['doc_type']; ?></label>
				</div>
			</div>
		</div>
		<div class="row hodor">
			<div class="col-sm-8">
				<div class="form-group">
					<label>Document Tags:</label>
					<?php
					$rs = $sqlitedb->query("SELECT * FROM doc_tag WHERE doc_code LIKE '" . $doc_code . "'");
					while ($rows = $rs->fetchArray()) {
					?>
					<span class="label label-info"><?php echo $rows['tag_name']; ?></span>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="row hodor">
			<div class="col-sm-8">
				<div class="form-group">
					<label>Files</label>
					<?php
					$rs = $sqlitedb->query("SELECT * FROM doc_file WHERE doc_code LIKE '" . $doc_code . "'");
					$count = 1;
					while($row = $rs->fetchArray()) {
							$first_file = $row['file_name'];
							$first_type = $row['file_type'];
						?>
						<button class="label label-success" onclick="open_file('<?php echo $row['file_name'];
						?>', '<?php echo $row['file_type']; ?>')">file<?php echo $count; ?></button>
						<?php
						$count++;
					}
					?>
					<form id="file_uform">
						<input type="file" class="form-control" id="file_attachment" name="file_attachment">
						<button class="btn btn-success" type="submit">Attach selected file</button>
					</form>
				</div>
			</div>
		</div>
		<div class="row hodor">
			<div class="col-sm-8">
				<div class="form-group">
					<label>Routing History</label>
					<table class="table table-hover">
						<tr>
							<th>Date</th>
							<th>Received by</th>
							<th>User Code</th>
							<th>Remarks</th>
						</tr>
						<tr>
							<td>2018-01-20</td>
							<td>Charles Louie M Siplao</td>
							<td><div class="qrme" id="qrcode1" data-role="4784uirtyyudtrur63746qrt">4784uirtyyudtrur63746qrt</div></td>
							<td>Internal</td>
						</tr>
					</table>
					<button class="btn btn-warning">Route to Outgoing</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4" id="file_holder">
		<?php
		if(strcmp($first_type, 'pdf') == 0) {
		?>
			<object data="php/<?php echo $first_file; ?>" width="100%" height="100%">
				alt: <a href="php/<?php echo $first_file; ?>">file cant be open, click to download file</a>
			</object>
		<?php
		} else if(strcmp($first_type, 'png') == 0 || strcmp($first_type, 'jpg') == 0 || strcmp($first_type, 'bmp') == 0 || strcmp($first_type, 'gif') == 0) {
		?>
			<img src="php/<?php echo $first_file; ?>" width="100%" height="100%">
		<?php
		}
		?>
	</div>
</div>