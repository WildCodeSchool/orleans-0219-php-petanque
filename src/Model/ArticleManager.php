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
     *
     * @return array
     */
    public function selectAllArticles():array
    {
        $statement = "
        SELECT a.*, 
        c.name as category,
        c.descr as category_description 
        FROM db_upa.article as a 
        LEFT JOIN db_upa.articlecategory AS c 
        ON a.articlecategory_id = c.id
        ORDER BY a.date_publicated DESC;";

        return $this->pdo->query($statement)->fetchAll();
    }
}
