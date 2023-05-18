<?php

$date_rec = null;
$doc_code = null;
$doc_title = null;
$prep_by = null;
$authcour = null;
$doc_type = null;

if(isset($_GET['doc_code'])) {
	$sql = new SQLite3('./db/record.db');
	$rs = $sql->query("SELECT * FROM document WHERE doc_code LIKE '" . $_GET['doc_code'] . "'");
	$rs = $rs->fetchArray();
	$date_rec = $rs['date_rec'];
	$doc_code = $rs['doc_code'];
	$doc_title = $rs['title'];
	$prep_by = $rs['prepared_by'];
	$authcour = $rs['courier_author'];
	$doc_type = $rs['doc_type'];
}
?>
<form name="newCode" id="newCodeForm" method="post" action="php/save.document.php">
	<div class="row">
		<div class="col-sm-2">
			<div class="form-group">
				<label>Date</label>
				<input type="date" id="date_rec" class="form-control" value="<?php
					if($date_rec != null) echo $date_rec;
					else echo date("Y-m-d");
				?>" name="date_rec" required>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Document Code</label>
				<input type="text" class="form-control" value="<?php
					if($doc_code != null) echo $doc_code;
					else echo $_GET['code'];
				?>" name="doc_code" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Document Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $doc_title;?>" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Origin</label>
				<select class="form-control input-sm" id="rec_prepared" name="rec_prepared" required>
					<option value="Division Office" <?php if(strcmp($prep_by, 'Division Office') == 0) echo 'selected'; ?>>Division Office</option>
					<option value="School" <?php if(strcmp($prep_by, 'School') == 0) echo 'selected'; ?>>School</option>
					<option value="Other Agencies" <?php if(strcmp($prep_by, 'Other Agencies') == 0) echo 'selected'; ?>>Other Agencies</option>
				</select>
				<input type="text" class="form-control" placeholder="Author/Courier" name="author" value="<?php
					if($authcour != null) echo $authcour;
				?>" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2" <?php
			if($doc_code != null) echo 'style="display: none;"';
		?>>
			<div class="form-group">
				<label id="file_to_upload">File</label>
				<div class="fileUpload btn btn-primary">
					<span>Choose File</span>
					<input type="file" class="upload" id="upload_file" name="upload_file" required>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<label>Document Type</label>
				<select class="form-control input-sm" id="rec_type" name="rec_type" required>
					<option value="Division Memo" <?php  if(strcmp('Division Memo', $doc_type) == 0) echo 'selected';?>>Division Memo</option>
					<option value="Division Advisory" <?php  if(strcmp('Division Advisory', $doc_type) == 0) echo 'selected';?>>Division Advisory</option>
					<option value="Office Memo" <?php  if(strcmp('Office Memo', $doc_type) == 0) echo 'selected';?>>Office Memo</option>
					<option value="Deped Order" <?php  if(strcmp('Deped Order', $doc_type) == 0) echo 'selected';?>>Deped Order</option>
					<option value="Deped Memo" <?php  if(strcmp('Deped Memo', $doc_type) == 0) echo 'selected';?>>Deped Memo</option>
					<option value="Deped Advisory" <?php  if(strcmp('Deped Advisory', $doc_type) == 0) echo 'selected';?>>Deped Advisory</option>
					<option value="Regional Memo" <?php  if(strcmp('Regional Memo', $doc_type) == 0) echo 'selected';?>>Regional Memo</option>
					<option value="Regional Advisory" <?php  if(strcmp('Regional Advisory', $doc_type) == 0) echo 'selected';?>>Regional Advisory</option>
					<option value="Communication" <?php  if(strcmp('Communication', $doc_type) == 0) echo 'selected';?>>Communication</option>
					<option value="Report" <?php  if(strcmp('Report', $doc_type) == 0) echo 'selected';?>>Report</option>
				</select>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<label>Document Tags</label>
				<?php if($doc_code == null) { ?><input class="form-control" type="text" data-role="tagsinput" id="doc_tags" name="doc_tags"><?php } ?>
				<?php if($doc_code != null) { ?><select multiple data-role="tagsinput" class="form-control" id="doc_tags" name="doc_tags">
					<?php
					$rs = $sql->query("SELECT * FROM doc_tag WHERE doc_code LIKE '" . $doc_code . "'");
					while($row = $rs->fetchArray()) {
						?>
						<option value="<?php echo $row['tag_name']; ?>"><?php echo $row['tag_name']; ?></option>
						<?php
					}
					?>
				</select><?php } ?>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<input class="form-control btn btn-success btn-md" type="submit" value="Add Entry">
			</div>
		</div>
		
	</div>
</form>