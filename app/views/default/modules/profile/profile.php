<div>
	<div class="row">
		<div class="col-xs-12 col-md-4">
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<section class="seccion">
						<div class="titulo">
							<strong>Profile details</strong>
						</div>
						<div>
							<div class="row">
								<div class="col-xs-3 col-md-4">
									<img class="profile-photo" src="media/profile/default-logo.png">
								</div>
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
										<strong>Used tags:</strong>
										<div class="progress-container">
											<div><strong>#{USEDTAGS}#/#{TOTALTAGS}#</strong></div>
											<div class="progress">
											  <div class="progress">
												  <div class="progress-bar"  role="progressbar" aria-valuenow="#{PERCENTAGETAGS}#" aria-valuemin="0" aria-valuemax="100" style="width: #{PERCENTAGETAGS}#%">
												    <span class="sr-only">#{PERCENTAGETAGS}#% Complete</span>
												  </div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div>
										<strong>Used space:</strong>
										<div class="progress-container">
											<div><strong>#{USEDSPACE}#MB/#{TOTALSPACE}#MB</strong></div>
											<div class="progress">
											  <div class="progress">
												  <div class="progress-bar"  role="progressbar" aria-valuenow="#{PERCENTAGESPACE}#" aria-valuemin="0" aria-valuemax="100" style="width: #{PERCENTAGESPACE}#%">
												    <span class="sr-only">#{PERCENTAGESPACE}#%</span>
												  </div>
												</div>
											</div>
										</div>
									</div>
									<hr>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-8">
			<div class="row">
				<div class="col-md-12">
					<section class="seccion">
						<div class="titulo">
							<strong>Password</strong>
						</div>
						<div>
							<form action="profile.php" method="post" role="form">
								<div class="row">
								    <div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="actual">Password</label>
										    <input name="password" type="password" class="form-control" id="actual" pattern=".{6,}" required title="6 characters minimum" required>
										</div>
									</div>
									<div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="password">New password</label>
										    <input name="new_password" type="password" class="form-control" id="password" pattern=".{6,}" required title="6 characters minimum" required>
										</div>
								    </div>
								    <div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="confirm">Confirm</label>
										    <input name="new_password_confirm" type="password" class="form-control" id="confirm" pattern=".{6,}" required title="6 characters minimum" required>
										</div>
								    </div>
								    <div class="col-xs-12 col-md-12">
								    	<input name="password_form" type="submit" value="Change password" class="btn btn-success pull-right" style="margin: 1em 0;">
								    </div>
								</div>
							</form>
						</div>
					</section>
				</div>
				<div class="col-md-12">
					<section class="seccion">
						<div class="titulo">
							<strong>Language</strong>
						</div>
						<div>
							<form role="form">
								<div class="row">
								    <div class="col-xs-12 col-md-6">
									    <div class="form-group" style="margin:1em 0 !important">
										    <select id="language" class="form-control">
										    	<option>Spanish</option>
										    	<option>English</option>
										    	<option>German</option>
										    </select>
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<button type="button" class="btn btn-success pull-right" style="margin: 1em 0;">Select language</button>
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