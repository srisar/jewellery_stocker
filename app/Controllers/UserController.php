<?php


namespace Jman\Controllers;

use Exception;
use Jman\Core\Database;
use Jman\Core\Images\ImageWorker;
use Jman\Core\Images\UploadedImageFile;
use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\AppSession;
use Jman\Core\JsonResponse;
use Jman\Core\LoginManager;
use Jman\Core\View;
use Jman\Models\User;
use Jman\Models\UserModel;

class UserController
{

    /**
     * View all users, only accessible to admin users
     * @param AppRequest $request
     */
    public function viewUsers(AppRequest $request)
    {
        $users = UserModel::all();

        View::setData('users', $users);
        View::render('users/index.view');

    }

    /**
     * @param AppRequest $request
     */
    public function viewAddUser(AppRequest $request)
    {
        View::render('users/add_user.view');
    }

    /**
     * @param AppRequest $request
     */
    public function actionAddUser(AppRequest $request)
    {

        $fields = [
            'first_name' => $request->getParams()->getString('first_name'),
            'last_name' => $request->getParams()->getString('last_name'),
            'password' => $request->getParams()->getString('password'),
            'role' => $request->getParams()->getString('role'),
            'username' => $request->getParams()->getString('username'),
        ];

        $isValid = true;

        foreach ($fields as $field => $value) {
            if (empty($value) || is_null($value)) {
                $response = new JsonResponse("Empty field {$field}");
                $response->setStatusCode400();
                $response->emit();
                return;
            }
        }

        $existingUser = UserModel::findByUsername($fields['username']);

        if (is_null($existingUser)) {

            $user = new User();
            $user->setUsername($fields['username']);
            $user->setFirstName($fields['first_name']);
            $user->setLastName($fields['last_name']);
            $user->setPassword($fields['password']);
            $user->setRole($fields['role']);

            if (UserModel::save($user)) {

                $lastInsertedId = (Database::get_instance())->lastInsertId();

                $user = UserModel::find($lastInsertedId);

                $user_ = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'first_name' => $user->getFirstName(),
                ];

                $response = new JsonResponse($user_);
                $response->setStatusCode200();
                $response->emit();
                return;

            }

        } else {

            $user = [
                'id' => $existingUser->getId(),
                'username' => $existingUser->getUsername(),
                'first_name' => $existingUser->getFirstName(),
            ];

            $response = new JsonResponse(["message" => "Username already exists.", "user" => $user]);
            $response->setStatusCode400();
            $response->emit();
            return;
        }

    }

    /**
     * Show manage user page
     * @param AppRequest $request
     */
    public function viewEditUser(AppRequest $request)
    {


        try {
            $user_id = $request->getParams()->getInt('id');

            if ($user_id !== LoginManager::getUserId()) {
                App::redirect('/');
                return;
            }

            $user = UserModel::find($user_id);

            if (!empty($user)) {
                View::setData('user', $user);
                View::render('users/edit_user.view');
            } else {
                App::redirect('/');
            }


        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * Update the user details
     * @param AppRequest $request
     */
    public function actionEditUser(AppRequest $request)
    {

        try {
            LoginManager::isLoggedInOrRedirect();

            $change_password = false;
            $all_ok          = true;

            $csrf_token = $request->getCSRFToken();

            if (AppSession::validateCSRFToken($csrf_token)) {

                $fields = [
                    'id' => $request->getParams()->getInt('id'),
                    'last_name' => $request->getParams()->getString('last_name'),
                    'first_name' => $request->getParams()->getString('first_name'),
                    'username' => $request->getParams()->getString('username'),
                    'role' => $request->getParams()->getString('role'),
                ];

                if ($request->getParams()->has('password_string')) {
                    $change_password                   = true;
                    $fields['password_string']         = $request->getParams()->getString('password_string');
                    $fields['confirm_password_string'] = $request->getParams()->getString('confirm_password_string');
                }

                $currentUser = UserModel::find($fields['id']);

                // Add first name and last name to the current user.
                $currentUser->setFirstName($fields['first_name']);
                $currentUser->setLastName($fields['last_name']);
                $currentUser->setRole($fields['role']);


                if ($currentUser->getUsername() != $fields['username']) {
                    // User has changed the username. Need to check if it already exists.
                    $existingUser = UserModel::findByUsername($fields['username']);

                    if (!empty($existingUser)) {
                        // The new username already taken by another user.
                        // Load a view, and show error message.

                        View::setData('user', $currentUser);
                        View::setError("Username {$fields['username']} already taken. Choose a different username.");
                        View::render("users/manage_user.view");
                        $all_ok = false;
                    } else {
                        // The username is available for user to use.
                        $currentUser->setUsername($fields['username']);
                    }


                }

                if ($all_ok) {
                    // Check if password change is needed.
                    if ($change_password) {
                        $currentUser->setPassword($fields["password_string"]);
                    }

                    // Finally, update the user with new data.
                    if (UserModel::update($currentUser)) {
                        App::redirect("/users/edit", ["id" => $currentUser->getId()]);
                    }
                }


            }


        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }


}