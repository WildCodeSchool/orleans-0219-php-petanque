<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\MemberManager;
use App\Model\PartnerManager;

class MemberController extends AbstractController
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
        $memberManager = new MemberManager();
        $members = $memberManager->selectAll();
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->selectAll();
        $randomDescription = [];

        foreach ($members as $member) {
            $randomDescription[] = $memberManager->getRandomDescription();
        }

        return $this->twig->render('Member/index.html.twig', [
            'members' => $members,
            'partners' => $partners,
            'randomDescription' => $randomDescription,
        ]);
    }
}
