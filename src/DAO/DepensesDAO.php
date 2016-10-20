<?php

namespace compta\DAO;

use app_compta\Domain\Depenses;

class DepensesDAO extends DAO {

	public function findAll() {
		$sql = "select * from depenses order by date desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$depenses = array();
		foreach ($result as $row) {
			$depenseID = $row["id_depenses"];
			$depenses[$depenseID] = $this->buildDomainObject($row);
		}
		return $depenses;
	}

	//returns a depense matching the supplied ID
	public function findById($id) {
        $sql = "select * from depenses where id_depenses=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $id);
    }

    //returns a depense matching the supplied date
    public function findByDate($date) {
        $sql = "select * from depenses where date=?";
        $row = $this->getDb()->fetchAssoc($sql, array($date));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching date " . $date);
    }

    //saves a depense intot the db
    public function save(Depenses $depense) {
        $depenseData = array(
            'montant' => $depense->getMontant(),
            'date' => $depense->getDate(),
            'description' => $depense->getDescription(),
            'id_users' => $depense->getIdUser()
            );

        if ($depense->getIdDepenses()) {
            // The depense has already been saved : update it
            $this->getDb()->update('depenses', $depenseData, array('id_depenses' => $depense->getIdDepenses()));
        } else {
            // The depense has never been saved : insert it
            $this->getDb()->insert('depenses', $depenseData);
            // Get the id of the newly created depense and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $depense->setIdDepenses($id);
        }
    }

    //removes a depense from the db
    public function delete($id) {
    	$this->getDb()->delete("depenses", array("id_depenses"=>$id));
    }

    //creates a depenses based object on a db row
    protected function buildDomainObject($row) {
        $depense = new Depenses();
        $depense->setIdDepenses($row['id_depenses']);
        $depense->setMontant($row['montant']);
        $depense->setDate($row['date']);
        $depense->setDescription($row['description']);
        $depense->setIdUsers($row['id_users']);
        return $depense;
    }

	
}