<?php

namespace App\Security\Voter;

use App\Entity\Conversation;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ConversationVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['CONVERSATION_SHOW'])
            && $subject instanceof Conversation;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user === $subject->getIdobjetconcerne()->getIdproprietaire() || $user === $subject->getIdenvoyeur()) {
            return true;
        }

        return false;
    }
}
