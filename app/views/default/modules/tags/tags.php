<div>
	<div class="row">
		<?php
			foreach ($tsArray as $data):
		?>
		<div class="col-xs-12 col-md-4">
			<div class="seccion">
				<div class="titulo">
					<span class="titulo-tag">
						<?php echo $data['name'] ?>
					</span>
					<span class="titulo-botones pull-right">
						<i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="Disable"></i>
						<i class="fa fa-copy" data-toggle="tooltip" data-placement="top" title="Clone"></i>
						<i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
						<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete"></i>
					</span>
				</div>
				<div class="map">
                    <img src="<?php echo $data['map'] ?>" alt="<?php echo $data['name'] ?>">
                </div>
				<div class="links">
					<div>
						<span><i class="fa fa-fw fa-globe"></i></span>
						<span><a href="<?php echo $data['url'] ?>"><?php echo $data['url'] ?></a></span>
					</div>
					<div>
						<span><i class="fa fa-fw fa-facebook-square"></i></span>
						<span><a href="<?php echo $data['facebook'] ?>"><?php echo $data['facebook'] ?></a></span>
					</div>
					<div>
						<span><i class="fa fa-fw fa-twitter"></i></span>
						<span><a href="<?php echo $data['twitter'] ?>"><?php echo $data['twitter'] ?></a></span>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>