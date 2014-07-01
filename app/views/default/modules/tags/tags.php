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
					<span class="titulo-botones pull-right" tag-id="<?= $row['id'] ?>">
						<i id="disable" class="fa fa-flag" data-toggle="tooltip" data-placement="top" title="Deshabilitar"></i>
						<i id="clone" class="fa fa-copy" data-toggle="tooltip" data-placement="top" title="Copiar"></i>
						<i id="edit" class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar"></i>
						<i id="delete" class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
					</span>
				</div>
				<div class="map">
                    <img src="<?= $row['map'] ?>" alt="<?= $row['name'] ?>">
                </div>
				<div class="links">
					<div class="info">
						<i class="fa fa-fw fa-globe"></i>
						<a href="<?= $row['url'] ?>"><?= $row['url'] ?></a>
					</div>
					<div class="info">
						<i class="fa fa-fw fa-facebook-square"></i>
						<a href="<?= $row['facebook'] ?>"><?= $row['facebook'] ?></a>
					</div>
					<div class="info">
						<i class="fa fa-fw fa-twitter"></i>
						<a href="<?= $row['twitter'] ?>"><?= $row['twitter'] ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="col-xs-12 col-md-4">
			<div class="seccion">
				<div class="titulo">
					<span class="titulo-tag">
						Nombre
					</span>
					<span class="titulo-botones pull-right">
						<i class="fa fa-flag"></i>
						<i class="fa fa-copy"></i>
						<i class="fa fa-pencil"></i>
						<i class="fa fa-trash-o"></i>
					</span>
				</div>
				<div class="links">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/tags.js"></script>