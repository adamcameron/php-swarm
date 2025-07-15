<?php

namespace App\Controller;

use App\Service\VersionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly VersionService $versionService
    ) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'environment' => $this->getParameter('kernel.environment'),
                'instanceId' => getenv('POD_NAME') ?: getenv('HOSTNAME') ?: 'unknown',
                'dbVersion' => $this->versionService->getVersion(),
            ]
        );
    }
}
