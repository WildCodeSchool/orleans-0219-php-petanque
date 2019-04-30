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
     *
     * @param int $id
     * @return array
     */
    public function selectPicturesFromArticleById(int $id) :array
    {
        $statement = "SELECT * FROM $this->table WHERE article_id=:id";

        $statement = $this->pdo->prepare($statement);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Add picture to database
     * @param array $picture
     * @return int
     */
    public function insert(array $picture): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`picture`,`article_id`) 
        VALUES (:picture, :article_id)");
        $statement->bindValue('picture', $picture['picture'], \PDO::PARAM_STR);
        $statement->bindValue('article_id', $picture['article_id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
