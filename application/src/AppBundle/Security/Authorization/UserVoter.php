<?php

namespace AppBundle\Security\Authorization;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * UserVoter
 *
 * @SuppressWarnings(PHPMD)
 */
class UserVoter implements VoterInterface
{
    const USER = 'ROLE_USER';
    const ADMIN = 'ROLE_ADMIN';

    const CREATE    = 'create';
    const READ      = 'read';
    const UPDATE    = 'update';
    const DELETE    = 'delete';

    /**
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     *
     * @param Object $attribute
     * @return boolean
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Support all type
     * @param type $class
     * @return boolean
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     *
     * @param TokenInterface $token
     * @param Object         $object
     * @param array          $attributes
     * @return Object
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $roles = $token->getRoles();

        foreach ($attributes as $attribute) {
            $result = VoterInterface::ACCESS_DENIED;
            foreach ($roles as $role) {
                if ($attribute === $role->getRole()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return $result;
    }

    public static function isAllowed($user, $role)
    {
        $ret = false;
        foreach($user->getRoles() as $r) {
            if ($role === $r) {
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * Allow us to know if the current user is admin
     *
     * @return boolean True if the current user is admin. Else false.
     */
    public function isAdmin()
    {
        $this->isAdmin = $this->get('security.context')->isGranted(self::ADMIN);

        return $this->isAdmin;
    }
}
