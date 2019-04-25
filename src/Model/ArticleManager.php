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

}