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
class PictureArticleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Retrieve all pictures from one article
     * @param $id
     * @return array
     */
    public function selectPicturesFromArticleById($id) :array
    {
        $statement = "SELECT * FROM $this->table WHERE article.id=:id";

        // prepared request
        $statement = $this->pdo->prepare($statement);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();

    }

}
