<div class="col-xs-12 col-md-8">
	<section class="seccion">
		<div class="titulo">
			<strong>Files</strong>
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
						<table class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Size</th>
									<th>Uploaded</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($files as $file): ?>
								<tr>
									<td><?= $file["name"] ?></td>
									<td><?= $file["size"] ?></td>
									<td><?= $file["created_at"] ?></td>
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