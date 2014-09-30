<div class="col-xs-12 col-md-8">
	<section class="seccion">
		<div class="titulo">
			<strong>#{MULTIMEDIA.TITLE-FILES}#</strong>
			<span class="pull-right">
				<!--
				<i class="fa fa-th-list" data-toggle="tooltip" data-placement="top" title="See as a list."></i>
				<i class="fa fa-th" data-toggle="tooltip" data-placement="top" title="See as icons."></i>
				-->
			</span>
		</div>
		<div>
			<div class="row" style="text-align:center">
				<!--
				<div class="col-xs-2">
					<div class="file-container">
						<div class="file-preview">
							<img src="img/files/default.png" alt="file-preview">
						</div>
						<div class="file-name"><?= $file ?></div>
					</div>
				</div>
				-->
				<div class="col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#{MULTIMEDIA.NAME}#</th>
									<th style="text-align:right">#{MULTIMEDIA.SIZE}#</th>
									<th>#{MULTIMEDIA.DATEUPLOADED}#</th>
									<th>#{MULTIMEDIA.ACTION}#</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($files as $file): ?>
								<tr id="file">
									<td style="vertical-align: middle"><?= $file["name"] ?></td>
									<td style="vertical-align: middle; text-align:right"><?= number_format($file["size"], 2) ?>MB</td>
									<td style="vertical-align: middle"><?= $file["created_at"] ?></td>
									<td><button class="btn btn-danger btn-sm" 
											<?= ( isset($file["id"]) )? 'id="'.$file['id'].'"' : '' ?>
											<?= ( !isset($file["id"]) )? "disabled" : "" ?>
										>
										<i id="delete" class="fa fa-trash-o"></i> #{MULTIMEDIA.BUTTON-DELETE}#</button></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>