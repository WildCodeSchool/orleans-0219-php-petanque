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
    const TABLE = 'sponsor';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
