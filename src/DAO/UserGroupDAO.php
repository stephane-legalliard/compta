<?php

namespace compta\DAO;

use compta\Domain\UserGroup;

class UserGroupADO extends DAO 
{
    
    public function findAll() {
        $sql = "select * from user_group order by id_user_group";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_user_group'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function findById($id) {
        $sql = "select * from user_group where id_user_group=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No group matching id " . $id);
    }

    public function findByName($name) {
        $sql = "select * from user_group where group_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($name));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No group matching name " . $name);
    }

    //save group

    public function save(UserGroup $group) {
        $groupData = array(
            "group_name" => $group->getGroupName()
        );

        if ($group->getIdGroup()) {
            // The group has already been saved : update it
            $this->getDb()->update('user_group', $groupData, array('id_user_group' => $group->getIdGroup()));
        } else {
            // The group has never been saved : insert it
            $this->getDb()->insert('user_group', $groupData);
            // Get the id of the newly created group and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $group->setId($id);
        }


    //delete group
    public function delete($id) {
        $this->getDB()->delete("user_group", array("id_user_group"=>$id));
    }


    //creates a group object based on a DB row
    protected function buildDomainObject($row) {
        $group = new UserGroup();
        $group->setIdGroup($row['id_user_group']);
        $group->setGroupName($row['group_name']);
        return $group;
    }


    }    

}