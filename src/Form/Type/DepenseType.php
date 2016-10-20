<?php


namespace compta\Form\Type;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;


class DepenseType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder->add('date', ' ');
         $builder->add('montant', 'float');
         $builder->add('description','text');
         $builder->add('id_users', 'int ');

    }


    public function getName()

    {

        return 'depense';

    }

}
