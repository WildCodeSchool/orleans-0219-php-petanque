<?php
namespace App\Controller;

use App\Service\PostDatum;

class ContactController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $errorContactData=[];
        $contactData=[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum =new PostDatum($_POST);
            $contactData=$postDatum->cleanValues();
            $errorContactData = $this->checkErrorsPostData($contactData);

            if (empty($errorContactData)) {
                echo "EMAIL ENVOYE";
            }
        }

        return $this->twig->render('Contact/index.html.twig', [
                'errors' => $errorContactData,
                'contact' => $contactData,
            ]);
    }

    private function checkErrorsPostData($data) :array
    {
        $errors=[];
        if (empty($data["firstname"])) {
            $errors["firstname"] = "Ce champ ne peut etre vide";
        }
        if (empty($data["lastname"])) {
            $errors["lastname"] = "Ce champ ne peut etre vide";
        }
        if (empty($data["phone"])) {
            $errors["phone"] = "Ce champ ne peut etre vide";
        }
        if (empty($data["message"])) {
            $errors["message"] = "Ce champ ne peut etre vide";
        }
        if (empty($data['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Ce champ ne peut etre vide";
        }

        return $errors;
    }
}
