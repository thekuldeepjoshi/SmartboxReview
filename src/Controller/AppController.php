<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    
    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function GetFavActivities($res) {       
        $max = array();
        rsort($res);
        for ($i = 0; $i < 3; $i++) {
            $max[] = $res[$i];
        }
        return $max;
    }

    public function GetWrostActivities($res) {
        $worst = array();
        sort($res);
        for ($i = 0; $i < 3; $i++) {
            $worst[] = $res[$i];
        }
        return $worst;
    }

    public function GetBestCust($res) {
        $bestCustomer = "NoCustFound"; 
        foreach($res as $result){
            $author[] = $result['author'];
        }
        foreach ($author as $current_key => $current_array) { //loop throught to each customer
            $search_key = array_search($current_array, $author); // search auther in the currnet array and return the key
            if ($current_key != $search_key) { // match current auther's key with search array key.
                $bestCustomer = $author[$current_key];  // if any duplicates found you have got the best customer.
            } 
        }
        return $bestCustomer;
    }

    public function GetCustUsage($res) {
        $ReusedActivity = "NoReusedActivity"; 
        foreach($res as $result){
            $activity[] = $result['activity_name'];
        }
        foreach ($activity as $current_key => $current_array) { //loop throught to each activity
            $search_key = array_search($current_array, $activity); // search activity in the currnet array and return the key
            if ($current_key != $search_key) { // match current activity's key with search array key.
                $ReusedActivity = $activity[$current_key];  // if any duplicates found you have got the bmost reused activity.
            } 
        }
        return $ReusedActivity;
    }

}
