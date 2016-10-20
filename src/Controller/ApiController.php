<?php

namespace compta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use compta\Domain\Group;

class ApiController {

    /**
     * API groups controller.
     *
     * @param Application $app Silex application
     *
     * @return All groups in JSON format
     */
    public function getGroupsAction(Application $app) {
        $groups = $app['dao.group']->findAll();
        // Convert an array of objects ($groups) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($groups as $group) {
            $responseData[] = $this->buildArticleArray($group);
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API group details controller.
     *
     * @param integer $id group id
     * @param Application $app Silex application
     *
     * @return group details in JSON format
     */
    public function getGroupAction($id, Application $app) {
        $group = $app['dao.group']->find($id);
        $responseData = $this->buildArticleArray($group);
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API create group controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     *
     * @return group details in JSON format
     */
    public function addGroupAction(Request $request, Application $app) {
        // Check request parameters
        if (!$request->request->has('title')) {
            return $app->json('Missing required parameter: title', 400);
        }
        if (!$request->request->has('content')) {
            return $app->json('Missing required parameter: content', 400);
        }
        // Build and save the new group
        $group = new Group();
        $group->setTitle($request->request->get('title'));
        $group->setContent($request->request->get('content'));
        $app['dao.group']->save($group);
        $responseData = $this->buildArticleArray($group);
        return $app->json($responseData, 201);  // 201 = Created
    }

    /**
     * API delete group controller.
     *
     * @param integer $id group id
     * @param Application $app Silex application
     */
    public function deleteGroupAction($id, Application $app) {
        // Delete all associated depenses
        $app['dao.depense']->deleteAllByGroup($id);
        // Delete the group
        $app['dao.group']->delete($id);
        return $app->json('No Content', 204);  // 204 = No content
    }

    /**
     * Converts an group object into an associative array for JSON encoding
     *
     *
     *
     * @return array Associative array whose fields are the group properties.
     */
    private function buildGroupArray(Group $group) {
        $data  = array(
            'id' => $group->getId(),
            'name' => $group->getName(),
            );
        return $data;
    }
}