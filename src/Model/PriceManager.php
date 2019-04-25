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
class PriceManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'pricing';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * update pricing index
     *
     * @param array $pricing
     * @return bool
     */
    public function update(array $pricing): bool
    {
        // prepared request
        $query = "UPDATE $this->table SET `prices` = :prices WHERE id=:id";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue('id', $pricing['id'], \PDO::PARAM_INT);
        $statement->bindValue('prices', $pricing['prices'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
