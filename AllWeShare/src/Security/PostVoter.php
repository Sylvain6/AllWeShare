<?php

namespace App\Security;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PostVoter
 * @package App\Security
 */
class PostVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        if ($subject instanceof Post or $subject instanceof Comment) {
            return true;
        }

        return false;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canDelete($subject, User $user)
    {
        if ($this->canEdit($subject, $user)) {
            return true;
        }

        return $user === $subject->getAuthor();
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canEdit($subject, User $user)
    {
        return $user === $subject->getAuthor();
    }
}