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
//        $P = $io->ask('Enter valid Smartbox product Id');
//        $N = $io->ask('Enter Number of pages for search');
//        $C = $io->askChoice('Enter Valid Country Code', ['ie', 'fr','de','ch','se','nl','it','es','dk'], 'fr');
        
//    if (strlen($C) > 5) {
//        // Halt execution, output to stderr, and set exit code to 1
//        $io->error('Name must be at least 4 characters long.');
//        $this->abort();
//    }
    $P = "848358";
    $N = "2";
    $C = "fr";
    $data = array();
    $getData = new Client(); // object of class Client to fetch the data from given URL
    $getItems = new \App\Controller\AppController(); // object of class AppController to get the results.
    
        
        for ($i = 1; $i <= $N; $i++) {
            $page = array('page'=>$i);
            $url = "https://www.smartbox.com/$C/smartbox-review/ajax/loadreviews/id/$P/?";
            $response = $getData->get($url,$page); //get method of Client class
            $data[] = $response->getJson(); //getjson method from Response class.
        }
        if (!empty($data)) {
            foreach ($data as $res) {
             $getItems->GetFavActivities($res);   
            }
        }
    }
    
}

    
   