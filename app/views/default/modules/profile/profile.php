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
									<div>Illutio</div>
									<div>Guadalajara, México</div>
									<div>APP ID: illutio</div>
									<div>dev@illut.io</div>
									<div>Plan Basic</div>
								</div>
								<div class="col-md-12">
									<hr>
									<div>
										<strong>Used tags:</strong>
										<div class="progress-container">
											<div><strong>5/20</strong></div>
											<div class="progress">
											  <div class="progress">
												  <div class="progress-bar"  role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
												    <span class="sr-only">25% Complete</span>
												  </div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div>
										<strong>Used space:</strong>
										<div class="progress-container">
											<div><strong>300MB/500MB</strong></div>
											<div class="progress">
											  <div class="progress">
												  <div class="progress-bar"  role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
												    <span class="sr-only">60%</span>
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
							<i class="fa fa-plus-circle fa-lg pull-right"></i>
						</div>
						<div>
							<form action="profile.php" method="post" role="form">
								<div class="row">
								    <div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="actual">Password</label>
										    <input name="password" type="password" class="form-control" id="actual">
										</div>
									</div>
									<div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="password">New password</label>
										    <input name="new_password" type="password" class="form-control" id="password">
										</div>
								    </div>
								    <div class="col-xs-12 col-md-4">
									    <div class="form-group">
										    <label for="confirm">Confirm</label>
										    <input name="new_password_confirm" type="password" class="form-control" id="confirm">
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
							<strong>Edit profile</strong>
						</div>
						<div>
							<form role="form">
								<div class="row">
								    <div class="col-xs-12 col-md-6">
									    <div class="form-group">
										    <label for="name">Name</label>
										    <input type="text" class="form-control" id="name" placeholder="Name">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
									    <div class="form-group">
										    <label for="email">Email</label>
										    <input type="text" class="form-control" id="nombre" placeholder="Email">
										</div>
								    </div>
								    <div class="col-xs-12 col-md-6">
									    <div class="form-group">
										    <label for="country">Country</label>
										    <select id="country" class="form-control">
										    	<option>México</option>
										    	<option>USA</option>
										    	<option>UK</option>
										    </select>
										</div>
								    </div>
								    <div class="col-xs-12 col-md-6">
									    <div class="form-group">
										    <label for="city">City</label>
										    <input type="text" class="form-control" id="city" placeholder="City">
										</div>
								    </div>
								    <div class="col-xs-12 col-md-12">
								    	<button type="button" class="btn btn-success pull-right" style="margin: 1em 0;">Save</button>
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
							<i class="fa fa-plus-circle fa-lg pull-right"></i>
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