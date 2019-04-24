<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ArticleManager;

/**
 * Class ItemController
 *
 */
class ArticleController extends AbstractController
{
    /**
     * Display article listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAllArticles();

        return $this->twig->render('Article/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
