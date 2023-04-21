<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<meta charset="UTF-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel='stylesheet' href='style.css'>
	</head>
	<body>
		<div class="container my-5 text-center">
			<h1>Fotoregistro</h1>
			<div class='row'>
				<div class='col my-5 text-center homePanel mx-5' id='studentDiv'>
					<p class='panelTitle'>Sei uno studente? 📚</p><br />
					<button id='loginButtonStudent' class='btn' data-bs-target='#loginModalStudent' data-bs-toggle='modal'>Login</button><br />
					<button id='signupButtonStudent' class='btn' data-bs-target='#signupModalStudent' data-bs-toggle='modal'>Registrati</button><br />
				</div>
				<div class='col my-5 text-center homePanel mx-5' id='teacherDiv'>
					<p class='panelTitle'>Sei un insegnante? 🧑‍🏫</p><br />
					<button id='loginButtonTeacher' class='btn' data-bs-target='#loginModalTeacher' data-bs-toggle='modal'>Login</button><br />
					<button id='signupButtonTeacher' class='btn' data-bs-target='#signupModalTeacher' data-bs-toggle='modal'>Registrati</button>
				</div>
			</div>
			<div id='loginModalStudent' class='modal fade' aria-hidden='true' aira-labelledby='loginModal'>
				<div class='modal-dialog modal-dialog-centered'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button class='btn-close' data-bs-dismiss='modal' aria-label='close'></button>
						</div>
						<div class='modal-body'>
							<h1>Login studente</h1>
							<form id='loginFormStudent'>
								<input type="email"    class="form-control my-2" id='loginEmailStudent'    placeholder='Email'>
								<input type="password" class="form-control my-2" id='loginPasswordStudent' placeholder='Password'>
								<input type="submit"   class='btn my-2'>
							</form>
							<div id='loginAlertStudent'>

							</div>
						</div>
					</div>					
				</div>
			</div>
			<div id='signupModalStudent' class='modal fade' aria-hidden='true' aira-labelledby='loginModal'>
				<div class='modal-dialog modal-dialog-centered'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button class='btn-close' data-bs-dismiss='modal' aria-label='close'></button>
						</div>
						<div class='modal-body'>
							<h1>Registrazione studente</h1>
							<form id='signupFormStudent'>
								<input type='text'     class='form-control my-2' id='signupNameStudent'            placeholder='Nome'>
								<input type='text'     class='form-control my-2' id='signupSurnameStudent'         placeholder='Cognome'>
								<input type='email'    class='form-control my-2' id='signupEmailStudent'           placeholder='Email'>
								<input type='password' class='form-control my-2' id='signupPasswordStudent'        placeholder='Password'>
								<input type='password' class='form-control my-2' id='signupConfirmPasswordStudent' placeholder='Conferma password'>
								<label for='showPassword'>Mostra password</label><input id='showPassword' class='my-2 mx-2' type='checkbox'><br />
								<input type="submit"   class='btn my-2'>
								<div id='signupAlertStudent'>

								</div>
							</form>
						</div>
					</div>					
				</div>
			</div>
			<div id='loginModalTeacher' class='modal fade' aria-hidden='true' aira-labelledby='loginModal'>
				<div class='modal-dialog modal-dialog-centered'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button class='btn-close' data-bs-dismiss='modal' aria-label='close'></button>
						</div>
						<div class='modal-body'>
							<h1>Login insegnante</h1>
							<form id='loginFormTeacher'>
								<input type="email"    class="form-control my-2" id='loginEmailTeacher'    placeholder='Email'>
								<input type="password" class="form-control my-2" id='loginPasswordTeacher' placeholder='Password'>
								<input type="submit"   class='btn my-2'>
							</form>
							<div id='loginAlertTeacher'>

							</div>
						</div>
					</div>					
				</div>
			</div>
			<div id='signupModalTeacher' class='modal fade' aria-hidden='true' aira-labelledby='loginModal'>
				<div class='modal-dialog modal-dialog-centered'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button class='btn-close' data-bs-dismiss='modal' aria-label='close'></button>
						</div>
						<div class='modal-body'>
							<h1>Registrazione insegnante</h1>
							<form id='signupFormTeacher'>
								<input type='text'     class='form-control my-2' id='signupNameTeacher'            placeholder='Nome'>
								<input type='text'     class='form-control my-2' id='signupSurnameTeacher'         placeholder='Cognome'>
								<input type='email'    class='form-control my-2' id='signupEmailTeacher'           placeholder='Email'>
								<input type='password' class='form-control my-2' id='signupPasswordTeacher'        placeholder='Password'>
								<input type='password' class='form-control my-2' id='signupConfirmPasswordTeacher' placeholder='Conferma password'>
								<label for='showPassword'>Mostra password</label><input id='showPasswordTeacher' class='my-2 mx-2' type='checkbox'><br />
								<input type="submit"   class='btn my-2'>
								<div id='signupAlertTeacher'>

								</div>
							</form>
						</div>
					</div>					
				</div>
			</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<script src="script.js"></script>
	</body>
</html>