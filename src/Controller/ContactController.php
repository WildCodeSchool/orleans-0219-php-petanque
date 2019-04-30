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
        $errorContactData = [];
        $contactData = [];
        $status = $_GET['status'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum = new PostDatum($_POST);
            $contactData = $postDatum->cleanValues();
            $errorContactData = $this->checkErrorsPostData($contactData);

            if (empty($errorContactData)) {
                $transport = new \Swift_SmtpTransport(APP_SW_HOST, APP_SW_PORT, APP_SW_ENCRYPTION);
                $transport->setUsername(APP_SW_USERNAME);
                $transport->setPassword(APP_SW_PASSWORD);

                $mailer = new \Swift_Mailer($transport);
                $message = new \Swift_Message('Demande d\'informations');
                $userFrom=[$contactData['email'] => $contactData['firstname'] . ' ' . $contactData['lastname']];
                $message->setFrom($userFrom);
                $message->setTo(array(APP_SW_USERNAME));

                $bodyMessage =$contactData['message'];
                $bodyMessage .= "\n" . $contactData['firstname'] . ' ' . $contactData['lastname'];
                $bodyMessage .= "\n" . $contactData['phone'];
                $message->setBody($bodyMessage);

                $mailer->send($message);
                header('Location:/Contact/index/?status=success');
                exit();
            }
        }

        return $this->twig->render('Contact/index.html.twig', [
            'errors' => $errorContactData,
            'contact' => $contactData,
            'statusAlert' => $status,
        ]);
    }

    private function checkErrorsPostData($data): array
    {
        $errors = [];
        if (empty($data["firstname"])) {
            $errors["firstname"] = "Ce champ ne peut être vide";
        }
        if (empty($data["lastname"])) {
            $errors["lastname"] = "Ce champ ne peut être vide";
        }
        if (empty($data["message"])) {
            $errors["message"] = "Ce champ ne peut être vide";
        }
        if (empty($data['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Ce champ ne peut être vide";
        }

        return $errors;
    }
}
