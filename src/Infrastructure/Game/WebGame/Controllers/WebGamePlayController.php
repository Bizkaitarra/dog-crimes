<?php

namespace App\Infrastructure\Game\WebGame\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WebGamePlayController extends AbstractController
{
    public function __invoke(int $gameId)
    {
        return $this->render('play.html.twig');
    }

}