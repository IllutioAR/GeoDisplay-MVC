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
				<?php 
					foreach($files as $file): 
				?>
				<div class="col-xs-2">
					<div class="file-container">
						<div class="file-preview">
							<img src="media/default/files/default.png" alt="file-preview">
						</div>
						<div class="file-name"><?= $file ?></div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</div>