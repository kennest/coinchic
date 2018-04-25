<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Event;
use App\Models\Place;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Hash;

class clientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //Authenfication de l'Utilisateur
    public function authenticate(Request $request)
    {
        $request = $request->json()->all();
        $user = Users::where('email', $request['email'])->first();
        if ($user) {
            if (Hash::check($request['password'], $user->password)) {
                $apitoken = base64_encode(str_random(40));
                Users::where('email', $request['email'])->update(['api_token' => "$apitoken"]);
                return response()->json(['status' => 'success', 'api_token' => $apitoken]);
            } else {
                return response()->json(['status' => 'fail'], 401);
            }
        } else {
            return response()->json(['status' => 'Not Authentified'], 401);
        }
    }


    //SELECTIONNE TOUS LES ARTISTES
    public function allArtists()
    {
        $artists = Artist::All();
        $artists->load('events.place.address');
        $artists->toJson();
    }


    //PERMET DE SELECTIONNER TOUS LES EVENEMENTS ACTIFS
    public function allActiveEvents($type=null)
    {
        if($type){
            $events=Event::whereHas("type", function ($query) use($type) {
                $query->where('type', 'like', '%'.$type.'%');
            })->active()->get();
        }else{
        $events = Event::active()->get();
        }
        $events->load('artists', 'place.address','type');
        return $events->toJson();
    }

    public function allOtherActiveEvents()
    {
            $events=Event::whereHas("type", function ($query) {
                $query->where('type', '!=', 'Zouglou');
            })->active()->get();
        $events->load('artists', 'place.address','type');
        return $events->toJson();
    }


    //PERMET DE SELECTIONNER TOUS LES EVENEMENTS INACTIF
    public function allInactiveEvents($type=null)
    {
        if($type){
            $events=Event::whereHas("type", function ($query) use($type) {
                $query->where('type', 'like', '%'.$type.'%');
            })->inactive()->get();
        }else{
            $events = Event::inactive()->get();
        }
        
        $events->load('artists', 'place.address','type');
        return $events->toJson();
    }


    public function allOtherInactiveEvents()
    {
            $events=Event::whereHas("type", function ($query) {
                $query->where('type', '!=', 'Zouglou');
            })->inactive()->get();        
        $events->load('artists', 'place.address','type');
        return $events->toJson();
    }

    //PERMET DE SELECTIONNER TOUTES LES PLACES QUI ONT DES EVENEMENTS
    public function PlacesWithActiveEvents($type=null)
    {
        //On recupere les evenements qui on une date de fin pas encore passé        
        $places = Place::whereHas('events', function ($query) {
            $query->active();
        });
    
        if($type){
            $places = $places->whereHas('events.type', function ($query) use($type) {
                $query->where('type','like','%'.$type.'%');
            });
        }

        $places=$places->get();
        $places->load('events.artists', 'address','events.type');
        return $places->toJson();
    }

    public function SimilarEvents($word){
       $places=Place::whereHas('address' , function ($q) use($word){
             $q->where('commune','like','%'.$word.'%');
       })->get()->load(['events' => function ($query) {
           $query->where('end', '>=', Carbon::now()->toDateString());
       }]);
       $places=$places->load('events.place.address','events.artists','events.type');
       return $places->toJson();
    }

    //PERMET DE SELCTIONNER LES PLACES AVEC TOUS SES EVENEMENTS(actif ou inactif)
    public function PlacesWithEvents()
    {
        $places=Place::with('events')->get();
        return $places->toJson();
    }

    public function ArtistsWithEvents(){
        $artist = Artist::with('events.place.address')->get();
        return $artist->toJson();
    }

    //PERMET DE SELECTIONNER UN ARTIST
    public function getArtist($id)
    {

        //retourne l'artiste et les evenements auxquels il participe
        $artist = Artist::with(['events.place.address','events.type'])->findOrFail($id);

        return $artist->toJson();
    }

    //PERMET DE SELECTIONNER UN EVENEMENT
    public function getEvent($id)
    {
        //retourne l'event et l'artiste qui y participe
        $event = Event::with('artists','place.address','type')->findOrFail($id);
        return $event->toJson();
    }

    //PERMET DE SELECTIONNER UNE PLACE
    public function getPlace($id)
    {
        //retourne l'event et l'artiste qui y participe
        $place = Place::with('address','activeEvents.type')->find($id);
        
        return $place->toJson();
    }
}
