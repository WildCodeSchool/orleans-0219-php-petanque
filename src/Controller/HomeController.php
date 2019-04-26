<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ScheduleManager;
use App\Model\PartnerManager;
use App\Model\ArticleManager;

class HomeController extends AbstractController
{

    const LIMIT_LAST_ARTICLES = 3;

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
        $scheduleManager = new ScheduleManager();
        $schedules = $scheduleManager->selectAll();
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->getPartners();
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAllArticles(self::LIMIT_LAST_ARTICLES);

        return $this->twig->render('Home/index.html.twig', [
            'schedules' => $schedules,
            'partners' => $partners,
            'articles' => $articles,
        ]);
    }
}
