<?php

namespace compta\Domain;

class Depenses {
	private $id_depenses;
	private $montant;
	private $date;
	private $description;
	private $id_users;

	public function getIdDepenses() {
    	return $this->id_depenses;
    }

    public function setIdDepenses($id_depenses) {
    	$this->id_depenses = $id_depenses;
    }

    public function getMontant() {
    	return $this->montant;
    }

    public function setMontant($montant) {
    	$this->montant = $montant;
    }

    public function getDate() {
    	return $this->date;
    }
	public function setDate($date) {
		$this->date = $date;
	}
	public function  getDescription() {
		return $this->description;
	}  
	public function setDescription($description) {
		$this->description = $description;
	}

	public function getIdUser() {
		return $this->id_users;
	}

	public function setIdUsers(User $id_users) {
		$this->id_users=$id_users;
	}
	


}