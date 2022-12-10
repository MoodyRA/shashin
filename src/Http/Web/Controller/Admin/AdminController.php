<?php

declare(strict_types=1);

namespace App\Http\Web\Controller\Admin;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        // inject a specific logger service
        #[Autowire(service: 'monolog.logger.request')]
        LoggerInterface $logger,

        // or inject parameter values
        #[Autowire('%kernel.project_dir%')]
        string $projectDir
    ): Response
    {
        $locale = $request->getLocale();
        return new Response('<html><body>Hello Admin</body></html>', 200);
    }
}