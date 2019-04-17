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

    /**
     * Get all row from database - Override abstract Method
     *
     * @return array
     */
    public function getTopMembers(): array
    {
        $statement = "SELECT * FROM " . $this->table . " ORDER BY id LIMIT 3";
        return $this->pdo->query($statement)->fetchAll();
    }
}
