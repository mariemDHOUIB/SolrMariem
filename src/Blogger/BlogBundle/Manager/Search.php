<?php

namespace Blogger\BlogBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use Solarium\Client;

/**
 * Solr Search Engine Manager
 *
 * @author Karim MILADI <karim.miladi@sifast.com>
 */
class Search
{
    protected $request;
    protected $solariumClient;
    protected $solrQuery;
    protected $data;
    protected $method;
    
    public function __construct(Request $request, Client $solariumClient, $method="POST")
    {
        $this->request = $request;
        $this->solariumClient = $solariumClient;
        $this->method = $method;
    }
    
    /**
     * Make Solr query 
     * @return $query
     */
    public function makeSearchQuery()
    {
        if($this->request->request->get('simple_search')) {
            $this->data = $this->request->request->get('simple_search');
        }

        $query = $this->solariumClient->createSelect();

        // Construction Solr query (parameter "q")
        $this->buildkeyWordSearch();

        // Assign query
        $query->setQuery($this->solrQuery);
        $query->addParam('qt','dismax');
        return $query;
    }


    /**
     * Generate clause for simple search (keyword)
     * @return void
     */
    public function buildkeyWordSearch()
    {
    	$q = '';
    	if(!empty($this->data['keySearch'])){
            
            $separator = ',';
            $listKeysSearch = explode($separator, $this->data['keySearch']);
            $listKeysSearch = array_values(array_filter(array_map('trim', $listKeysSearch)));
            foreach ($listKeysSearch as $id => $keySearch) {
                if (trim($keySearch)) {
                    if ($id != count($listKeysSearch)-1) {
                        $q .= sprintf('(*%s*) OR ', $keySearch);
                    }
                    else {
                        $q .= sprintf('(*%s*)', $keySearch);
                    }
                }
            }
            
    	}
        $solrQueryAfter = $this->concateneQuery($this->solrQuery, $q);
        $this->solrQuery = $solrQueryAfter;        
    }




    public function generateFilterCheckSearchQuery($filtername){

        if(!empty($this->data[$filtername])){
            $q='('.$filtername.':"';
            $q .= implode('" OR '.$filtername.':"',$this->data[$filtername]);
            $q .='")';
            return $q;
        }
        return "";
    }
    /**
     * Concatene 2 clauses of Solr query
     * Handles parentheses and junction operator between clauses
     * @param $solrQuery
     * @param $solrQueryToConcat
     * @return $solrQueryAfter
     *
     */


    public function getSpellCheck($query){

        // add spellcheck settings
        $spellcheck = $query->getSpellcheck();
        $spellcheck->setQuery($this->solrQuery);
        $spellcheck->setCount(10);
        $spellcheck->setBuild(true);
        $spellcheck->setCollate(true);
        $spellcheck->setExtendedResults(true);
        //$spellcheck->setCollateExtendedResults(true);
    }


    public function getWords($result){

        if ($result == null){
            return "";
        }
        $spellcheckResult = $result->getSpellcheck();
        $spell ="";
        if(isset($spellcheckResult)){
            $suggestions = $spellcheckResult->getSuggestions();
            foreach($suggestions as $line){
                if(end($suggestions) != $line)
                    $spell .= $line->getWord()." , ";
                else
                    $spell .= $line->getWord();
            }
        }
        return $spell;
    }


    public function makeCustomSerchQuery(){
        if($this->method == "POST"){
            if($this->request->request->get('simple_search')) {
                $this->data = $this->request->request->get('simple_search');
            }
        }else{
            if($this->request->query->get('simple_search')) {
                $this->data = $this->request->query->get('simple_search');
            }
        }
        $query = $this->solariumClient->createSelect();
        $this->solrQuery = $this->data['keySearch'];
        $query->setQuery($this->solrQuery);
        $query->addParam('qt','dismax');
        return $query;
    }

    private function concateneQuery($solrQuery, $solrQueryToConcat) {
        $solrQueryAfter = $solrQuery;
        if ($solrQueryToConcat) {
            if (!$solrQuery) {
                $solrQueryAfter = $solrQueryToConcat;
            } else {
                $solrQueryAfter = $solrQuery . $this->getJoin() . $solrQueryToConcat;
            }
        }
        return $solrQueryAfter;
    }

    /**
     * Get the junction operator between clauses
     * @return string
     */
    public function getJoin() {
        return ' AND ';
    }   
    
}