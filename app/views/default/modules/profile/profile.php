<div>
			<div class="row">
				<!-- div de detalles del perfil_________________________________________________ -->
				<div class="col-xs-12 col-md-4">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<section class="seccion">
								<div class="titulo" id="photosection">
									<strong>Foto de perfil</strong>
								</div>
								<div>
									<div class="row">
										<div id="photoContainer" class="col-xs-3 col-md-4">
											<img id="photo" class="profile-photo" src="https://www.google.com.mx/images/srpr/logo11w.png">
										</div>
									</div>
								</div>
							</section>
							<div>
								<section class="seccion">
									<div class="titulo">
										<strong>Detalles de perfil</strong>
									</div>
									<div class="row">
										<div class="col-xs-12 col-md-12">
											<div class="col-xs-9 col-md-8 profile-details">
												<div>#{NAME}#</div>
												<div>#{CITY}#, #{COUNTRY}#</div>
												<div>APP ID: #{NICK}#</div>
												<div>#{EMAIL}#</div>
												<div>#{PLAN}#</div>
											</div>
											<div class="col-md-12">
												<hr>
												<div>
													<strong>Puntos usados:</strong>
													<div class="progress-container">
														<div><strong>6/200</strong></div>
														<div class="progress">
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100" style="width: 3%">
																	<span class="sr-only">3%</span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div>
													<strong>Espacio utilizado:</strong>
													<div class="progress-container">
														<div><strong>333.87MB/500 MB</strong></div>
														<div class="progress">
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="width: 67%">
																	<span class="sr-only">67%</span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Termina div de detalles del perfil ___________________________________________-->
					<div class="col-xs-12 col-md-8">
						<div class="row">
							<div class="col-md-12">
								<section class="seccion">
									<div class="titulo">
										<strong>Contraseña</strong>
									</div>
									<div>
										<form action="ajax/change_password.php" method="post" role="form">
											<div class="row">
												<div class="col-xs-12 col-md-4">
													<div class="form-group">
														<label for="actual">Contraseña actual</label>
														<input name="password" type="password" class="form-control" id="actual" pattern=".{6,}" required="" title="6 caracteres mínimo">
													</div>
												</div>
												<div class="col-xs-12 col-md-4">
													<div class="form-group">
														<label for="password">Nueva contraseña</label>
														<input name="new_password" type="password" class="form-control" id="password" pattern=".{6,}" required="" title="6 caracteres mínimo">
													</div>
												</div>
												<div class="col-xs-12 col-md-4">
													<div class="form-group">
														<label for="confirm">Confirmar contraseña</label>
														<input name="new_password_confirm" type="password" class="form-control" id="confirm" pattern=".{6,}" required="" title="6 caracteres mínimo">
													</div>
												</div>
												<div class="col-xs-12 col-md-12">
													<input name="password_form" type="submit" value="Cambiar contraseña" class="btn btn-success pull-right" style="margin: 1em 0;">
												</div>
											</div>
										</form>
									</div>
								</section>
							</div>
							<div class="col-md-12">
								<section class="seccion">
									<div class="titulo">
										<strong>Idioma</strong>
									</div>
									<div>
										<form role="form">
											<div class="row">
												<div class="col-xs-12 col-md-6">
													<div class="form-group" style="margin:1em 0 !important">
														<select id="language" class="form-control">
															<option>Español</option>
															<option>Inglés</option>
															<option>Alemán</option>
														</select>
													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<button type="button" class="btn btn-success pull-right" style="margin: 1em 0;">Seleccionar idioma</button>
												</div>
											</div>
										</form>
									</div>
								</section>
							</div>
							<!-- Sección de forma de país___________________________________________________ -->
							<div class="col-md-12">
								<section class="seccion">
									<div class="titulo">
										<strong>General</strong>
									</div>
									<div>
										<form role="form">
											<div class="row">
												<div class="col-xs-12 col-md-6">
													<label for="pais">País</label>
													<div class="form-group" style="margin:1em 0 !important">

														<select id="country" class="form-control">
															<option>México</option>
															<option>Estados Unidos</option>
															<option>Inglaterra</option>
															<option>Alemania</option>
														</select>
													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<label for="pais">Ciudad</label>
													<div class="form-group" style="margin:1em 0 !important">
														<input id="city" class="form-control" type="text" required="">
													</input>
												</div>
											</div>
											<div class="col-xs-12 col-md-12">
												<button type="button" class="btn btn-success pull-right" style="margin: 1em 0;">Guardar</button>
											</div>
										</div>
									</form>
								</div>
							</section>
						</div>
						<!-- Termina sección de forma de país____________________________________________ -->
					</div>
				</div>
			</div>
		</div>