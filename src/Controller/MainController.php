<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepository)
    {
        return $this->render('main/index.html.twig', [
            'books' => $bookRepository->findAllByScore()
        ]);
    }

    
}
