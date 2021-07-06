<?php
namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;

class Register {
	private $authorsTable;

	public function __construct(DatabaseTable $authorsTable) {
		$this->authorsTable = $authorsTable;
	}

	public function registrationForm() {
		return ['template' => 'register.html.php', 
				'title' => 'Register an account'];
	}


	public function success() {
		return ['template' => 'registersuccess.html.php', 
			    'title' => 'Registration Successful'];
	}

	public function registerUser() {
		$author = $_POST['author'];

		$valid = true;
		$errors = [];

		/* 5/27/20 DavidR NEW 4L: Changed to fname*/
		if (empty($author['fname'])) {
			$valid = false;
			$errors[] = 'First name cannot be blank';
		}
        
        /* 5/27/20 DavidR NEW 4L: Created a new set of jokes list which only display upper body workout info*/
        if (empty($author['lname'])) {
            $valid = false;
            $errors[] = 'Last name cannot be blank';
        }

		if (empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		}
		else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		}
		else { //if the email is not blank and valid:
			//convert the email to lowercase
			$author['email'] = strtolower($author['email']);

			//search for the lowercase version of `$author['email']`
			if (count($this->authorsTable->find('email', $author['email'])) > 0) {
				$valid = false;
				$errors[] = 'That email address is already registered';
			}
		}


		if (empty($author['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		//If $valid is still true, no fields were blank and the data can be added
		if ($valid == true) {
			//Hash the password before saving it in the database
			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);

			//When submitted, the $author variable now contains a lowercase value for email
			//and a hashed password
			$this->authorsTable->save($author);

            //header('Location: /author/success'); //5/25/18 JG DEL1L  org
            header('Location: index.php?author/success'); //5/25/18 JG NEW1L  


		}
		else {
			//If the data is not valid, show the form again
			return ['template' => 'register.html.php', 
				    'title' => 'Register an account',
				    'variables' => [
				    	'errors' => $errors,
				    	'author' => $author
				    ]
				   ]; 
		}
	}
}
