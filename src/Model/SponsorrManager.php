<?php

namespace App\Model;

/**
 *
 */
class SponsorrManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'partner';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
