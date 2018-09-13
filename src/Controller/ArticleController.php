<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Heading;
use App\Form\ArticleType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ArticleController extends AbstractController
{
    /**
     * @Route("/article/new", name="article_create")
     * @Route("/article/{id}/edit", name="article_edit")
     */


    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {
        /*$position = $article->getPosition();

        if(isset ($position)){
            return ('changer de position');
        }*/
        if (!$article) {
            $article = new Article();
        }


        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file

            $article = $form->getData();


            $file = $form->get('image')->getData();


            if ($file) {
                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('images_directory')
                );
            }

            // instead of its contents
            $article->setImage($file);
            $manager = $this->getDoctrine()->getManager();

            // ... persist the $product variable or any other work
            $manager->persist($article);
            $manager->flush();

            return $this->redirect($this->generateUrl('article_show'));
        }

        return $this->render('article/create.html.twig', [
            'formArticle' => $form->createView(),
            'article' => $article,
            'editMode' => $article->getId() !== null
        ]);

    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     */
    public function remove(Article $article, ObjectManager $manager)
    {
        $id = $article->getId();
        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id7418520.*963.5201'.$id
            );
        }

        $manager->remove($article);
        $manager->flush();
        return new Response('Delete article'.$id);
    }
    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article){

        return $this->render('article/show.html.twig',[
            'controller_name' => 'ArticleController',
            'article' => $article
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}