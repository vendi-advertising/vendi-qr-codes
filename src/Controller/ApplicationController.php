<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Shortcode;
use App\Repository\ClientRepository;
use App\Repository\ShortcodeRepository;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/__admin__', name: 'app_admin_')]
class ApplicationController extends AbstractController
{
    #[Route(path: '', name: 'dashboard')]
    public function dashboard(ClientRepository $clientRepository): Response
    {
        return $this
            ->render(
                'application/dashboard.html.twig',
                [
                    'clients' => $clientRepository->findAll(),
                ]
            );
    }


    #[Route(path: '/{client}', name: 'urls_list')]
    public function clientUrls(Client $client, ShortcodeRepository $shortcodeRepository): Response
    {
        return $this
            ->render(
                'application/client_urls.html.twig',
                [
                    'shortcodes' => $shortcodeRepository->findAllByClient($client),
                ]
            );
    }

    #[Route(path: '/shortcode/{shortcode}/render', name: 'shortcode_render')]
    public function urlShortcode(Shortcode $shortcode): Response
    {
        $options = new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'outputBase64' => false,
        ]);
        $url = sprintf('https://%1$s/%2$s', $shortcode->getDomain()->fullyQualifiedDomainName, $shortcode->shortcode);
        $qrCode = (new QRCode($options))->render($url);

        return new Response(
            $qrCode,
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/svg+xml',
            ]
        );
    }
}