<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method AS HttpMethod;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blogger\BlogBundle\Form\Type\BlockSearchType;

class SearchController extends Controller
{

    /**
     *
     * @Template
     */
    public function blockSearchAction()
    {
        $request = $this->get('request');
        //echo "<pre>"; print_r($request);die;
        $simpleSearch = $request->request->get('simple_search');
        $form = $this->createForm(new BlockSearchType($request, $simpleSearch['keySearch']));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     *
     * @Route("/search", name="search")
     * @HttpMethod({"GET", "POST"})
     * @Template
     */
    public function executeSearchAction()
    {   $request = $this->get('request');
           //echo "<pre>"; print_r($request);die;
        $simple_search = $request->query->get('simple_search');
        $resultsPerPage = 5;
        $solariumClient = $this->get('solarium.client');
        $searchService =$this->get('blogger_blog.search');
        $query = $searchService->makeSearchQuery();
        //$query->setRows($resultsPerPage);
        //$query->setFields(array('id','nom','prenom'));
        //$query->setStart(isset($simple_search['start'])?$simple_search['start']:0)->setRows($resultsPerPage);

        $searchService->getSpellCheck($query);
        $allResults = $solariumClient->select($query);
        $spell = $searchService->getWords($allResults);
        $result = array();
        foreach($allResults as $line){
            $result[] = (array)$line->getFields();
        }
        $totalResults = $allResults->getNumFound();
        

        print_r($spell);
        return $this->render('BloggerBlogBundle:Search:search.html.twig', array(
                    'spell' => $spell,
        ));

    }

}
