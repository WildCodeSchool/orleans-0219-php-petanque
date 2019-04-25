<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

use Nette\Utils\DateTime;

/**
 *
 */
class ArticleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'article';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    /**
     * Get all articles from database
     *
     *
     *
     * @return array
     */
    public function selectAllArticles():array
    {
        $statement = "
        SELECT a.id as id,
        a.title as title,
        a.description as description,
        a.articlecategory_id as articlecategory_id,
        a.picture as picture,
        DATE_FORMAT(a.date_publicated,'%d/%m/%Y') as date_publicated, 
        c.name as category,
        c.descr as category_description 
        FROM db_upa.article as a 
        LEFT JOIN db_upa.articlecategory AS c 
        ON a.articlecategory_id = c.id
        ORDER BY a.date_publicated DESC;";

        return $this->pdo->query($statement)->fetchAll();
    }

    /**
     * Insert an article in database
     * @param array $articles
     * @return int
     * @throws \Exception
     */
    public function insertArticle(array $articles): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
        VALUES (NULL, :title, :description, :articlecategory_id, :picture, NOW())");
        $statement->bindValue('title', $articles['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $articles['description'], \PDO::PARAM_STR);
        $statement->bindValue('articlecategory_id', $articles['articlecategory_id'], \PDO::PARAM_INT);
        $statement->bindValue('picture', $articles['picture'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
