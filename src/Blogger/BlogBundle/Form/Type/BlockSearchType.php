<?php

namespace Blogger\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class BlockSearchType extends AbstractType
{
    private $request;
    private $keySearch;
    
    public function __construct(Request $request, $keySearch)
    {
        $this->request = $request;
        $this->keySearch = $keySearch;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //print_r($options); die;
        $builder->add('keySearch', null, array(
            'attr' => array(
                'placeholder' => 'code postal, ville, restaurant, type de cuisine, ou plats…',
                'id' => 'search',
                'class'=> 'search-query form-control'
                
                ),
            'data' => $this->keySearch,
            )
        );
    }
      

    public function getName()
    {
        return 'simple_search';
    }
}
