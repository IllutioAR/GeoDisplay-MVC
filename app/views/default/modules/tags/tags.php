<div>
	<div class="row">
		<div class="col-xs-12 col-md-4">
			<div class="seccion" onclick="window.location.href = 'addtag.php'" style="cursor:pointer">
				<div class="new-tag">
					<div class="parent-container" style="height:inherit">
						<div class="child-container" style="color: #60af31">
							<div>
								<i class="fa fa-plus-circle icon-lg"></i>
							</div>
							<div class="text-lg">
								#{INDEX.ADDTAG}#
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			foreach ($data as $row):
		?>
		<div class="col-xs-12 col-md-4" id="tagInfo">
			<div class="seccion" tag-id="<?= $row['id'] ?>">
				<div class="titulo">
					<span class="titulo-tag">
						<?= $row['name'] ?>
					</span>
					<span class="titulo-botones pull-right">
						<i id="disable" class="fa fa-flag" data-toggle="tooltip" data-placement="top" title="#{DISABLE}#"></i>
						<i id="clone" class="fa fa-copy" data-toggle="tooltip" data-placement="top" title="#{INDEX.COPY}#"></i>
						<i id="edit" class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="#{INDEX.EDIT}#"></i>
						<i id="delete" class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="#{INDEX.DELETE}#"></i>
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
	</div>
</div>