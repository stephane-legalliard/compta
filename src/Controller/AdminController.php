<?php

namespace compta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use compta\Domain\Group;
use compta\Domain\User;
use compta\Domain\Depense;


class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $groups = $app['dao.group']->findAll();
        $depenses = $app['dao.depense']->findAll();
        $users = $app['dao.user']->findAll();
    }

    /**
     * Add group controller.
    
     */
    public function addGroupAction(Request $request, Application $app) {
        $group = new Group();
        $group = $app["dao.group"]->save();
       return $app->json('success', 'The group was succesfully created.');
    }

    /**
     * Edit group controller.
     *
     * @param integer $id Group id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editGroupAction($id, Request $request, Application $app) {
        $group = $app['dao.group']->find($id);
        
    }

    /**
     * Delete group controller.
     *
     * @param integer $id Group id
     * @param Application $app Silex application
     */
    public function deleteGroupAction($id, Application $app) {
        // Delete all associated depenses
        $app['dao.depense']->deleteAllByGroup($id);
        // Delete the group
        $app['dao.group']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The group was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit depense controller.
     *
     * @param integer $id Depense id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editDepenseAction($id, Request $request, Application $app) {
        $depense = $app['dao.depense']->find($id);
        $depenseForm = $app['form.factory']->create(new DepenseType(), $depense);
        $depenseForm->handleRequest($request);
        if ($depenseForm->isSubmitted() && $depenseForm->isValid()) {
            $app['dao.depense']->save($depense);
            $app['session']->getFlashBag()->add('success', 'The depense was succesfully updated.');
        }
        /*return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));*/
    }

    /**
     * Delete depense controller.
     *
     * @param integer $id Depense id
     * @param Application $app Silex application
     */
    public function deleteDepenseAction($id, Application $app) {
        $app['dao.depense']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The depense was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.digest'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        /*return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));*/
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        }
       /* return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));*/
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
