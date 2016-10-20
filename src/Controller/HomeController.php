<?php

namespace compta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use compta\Domain\Depense;
use compta\Form\Type\DepenseType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.group']->findAll();
       /* return $app['twig']->render('index.html.twig', array('articles' => $articles));*/
    }

    /**
     * group details controller.
     *
     * @param integer $id group id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function groupAction($id, Request $request, Application $app) {
        $group = $app['dao.group']->find($id);
        
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $depense = new Depense();
            $depense->setGroup($group);
            $user = $app['user'];
            $depense->setAuthor($user);
            $depenseForm = $app['form.factory']->create(new DepenseType(), $depense);
            $depenseForm->handleRequest($request);
            if ($depenseForm->isSubmitted() && $depenseForm->isValid()) {
                $app['dao.depense']->save($depense);
                $app['session']->getFlashBag()->add('success', 'Your depense was succesfully added.');
            }
            $depenseFormView = $depenseForm->createView();
        }
        $depenses = $app['dao.depense']->findAllByGroup($id);
        /*return $app['twig']->render('article.html.twig', array(
            'article' => $article, 
            'comments' => $comments,
            'commentForm' => $commentFormView));*/
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
       /* return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
            ));*/
    }
}
