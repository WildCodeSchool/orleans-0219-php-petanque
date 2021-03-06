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
     * @param int $limitResults
     * @return array
     */
    public function selectAllArticles(int $limitResults = 0):array
    {
        $statement = "
        SELECT a.id as id,
        a.title as title,
        a.description as description,
        a.articlecategory_id as articlecategory_id,
        MIN(p.picture) as picture,
        DATE_FORMAT(a.date_publicated,'%d/%m/%Y') as date_publicated, 
        c.name as category,
        c.descr as category_description 
        FROM article as a 
        LEFT JOIN articlecategory AS c 
        ON a.articlecategory_id = c.id
        LEFT JOIN picture AS p 
        ON a.id = p.article_id 
        GROUP BY a.id
        ORDER BY a.date_publicated DESC";
        if ($limitResults > 0) {
            $statement .= " LIMIT $limitResults";
        }

        return $this->pdo->query($statement)->fetchAll();
    }

    /**
     * Insert an article in database
     *
     * @return int
     */
    public function insertArticle(array $articleData): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
        VALUES (NULL, :title, :description, :articlecategory_id, NULL, NOW())");
        $statement->bindValue('title', $articleData['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $articleData['description'], \PDO::PARAM_STR);
        $statement->bindValue('articlecategory_id', $articleData['articlecategory_id'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * Get one Article from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneArticleById(int $id):array
    {
        $statement = "
        SELECT a.id as id,
        a.title as title,
        a.description as description,
        a.articlecategory_id as articlecategory_id,
        MIN(p.picture) as picture,
        DATE_FORMAT(a.date_publicated,'%d/%m/%Y') as date_publicated, 
        c.name as category,
        c.descr as category_description 
        FROM article as a 
        LEFT JOIN articlecategory AS c 
        ON a.articlecategory_id = c.id
        LEFT JOIN picture AS p 
        ON a.id = p.article_id 
        WHERE a.id=:id
        GROUP BY a.id;";

        // prepared request
        $statement = $this->pdo->prepare($statement);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Update an article in database
     *
     * @return bool
     */
    public function updateArticle(array $articleData, int $id) :bool
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "UPDATE $this->table SET 
            `title` = :title,
            `description` = :description,
            `articlecategory_id` = :articlecategory_id           
            WHERE id=:id"
        );
        $statement->bindValue('title', $articleData['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $articleData['description'], \PDO::PARAM_STR);
        $statement->bindValue('articlecategory_id', $articleData['articlecategory_id'], \PDO::PARAM_INT);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}
