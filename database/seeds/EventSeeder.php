<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 13/11/17
 * Time: 09:44
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
use App\Models\Event;
use Carbon\Carbon;
class EventSeeder extends Seeder
{
 public function run(){
     $event=Event::create(
         [
             'title'=>'Nuit du Zouglou',
             'description'=>'Un evenement a ne surtout pas rater...',
             'picture'=>'events/pictures/fUGUI3kPZHvG3qT6bSiTqMLu2H9iTix8QRJSRxWu.jpeg',
             'place_id'=>1,
             'begin'=>Carbon::createFromFormat('d/m/Y', '11/06/2017'),
             'end'=>Carbon::createFromFormat('d/m/Y', '15/06/2017'),
             'type_id'=>1
         ]
     );
     $artists=Artist::all();
     $artists->load('events');
     foreach ($artists as $artist){
         $artist->events()->attach($event);
     }

 }
}