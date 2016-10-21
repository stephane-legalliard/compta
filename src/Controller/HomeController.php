<?php

namespace compta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use compta\Domain\Depenses;
use compta\Domain\User;
use compta\Domain\UserGroup;



class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $user = $app['dao.user']->findAll()
        return $app->json(array(
            'records' => $result,
            'status' => 'OK'
        ), 200);

    
    }
}

