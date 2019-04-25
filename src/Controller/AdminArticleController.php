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
use App\Model\ArticleCategoryManager;
use App\Service\PostDatum;

/**
 * Class EventAdminController
 *
 */
class AdminArticleController extends AbstractController
{
    /**
     * Display article creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $errorArticleData = [];
        $articleData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);
            $postDatum = new PostDatum($_POST);
            $articleData = $postDatum->cleanValues();
            $errorArticleData = $this->checkErrorsPostData($articleData);

            $articleManager = new ArticleManager();

            if (empty($errorArticleData)) {
                $id = $articleManager->insertArticle($articleData);
                header('Location:/article/show/' . $id);
            }
        }

        $articleCategoryManager = new ArticleCategoryManager();
        $categories = $articleCategoryManager->selectall();
        var_dump($errorArticleData);
        return $this->twig->render('Article/add.html.twig', [
            'article' => $articleData,
            'categories' => $categories,
            'errors' => $errorArticleData,
        ]);
    }

    /**
     * CHeck post Data form for article
     *
     * @param array $postData
     * @return array
     */
    private function checkErrorsPostData(array $postData) : array
    {
        $errors=[];
        if (empty($postData['title'])) {
            $errors['title'] = "Un titre pour l'article est requis.";
        } elseif (strlen(($postData['title'])) > 100) {
            $errors['title'] = "Le titre ne doit pas avoir plus de 100 car.";
        };

        if (empty($postData['description'])) {
            $errors['description'] = "Une description  pour l'article est requis.";
        };

        if (empty($postData['description'])) {
            $errors['description'] = "Une description  pour l'article est requis.";
        };

        $articleCategoryManager = new ArticleCategoryManager();
        if (empty($postData['articlecategory_id'])) {
            $errors['articlecategory_id'] = "Une catégorie pour l'article est requis.";
        } elseif (empty($articleCategoryManager->selectOneById($postData['articlecategory_id']))) {
            $errors['articlecategory_id'] = "Une catégorie valide pour l'article est requis.";
        };

        return $errors;
    }
}
