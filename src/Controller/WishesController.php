<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\WishesManager;
use App\Model\PriceManager;

class WishesController extends AbstractController
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

        $priceManager = new PriceManager();
        $prices = $priceManager->selectAll();

        return $this->twig->render('Wishes/index.html.twig', [
            'prices' => $prices,
        ]);
    }
}
