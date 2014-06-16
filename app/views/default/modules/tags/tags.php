<div>
	<div class="row">
		<?php
			foreach ($data as $row):
		?>
		<div class="col-xs-12 col-md-4">
			<div class="seccion">
				<div class="titulo">
					<span class="titulo-tag">
						<?= $row['name'] ?>
					</span>
					<span class="titulo-botones pull-right">
						<i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="Disable"></i>
						<i class="fa fa-copy" data-toggle="tooltip" data-placement="top" title="Clone"></i>
						<i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
						<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete"></i>
					</span>
				</div>
				<div class="map">
                    <img src="<?= $row['map'] ?>" alt="<?= $row['name'] ?>">
                </div>
				<div class="links">
					<div>
						<span><i class="fa fa-fw fa-globe"></i></span>
						<span><a href="<?= $row['url'] ?>"><?= $row['url'] ?></a></span>
					</div>
					<div>
						<span><i class="fa fa-fw fa-facebook-square"></i></span>
						<span><a href="<?= $row['facebook'] ?>"><?= $row['facebook'] ?></a></span>
					</div>
					<div>
						<span><i class="fa fa-fw fa-twitter"></i></span>
						<span><a href="<?= $row['twitter'] ?>"><?= $row['twitter'] ?></a></span>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>