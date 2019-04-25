<?php


namespace App\Controller;

use App\Model\PriceManager;

/**
 * Class PriceController
 * @package App\Controller
 */
class PriceController extends AbstractController
{

    /**
     * edit pricing index
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit()
    {
        $priceManager = new PriceManager();
        $prices = $priceManager->selectAll();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanData = [];

            foreach ($_POST as $key => $cleanDatum) {
                $cleanData[$key] = trim($cleanDatum);

                if (empty($cleanData[$key])) {
                    $errors['prices'] = 'Tous les champs doivent être remplis.';
                }
            }

            if (empty($errors)) {
                foreach ($prices as $key => $price) {
                    $priceToInsert['id'] = $price['id'];
                    $priceToInsert['prices'] = $cleanData['prices' . $price['id']];

                    $priceManager->update($priceToInsert);
                }
            }
        }

        return $this->twig->render('Price/edit.html.twig', [
            'prices' => $prices,
            'errors' => $errors,
            'editsuccess' => true,
        ]);
    }
}
