<?php
// src/Controller/LocaleController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocaleController extends AbstractController
{
    #[Route(path: '/change-locale/{locale}', name: 'change_locale')]
    public function changeLocale($locale, Request $request, SessionInterface $session): RedirectResponse
    {
        $availableLocales = ['en', 'ru'];
        
        if (!in_array($locale, $availableLocales)) {
            throw new NotFoundHttpException("Locale not supported");
        }

        $session->set('_locale', $locale);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
