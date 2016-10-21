<?php

namespace compta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use compta\Domain\UserGroup;
use compta\Domain\User;
use compta\Domain\Depenses;


class AdminController {

    

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
              -> setName($user_name)
              -> setColor($color)
              -> setGroup($user_group)
        $app['dao.user']->save($user);
        return $app->json;
    }

    
    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        $app['dao.user']->delete($id);
        $app['dao.usergroup']->deleteByGroup($id);
        $app['dao.depenses']->deleteByUser($id);
        return $app->json(array(
            'status' => 'OK'
                ), 200);
        }
        
}
