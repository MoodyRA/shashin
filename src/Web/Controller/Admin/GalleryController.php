<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use App\Domain\File\Enum\FileType as PhotoExtension;
use App\Domain\Photo\Entity\Photo;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Component\Form\Extension\Core\Type\FileType as FormFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/gallery', name: 'admin_gallery_')]
class GalleryController extends AdminController
{
    #[Route('', methods: ['GET'])]
    public function index(): Response
    {
        $photo = new Photo(Uuid::generate(),'test',PhotoExtension::JPEG,'');
        $form = $this->createFormBuilder([])
            ->add('photo', FormFileType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();
        return $this->render('admin/gallery.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function upload(Request $request): Response
    {
        $form = $this->createFormBuilder([])
            ->add('photo', FormFileType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
            }
        }
        return $this->render('admin/gallery.html.twig');
    }
}