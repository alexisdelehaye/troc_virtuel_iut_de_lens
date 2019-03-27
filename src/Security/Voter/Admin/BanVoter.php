<?php

namespace App\Security\Voter\Admin;

use App\Entity\User;
use App\Security\AppAccess;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BanVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return $attribute === AppAccess::ADMIN_USER_BAN
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        //il peut pas se ban lui même
       if($user->getUsername() === $subject->getUsername()){
           return false;
       }

       // on peut pas ban un admin
       if(in_array('ROLE_ADMIN',$subject->getRoles()))
       {
           return false;
       }
        return true;
    }
}
