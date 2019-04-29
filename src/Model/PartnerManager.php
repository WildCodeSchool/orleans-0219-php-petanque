<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class PartnerManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'partner';
    const LIMITPARTNER = '6';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getPartners(): array
    {
        $statement = "SELECT * FROM " . $this->table . " LIMIT " . self::LIMITPARTNER;
        return $this->pdo->query($statement)->fetchAll();
    }
}
