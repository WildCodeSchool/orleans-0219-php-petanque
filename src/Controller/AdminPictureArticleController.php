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
        session_start();
        $files = [];
        $uploadedFiles=[];
        if (isset($_SESSION['uploadfiles'])) {
            $uploadedFiles=$_SESSION['uploadfiles'];
            $_SESSION['uploadfiles'] = [];
        }

        if (isset($_POST['submit'])) {
            $uploadDir = 'assets/images/article/';
            $allowedFormats = ['image/gif', 'image/jpg', 'image/png',];
            $maxSize = 1000000;
            if (count($_FILES['upload']['name']) > 0) {
                //Loop through each file
                for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                    $shortNameFile = $_FILES['upload']['name'][$i];
                    if (!in_array($_FILES['upload']['type'][$i], $allowedFormats)) {
                        $files[] = [
                            'fileName' => $shortNameFile,
                            'fileSize' => $_FILES['upload']['size'][$i],
                            'fileType' => $_FILES['upload']['type'][$i],
                            'uploaded' => false,
                            'uploadederror' => 'Format non supporté.',
                        ];
                    } elseif ($_FILES['upload']['size'][$i] > $maxSize) {
                        $files[] = [
                            'fileName' => $shortNameFile,
                            'fileSize' => $_FILES['upload']['size'][$i],
                            'fileType' => $_FILES['upload']['type'][$i],
                            'uploaded' => false,
                            'uploadederror' => 'Taille de fichier > à 1Mo.',
                        ];
                    } else {
                        //Get the temp file path
                        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                        //Make sure we have a filepath
                        if (!empty($tmpFilePath)) {
                            $extension = pathinfo($shortNameFile, PATHINFO_EXTENSION);
                            $uploadFileName = 'picture' . uniqid();
                            if (!empty($extension)) {
                                $uploadFileName .= '.' . $extension;
                            }
                            //save the url and the file
                            $uploadFile = $uploadDir . $uploadFileName;
                            //Upload the file into the temp dir
                            if (move_uploaded_file($tmpFilePath, $uploadFile)) {
                                $files[] = [
                                    'fileName' => $shortNameFile,
                                    'fileSize' => $_FILES['upload']['size'][$i],
                                    'fileType' => $_FILES['upload']['type'][$i],
                                    'uploaded' => true,
                                ];
                                $pictureToInsert = [
                                    'picture' => $uploadDir. $uploadFileName,
                                    'article_id' => $id,
                                ];
                                $pictureArticle = new PictureArticleManager();
                                $pictureArticle->insert($pictureToInsert);
                            }
                        }
                    }
                }
                $_SESSION['uploadfiles'] = $files;
                header('Location:/AdminPictureArticle/showpicture/' .$id);
                exit();
            }
        }

        $pictureArticleManager = new PictureArticleManager();
        $pictures = $pictureArticleManager->selectPicturesFromArticleById($id);
        $article['id'] = $id;
        return $this->twig->render('Article/adminshowpicture.html.twig', [
            'pictures' => $pictures,
            'article' => $article,
            'uploadedfiles' => $uploadedFiles,
        ]);
    }
}
