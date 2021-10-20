<?php

namespace App\Services;

use App\Controller\ResetPasswordController;
use App\Repository\UserRepository;

class HandlerResetPassword extends ResetPasswordController
{
    public function findEmailByUserName(string $username, UserRepository $UserRepo)
    {
        $user = $UserRepo->findOneBy(['username' => $username]);
        if ($user === NULL) {
            $this->addFlash('fail', "Un problème est survenu. Veuillez recommencer.");
            return $this->redirectToRoute('app_forgot_password_request');
        }

        return $user->getEmail();
    }
}