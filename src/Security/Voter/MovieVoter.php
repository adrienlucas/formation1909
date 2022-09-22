<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

// IsGranted($attribute, $subject = null)
// IsGranted('ROLE_ADMIN')
// IsGranted('book', $book)
// IsGranted('can_delete', $book)
// IsGranted('can_delete', $movie)
class MovieVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'can_delete'
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $movie = $subject;
        /** @var User $currentUser */
        $currentUser = $token->getUser();
        // if the user is anonymous, do not grant access
        if ($currentUser === null) {
            return false;
        }

        if(in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return true;
        }

        return $currentUser->isEqualTo($movie->getCreatedBy());
    }
}
