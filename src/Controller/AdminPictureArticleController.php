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
    public function showpicture(int $id)
    {
        $errorFiles = [];
        if (isset($_POST['submit'])) {
            $uploadDir = 'assets/images/article/';
            $allowedFormats = ['image/gif', 'image/jpeg', 'image/png',];
            $maxSize = 1000000;

            if (!empty($_FILES['upload'])) {
                //Loop through each file
                for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                    if (!empty($_FILES['upload']['name'][$i])) {
                        if (!in_array($_FILES['upload']['type'][$i], $allowedFormats)) {
                            $errorFiles[] = [
                                'name' => $_FILES['upload']['name'][$i],
                                'error' => 'Format de fichier non supporté. Formats autorisés : *.jpg, *.png, *.gif. ',
                            ];
                        };
                        if ($_FILES['upload']['size'][$i] > $maxSize) {
                            $errorFiles[] = [
                                'name' => $_FILES['upload']['name'][$i],
                                'error' => 'Taille du fichier trop importante.',
                            ];
                        }
                    }
                }
                if (empty($errorFiles)) {
                    for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                        //Get the temp file path
                        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

                        $shortNameFile = $_FILES['upload']['name'][$i];
                        $extension = pathinfo($shortNameFile, PATHINFO_EXTENSION);
                        $uploadFileName = 'pic' . uniqid();

                        if (!empty($extension)) {
                            $uploadFileName .= '.' . $extension;
                        }
                        //save the url and the file
                        $uploadFile = $uploadDir . $uploadFileName;
                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $uploadFile)) {
                            $pictureToInsert = [
                                'picture' => $uploadDir . $uploadFileName,
                                'article_id' => $id,
                            ];
                            $pictureArticle = new PictureArticleManager();
                            $pictureArticle->insert($pictureToInsert);
                        }
                    }
                    header('Location:/AdminPictureArticle/showpicture/' . $id);
                    exit();
                }
            }
        }
        $pictureArticleManager = new PictureArticleManager();
        $pictures = $pictureArticleManager->selectPicturesFromArticleById($id);
        $article['id'] = $id;
        return $this->twig->render('Article/adminshowpicture.html.twig', [
            'pictures' => $pictures,
            'article' => $article,
            'errors' => $errorFiles,
        ]);
    }
}
