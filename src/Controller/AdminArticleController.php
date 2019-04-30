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
     * Display article listing admin
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $alertResult='';
        if (isset($_GET['status'])) {
            $alertResult = $_GET['status'];
        }
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAllArticles();

        return $this->twig->render('Article/indexadmin.html.twig', [
            'articles' => $articles,
            'statusAlert' => $alertResult,
        ]);
    }

    /**
     * Display event creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $errorArticleData=[];
        $articleData=[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum =new PostDatum($_POST);
            $articleData=$postDatum->cleanValues();
            $errorArticleData = $this->checkErrorsPostData($articleData);

            $articleManager = new ArticleManager();

            if (empty($errorArticleData)) {
                $id = $articleManager->insertArticle($articleData);
                header('Location:/AdminArticle/index/?status=success');
                exit();
            }
        }

        $articleCategoryManager = new ArticleCategoryManager();
        $categories = $articleCategoryManager->selectall();

        return $this->twig->render('Article/add.html.twig', [
            'article' => $articleData,
            'errors' => $errorArticleData,
            'categories' => $categories,
        ]);
    }

    /**
     * Check error post from user
     * @param array $postData
     * @return array
     */
    private function checkErrorsPostData(array $postData) : array
    {
        $errors=[];
        $maxCharTitle = 100;
        if (empty($postData['title'])) {
            $errors['title'] = "Un titre d'article est requis.";
        } elseif (strlen(($postData['title'])) > $maxCharTitle) {
            $errors['title'] = "Le titre ne doit pas avoir plus de $maxCharTitle caractères.";
        };

        if (empty($postData['description'])) {
            $errors['description'] = "Une description de l'article est requise.";
        };

        if (empty($postData['articlecategory_id'])) {
            $errors['articlecategory_id'] = "Une catégorie pour l'article est requise.";
        };

        return $errors;
    }

    /**
     * Delete an event
     */
    public function delete()
    {
        $articleManager = new ArticleManager();
        $errors=[];
        $id=0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum =new PostDatum($_POST);
            $postData=$postDatum->cleanValues();
            $id = $postData['id'];
            if (empty($id)) {
                $errors[] = 'L\'article n\'existe pas';
            } elseif (empty($articleManager->selectOneById($id))) {
                $errors[] = 'L\'article n\'existe pas dans la base de données';
            }
        }
        if (empty($errors)) {
            $articleManager->delete($id);
            header('Location:/AdminArticle/index/?status=deletesuccess');
            exit();
        }
    }
}
