<?php


namespace App\Model;

/**
 *
 */
class MemberManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'member';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
