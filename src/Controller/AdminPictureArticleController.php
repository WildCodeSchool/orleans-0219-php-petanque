<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\PictureArticleManager;

/**
 * Class EventAdminController
 *
 */
class AdminPictureArticleController extends AbstractController
{

    /**
     * Display event listing admin
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $alertResult = isset($_GET['status']);
        $pictureArticleManager = new PictureArticleManager();
        $pictures = $pictureArticleManager->selectPicturesFromArticleById($id);

        return $this->twig->render('Picture/show.html.twig', [
            'pictures' => $pictures,
            'statusAlert' => $alertResult,
        ]);
    }
}
