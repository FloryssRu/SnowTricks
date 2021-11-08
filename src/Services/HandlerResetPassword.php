<?php

namespace App\Services;

use App\Controller\ResetPasswordController;
use App\Repository\UserRepository;
use Exception;

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

    public function validateTokenAndFetchUser(string $token)
    {
        if (!$this->csrfManager->isTokenValid($token)) {
            return new Exception("Une erreur est survenue.");
        }

        $user = $this->UserRepo->findBy(["token" => $token]);
        return $user;
    }
}