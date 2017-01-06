<?php
/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 06/01/2017
 * Time: 11:53
 */

namespace AppBundle\Model;


class Level
{
    const ANONYMOUS = "IS_AUTHENTICATED_ANONYMOUSLY";
    const USER = "ROLE_USER";
    const ADMIN = "ROLE_ADMIN";
}