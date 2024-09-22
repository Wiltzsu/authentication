<?php
/**
 * Contains the UserModel class.
 */
require_once __DIR__ . '/config/database.php';

class UserModel
{
    /**
     * Database connection.
     */
    private $connection;
    private $username;
    private $email;
    private $password;
    private $hashed_password;
    private $token;
    /**
     * UserModel constructor.
     * 
     * @param $db Database connection.
     * 
     * @return void
     */

    public function __construct(Database $db)
    {
        $this->connection = $db->getConnection();
    }

    /**
     * Validates registration input checking for empty fields and password length.
     * 
     * @param string $username User's chosen username.
     * @param string $email    User's email address.
     * 
     * @return array Returns an array of error messages.
     */
    public function validateRegistration($username, $email): array
    {
        $errors = [];
        if (empty($username)) {
            $errors[] = 'Username is required.';
        }

        if (strlen($username) < 5 || strlen($username) > 20) {
            $errors[] = 'Username must be between 5 and 32 characters.';
        } else {
            $username_query = $this->connection->prepare(
                'SELECT 1 FROM users WHERE username = ?'
            );
            $username_query->execute([$username]);
            if ($username_query->fetch()) {
                $errors[] = 'Username is already taken.';
            }
        }

        if (strlen($this->password) < 8 || strlen($this->password) > 32) {
            $errors['password'] = 'Password must be between 8 and 32 characters.';
        }

        if ($this->password !== $_POST['confirm_password']) {
            $errors['password'] = 'Passwords do not match.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address.';
        } else {
            $email_query = $this->connection->prepare(
                'SELECT 1 FROM users WHERE email = ?'
            );
            $email_query->execute([$email]);
            if ($email_query->fetch()) {
                $errors['email'] = 'Email is already taken.';
            }
        }

        return $errors;
    }

    /**
     * Register a new user if validation passes.
     * 
     * @param string $username User's chosen username.
     * @param string $email    User's email address.
     * @param string $password User's chosen password.
     * @param string $token    User's token.
     * 
     * @return array Returns an array of error messages.
     */
    public function registerUser($username, $email, $password, $token): array
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;

        $errors = $this->validateRegistration($username, $email, $password);
        if (!empty($errors)) {
            return $errors;
        }

        $this->hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password, token)
                  VALUES (:username, :email, :password, :token)";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':username', $this->username, PDO::PARAM_STR);
        $statement->bindParam(':email', $this->email, PDO::PARAM_STR);
        $statement->bindParam(':password', $this->hashed_password, PDO::PARAM_STR);
        $statement->bindParam(':token', $this->token, PDO::PARAM_STR);
        $statement->execute();
    }
}