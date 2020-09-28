<?php

/**
 * Description of GetReviewCommand
 *
 * @author Kuldeep Joshi
 */

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;

class GetReviewCommand extends Command {

    public function execute(Arguments $args, ConsoleIo $io) {
        $P = $io->ask('Enter valid Smartbox product Id');
        $N = $io->ask('Enter Number of pages for search');
        $C = $io->askChoice('Enter Valid Country Code', ['ie', 'fr','de','ch','se','nl','it','es','dk']);
//        $P = "848358";
//        $N = "2";
//        $C = "fr";
        
        $data = array();
        $items = array();
        $getData = new Client(); // object of class Client to fetch the data from given URL
        $getItems = new \App\Controller\AppController(); // object of class AppController to get the results.

        for ($i = 1; $i <= $N; $i++) {
            $page = array('page' => $i);
            $url = "https://www.smartbox.com/$C/smartbox-review/ajax/loadreviews/id/$P/?";
            $response = $getData->get($url, $page); //get method of Client class
            $data[] = $response->getJson(); //getjson method from Response class.
        }
        if (!empty($data)) {    
            foreach ($data as $result) {
                $items[]=$result['items'];
            }
            $itemsMerged = array_merge([], ...$items); // merge the itmes array into a single array : helps the comparasion
            $mostfav = $getItems->GetFavActivities($itemsMerged); 
            $io->out("\n \t ======> 3 most favourite activities <====== \n \n");
            foreach($mostfav as $value){
               $io->out("Activity Rating => {$value['rating']}     Activity name => {$value['activity_name']}");                
               $io->out("Customer => {$value['author']}");
               $io->out("Comments => {$value['comment']}\n \n");
            }
            $worst =  $getItems->GetWrostActivities($itemsMerged); 
            $io->out("\n \t======> 3 Worst  activities <====== \n \n");
            foreach($worst as $value){
               $io->out("Activity Rating => {$value['rating']}     Activity name => {$value['activity_name']}");                
               $io->out("Customer => {$value['author']}");
               $io->out("Comments => \n{$value['comment']}\n \n");
            }
            $bestCust =  $getItems->GetBestCust($itemsMerged); 
            if($bestCust =="NoCustFound"){
                $bestCust = $mostfav[0]['author'];
            }  
            $io->out("\n\t ======> Best Customer <====== \n ");
            $io->out("Best Customer for this Activity is  {$bestCust}.");
            $reusedActivity =  $getItems->GetCustUsage($itemsMerged); 
            $io->out("\n\t ======> Reused Activity <====== \n");
            if ($reusedActivity !="NoReusedActivity"){
                $io->out("Most Reused Activity is   {$reusedActivity}.");
            }else{
               $io->out("No reused Activity Found"); 
            }
//            $io->createFile('SmartBoxReview.pdf', $string,true);  //create pdf file with the given string
        } else {
            $io->error('Sorry! No Data found. Please Check Product Id, Number of pages or Country in input.');
            $this->abort();
        }
    }

}
