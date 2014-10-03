		<div>
			<div class="row">
				<!-- div de detalles del perfil_________________________________________________ -->
				<div class="col-xs-12 col-md-4">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<section class="seccion">
								<div class="titulo" id="photosection">
									<span class="titulo-tag">
										<strong>#{PROFILE.PICTURE}#</strong>
									</span>
									<span class="titulo-botones pull-right">
										<i id="change-logo" class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="#{PROFILE.EDIT-LOGO}#"></i>
									</span>
								</div>
								<div>
									<input id="select-logo" type="file" style="display: none">
									<img id="photo" class="profile-photo" src="#{LOGO}#">
								</div>
							</section>
							<div>
								<section class="seccion">
									<div class="titulo">
										<strong>#{PROFILE.DETAIL}#</strong>
									</div>
									<div class="row">
										<div class="col-xs-12 col-md-12">
											<div class="col-md-12 profile-details">
												<div>#{NAME}#</div>
												<div>#{CITY}#, #{COUNTRY}#</div>
												<div>APP ID: #{NICK}#</div>
												<div>#{EMAIL}#</div>
												<div>#{PLAN}#</div>
											</div>
											<div class="col-md-12 profile-details">
												<hr>
												<div>
													<strong>#{PROFILE.USEDPLACES}#:</strong>
													<div class="progress-container">
														<div><strong>#{USEDTAGS}#/#{TOTALTAGS}#</strong></div>
														<div class="progress">
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="#{PERCENTAGETAGS}#" aria-valuemin="0" aria-valuemax="100" style="width: #{PERCENTAGETAGS}#%">
																	<span class="sr-only">#{PERCENTAGETAGS}#%</span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div>
													<strong>#{PROFILE.USEDSPACE}#:</strong>
													<div class="progress-container">
														<div><strong>#{USEDSPACE}#MB/#{TOTALSPACE}#MB</strong></div>
														<div class="progress">
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="#{PERCENTAGESPACE}#" aria-valuemin="0" aria-valuemax="100" style="width: #{PERCENTAGESPACE}#%">
																	<span class="sr-only">#{PERCENTAGESPACE}#%</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
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
									<strong>#{PROFILE.PASSWORD-CHANGE}#</strong>
								</div>
								<div>
									<form action="ajax/change_password.php" method="post" role="form">
										<div class="row">
											<div class="col-xs-12 col-md-4">
												<div class="form-group">
													<label for="actual">#{PROFILE.PASSWORD-CURRENT}#</label>
													<input name="password" type="password" class="form-control" id="actual" pattern=".{6,}" required="" title="#{PROFILE.VAL-MIN6}#">
												</div>
											</div>
											<div class="col-xs-12 col-md-4">
												<div class="form-group">
													<label for="password">#{PROFILE.PASSWORD-NEW}#</label>
													<input name="new_password" type="password" class="form-control" id="password" pattern=".{6,}" required="" title="#{PROFILE.VAL-MIN6}#">
												</div>
											</div>
											<div class="col-xs-12 col-md-4">
												<div class="form-group">
													<label for="confirm">#{PROFILE.PASSWORD-CONFIRM}#</label>
													<input name="new_password_confirm" type="password" class="form-control" id="confirm" pattern=".{6,}" required="" title="#{PROFILE.VAL-MIN6}#">
												</div>
											</div>
											<div class="col-xs-12 col-md-12">
												<input name="password_form" type="submit" value="#{PROFILE.PASSWORD-CHANGE}#" class="btn btn-success pull-right" style="margin: 1em 0;">
											</div>
										</div>
									</form>
								</div>
							</section>
						</div>
						<div class="col-md-12">
							<section class="seccion">
								<div class="titulo">
									<strong>#{PROFILE.LANGUAGE}# (beta)</strong>
								</div>
								<div>
									<form role="form">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group" style="margin:1em 0 !important">
													<select id="language" class="form-control">
														<option value="">---</option>
														<option value="Spanish">#{PROFILE.LANGUAGE-SPANISH}#</option>
														<option value="English">#{PROFILE.LANGUAGE-ENGLISH}#</option>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<button id="change-language" type="button" class="btn btn-success pull-right" style="margin: 1em 0;">#{PROFILE.LANGUAGE-SELECT}#</button>
											</div>
										</div>
									</form>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>