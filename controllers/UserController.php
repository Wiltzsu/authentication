<?php
/**
 * User controller.
 */
require_once __DIR__ . '/models/UserModel.php';

class UserController
{
    /**
     * Constructor for the UserController.
     * 
     * @param Database $db Database connection.
     */
    public function __construct(
        private Database $db,
        private UserModel $userModel
    ) {
    }

    public function register($request)
    {
        $username = $request['username'];
        $email = $request['email'];
        $password = $request['password'];

        // Generate a secure random token.
        $token = bin2hex(random_bytes(32));

        $errors = $this->userModel->registerUser($username, $email, $password, $token);

        if (!empty($errors)) {
            return $errors;
        } else {
            header('Location: login');
            exit();
        }
    }
}