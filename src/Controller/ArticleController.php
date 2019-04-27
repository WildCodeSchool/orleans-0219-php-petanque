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
use App\Model\PictureArticleManager;

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

    /**
     * Display article informations specified by $id
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $pictureArticleManager = new PictureArticleManager();
        $pictures = $pictureArticleManager->selectPicturesFromArticleById($id);

        return $this->twig->render('Article/show.html.twig', [
            'pictures' =>$pictures,
        ]);
    }
}
