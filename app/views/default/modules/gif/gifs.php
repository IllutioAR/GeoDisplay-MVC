<div>
	<div class="row">
		<div class="col-xs-12 col-md-4">
			<div class="seccion" onclick="window.location.href = 'addgif.php'" style="cursor:pointer">
				<div class="new-rally">
					<div class="parent-container" style="height:inherit">
						<div class="child-container" style="color: #60af31">
							<div>
								<i class="fa fa-plus-circle icon-lg"></i>
							</div>
							<div class="text-lg">
								#{GIF.ADDGIF}#
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			foreach($data as $row):
		?>
		<div class="col-xs-12 col-md-4" id="tagInfo">
			<div class="seccion rally-seccion" gif-id="<?= $row['id'] ?>">
				<div class="titulo">
					<span class="titulo-tag">
						<?= $row['name'] ?>
					</span>
					<span class="titulo-botones pull-right">
						<i id="delete" class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="#{GIF.DELETE}#"></i>
					</span>
				</div>
				<div class="image">
                    <img src="<?= $row['gif'] ?>" alt="<?= $row['name'] ?>">
                </div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>