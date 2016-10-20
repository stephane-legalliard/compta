<?php

namespace compta\Domain;

class UserGroup
{
   
    private $id_user_group;

    
    private $group_name;


    public function getId() {
        return $this->id_user_group;
    }

    public function setId($id_user_group) {
        $this->id_user_group = $id_user_group;
    }
    
    //name

    public function getGroupName() {
        return $this->group_name;
    }

    public function setGroupName($group_name) {
        $this->group_name = $group_name;
    }

}