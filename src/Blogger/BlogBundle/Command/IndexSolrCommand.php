<?php
/**
 * Created by PhpStorm.
 * User: mariem
 * Date: 26/07/16
 * Time: 11:42
 */

 namespace  Blogger\BlogBundle\Command;



 use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
 use Symfony\Component\Console\Input\InputArgument;
 use Symfony\Component\Console\Input\InputInterface;
 use Symfony\Component\Console\Input\InputOption;
 use Symfony\Component\Console\Output\OutputInterface;

 class IndexSolrCommand extends ContainerAwareCommand
 {
     protected function configure()
     {
         $this
             ->setName('demo:IndexFromSolr')
             ->setDescription('index the database values ')

         ;
     }

     protected function execute(InputInterface $input, OutputInterface $output)
     {
         $manager = $this->getContainer()->get('restaurantmanager');
         $restaurants = $manager->getAll();
         // get an update query instance
         $solrClient = $this->get('solarium.client');
         $update = $solrClient->createUpdate();

        // create a new document for the data
        // please note that any type of validation is missing in this example to keep it simple!
         

         foreach ($restaurants as $restaurant) {
             get_object_vars ($restaurant);
             
             $doc = $update->createDocument();   
                 foreach ($restaurant as $key=>$value) {
                     $doc->$key = $value;
                 }
                 // add the document and a commit command to the update query
                 $update->addDocument($doc);
                 $update->addCommit();
                 // this executes the query and returns the result
                 $result = $solrClient->update($update);

         }
             
         }
       
     
 }
