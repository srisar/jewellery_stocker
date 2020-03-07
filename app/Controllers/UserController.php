<?php


namespace Jman\Controllers;

use Exception;
use Jman\Core\Images\ImageWorker;
use Jman\Core\Images\UploadedImageFile;
use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\AppSession;
use Jman\Core\LoginManager;
use Jman\Core\View;
use Jman\Models\UserModel;

class UserController
{

    /**
     * Show manage user page
     * @param AppRequest $request
     */
    public function manage_user(AppRequest $request)
    {

        LoginManager::isLoggedInOrRedirect();

        try {
            $user_id = $request->getParams()->getInt('id');

            $user = UserModel::find($user_id);

            if (!empty($user)) {
                View::setData('user', $user);
                View::render('users/manage_user.view');
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
    public function updating_user(AppRequest $request)
    {

        try {
            LoginManager::isLoggedInOrRedirect();

            $change_password = false;
            $all_ok = true;

            $csrf_token = $request->getCSRFToken();

            if (AppSession::validateCSRFToken($csrf_token)) {

                $fields = [
                    'id' => $request->getParams()->getInt('id'),
                    'last_name' => $request->getParams()->getString('last_name'),
                    'first_name' => $request->getParams()->getString('first_name'),
                    'username' => $request->getParams()->getString('username'),
                ];

                if ($request->getParams()->has('password_string')) {
                    $change_password = true;
                    $fields['password_string'] = $request->getParams()->getString('password_string');
                    $fields['confirm_password_string'] = $request->getParams()->getString('confirm_password_string');
                }

                $currentUser = UserModel::find($fields['id']);

                // Add first name and last name to the current user.
                $currentUser->setFirstName($fields['first_name']);
                $currentUser->setLastName($fields['last_name']);


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
                        App::redirect("/user/manage", ["id" => $currentUser->getId()]);
                    }
                }


            }


        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }


    /**
     * Update user profile image.
     * @param AppRequest $request
     */
    public function update_profile_image(AppRequest $request)
    {

        try {

            LoginManager::isLoggedInOrRedirect();

            $user_id = $request->getParams()->getInt('user_id');
            $user = UserModel::find($user_id);

            $profileImage = new UploadedImageFile($request->getFiles()->get('profile_pic'));

            if ($profileImage->uploadImage()) {

                $imageWorker = new ImageWorker($profileImage->getImageFileInstance());
                $resizedImageFile = $imageWorker->resize();


            }

        } catch (Exception $ex) {
            die($ex->getMessage());
        }

    }

    /* =======================================================
     * Helper functions
     *
     *========================================================*/


}