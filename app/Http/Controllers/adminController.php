<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 16:35
 */

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artist;
use App\Models\Event;
use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;


class adminController extends Controller
{
    const AVATAR_DIR = '/artists/avatars';
    const SAMPLES_DIR = '/artists/samples';
    const PLACE_PIC_DIR = '/places/pictures';
    const EVENT_PIC_DIR = '/events/pictures';
    const COMMUNE = array('Abobo', 'Adjamé', 'Atécoubé', 'Cocody', 'Koumassi', 'Marcory', 'Plateau', 'Port-Bouet', 'Treichville', 'Yopougon');

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        $places = Place::all();
        $events=Event::all();
        return view('Admin.index', compact( 'places','events'));
    }

    public function artistForm($id = null)
    {
        $artist = Artist::find($id);
        return view('Admin.artistForm', compact('artist'));
    }

    public function placeForm($id = null)
    {
        $communes=$this::COMMUNE;
        $place = Place::find($id);
        return view('Admin.placeForm', compact('place','communes'));
    }

    public function eventForm($id = null)
    {
        $types=Type::all();
        $artists = Artist::all();
        $event = Event::find($id);
        $places = Place::all();
        if ($id) {
            $event->load('artists', 'place','type');
            $event_artists = $event->artists()->get();

            $list = array();
            foreach ($event_artists as $a) {
                array_push($list, $a->id);
            }

        }
        return view('Admin.eventForm', compact('event', 'places', 'artists', 'list','types'));
    }

    //********************************************AJOUT***************************************************************//
    //PERMET D'AJOUTER UN ARTISTE
    public function addArtist(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'urlSample' => 'required|file|mimes:mpga|max:4096',
        ]);

        $artist = new Artist();
        $artist->name = $request->input('name');

        //Avatar upload
        $picture = $request->file('avatar');
        $avatar = Storage::disk('upload')->putFile($this::AVATAR_DIR, $picture);

        //sample upload
        $audio = $request->file('urlSample');

        $sample = Storage::disk('upload')->putFile($this::SAMPLES_DIR, $audio);

        $artist->avatar = $avatar;
        $artist->urlsample = $sample;
        $artist->save();
        return redirect()->route('admin.index');
    }

    //PERMET D'AJOUTER UN ESPACE
    public function addPlace(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'commune' => 'required',
            'quartier' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        $place = new Place();
        $address = new Address();
        $place->title = $request->input('title');

        //Picture upload
        $picture = $request->file('picture');

        $pic = Storage::disk('upload')->putFile($this::PLACE_PIC_DIR, $picture);

        $place->picture = $pic;

        $place->save();

        //data-binding
        $address->commune = $request->input('commune');
        $address->quartier = $request->input('quartier');
        $address->lat = $request->input('lat');
        $address->long = $request->input('long');

        //associate with place
        $address->place()->associate($place);
        $address->save();
        return redirect()->route('admin.index');
    }

    //PERMET D'AJOUTER UN EVENEMENT
    public function addEvent(Request $request)
    {
        $this->validate($request, [
            'artists' => 'required|array',
            'place_id' => 'required|integer'
        ]);


        $artists = $request->input('artists');

        $place = Place::find($request->input('place_id'));
        $event = new Event();

        $type=Type::find($request->input('type_id'));
        //data-binding
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->begin = $request->input('begin');
        $event->end = $request->input('end');

        $pic = $request->file('picture');
        $picture = Storage::disk('upload')->putFile($this::EVENT_PIC_DIR, $pic);

        $event->picture = $picture;

        //associate with place
        $event->place()->associate($place);
        $event->type()->associate($type);
        $event->save();

        //Synchronisation avec les IDs d'artistes
        $event->artists()->sync($artists);

        return redirect()->route('admin.index');
    }

    //********************************************SELECTION***************************************************************//

    //PERMET DE SELECTIONNER UN ARTIST
    public function getArtist(Request $request)
    {
        $id = $request->input('id');

        //retourne l'artiste et les evenements auxquels il participe
        $artist = Artist::with('events')->findOrFail($id);

        return response()->json($artist);
    }

    //PERMET DE SELECTIONNER UN EVENEMENT
    public function getEvent(Request $request)
    {
        $id = $request->input('id');


        //retourne l'event et l'artiste qui y participe
        $event = Event::with('artists')->findOrFail($id);

        return response()->json($event);
    }

    //PERMET DE SELECTIONNER UNE PLACE
    public function getPlace(Request $request)
    {
        $id = $request->input('id');

        //retourne l'event et l'artiste qui y participe
        $place = Place::with(['events', 'addresses'])->findOrFail($id);

        return response()->json($place);
    }

    //********************************************MODIFICATION***************************************************************//

    //PERMET DE MODIFIER UN ARTISTE
    public function updateArtist(Request $request)
    {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $artist = Artist::find($id);
        $artist->name = $request->input('name');

        //Si les images on ete chargees on upload les nouveaux
        if ($request->file('avatar')) {
            $oldAvatar = $artist->avatar;
            //Avatar upload
            $picture = $request->file('avatar');
//            $avatar = time() . '.' . $picture->extension();
//            $picture->move(public_path($this::AVATAR_DIR), $avatar);

            $avatar = Storage::disk('upload')->putFile($this::AVATAR_DIR, $picture);
            Storage::disk('upload')->delete($oldAvatar);
            $artist->avatar = $avatar;

        }

        if ($request->file('urlSample')) {
            $oldSample = $artist->urlsample;

            //sample upload
            $audio = $request->file('urlSample');
//            $sample = time() . '.' . $audio->getClientOriginalExtension();
//            $audio->move(public_path($this::SAMPLES_DIR), $sample);

            $sample = Storage::disk('upload')->putFile($this::SAMPLES_DIR, $audio);

            Storage::disk('upload')->delete($oldSample);

            $artist->urlsample = $sample;

        }

        $artist->save();

        return redirect()->route('admin.index');
    }

    //PERMET DE MODIFIER UN ESPACE
    public function updatePlace(Request $request)
    {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $place = Place::find($id);
        $place->load('address');
        $address = $place->address()->get();

        $address = $address->first();

        $place->title = $request->input('title');

        $oldPic = $place->picture;

        if ($request->file('picture')) {
            //Picture upload
            $picture = $request->file('picture');
            $pic = Storage::disk('upload')->putFile($this::PLACE_PIC_DIR, $picture);
            $place->picture = $pic;
        }


        $address->commune = $request->input('commune');
        $address->quartier = $request->input('quartier');
        $address->lat = $request->input('lat');
        $address->long = $request->input('long');

        var_dump($address);
        //$place->address()->associate($address);

        Storage::disk('upload')->delete($oldPic);

        $address->save();
        $place->save();

        return redirect()->route('admin.index');

    }

    //PERMET DE MODIFIER UN EVENEMENT

    public function updateEvent(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'id' => 'required',
        ]);
        $id = $request->input('id');

        //On recupere l'Event
        $events = Event::all();
        $event = $events->find($id);

        if ($request->file('picture')) {
            $oldpic = $event->picture;

            $pic = $request->file('picture');
            $picture = Storage::disk('upload')->putFile($this::EVENT_PIC_DIR, $pic);
            Storage::disk('upload')->delete($oldpic);
            $event->picture = $picture;
        }


        //On lui associe le nouvel espace
        $event->place_id = $request->input('place_id');
        $event->type_id=$request->input('type_id');

        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->begin = $request->input('begin');
        $event->end = $request->input('end');


        //On synchronise avec la nouvelle liste de ID d'artistes
        $artists = $request->input('artists');
        $event->artists()->sync($artists);
        $event->save();
        return redirect()->route('admin.index');
    }

    //********************************************SUPPRESSION***************************************************************//

    public function deleteArtist($id = null)
    {

        //On recupere l'artiste et on charge les events
        $artists = Artist::all();
        $artist = $artists->find($id);
        $artist->load('events');

        //recuperation des events
        $events = $artist->events()->get();

        //Recuperation de l'avatar
        $avatar = $artist->avatar;
        $sample = $artist->urlsample;

        if ($artist->delete()) {

            //pour chaque event on detache l'artiste actuel
            foreach ($events as $event) {
                $event->artists()->detach($artist->id);
            }

            //On supprime l'avatar
            Storage::disk('upload')->delete($avatar);
            Storage::disk('upload')->delete($sample);

            return redirect()->route('admin.index');
        }


    }

    public function deletePlace($id = null)
    {

        //Recuperation de l'espace
        $places = Place::all();
        $place = $places->find($id);

        $picture = $place->picture;

        //Chargement des events lies
        $place->load('events', 'address');
        $events = $place->events()->get();
        $address = $place->address()->first();

        //on supprime l'address
        if ($address->delete()) {
            //ensuite Suppression de la place
            if ($place->delete()) {
                //Suppression de tous les events lies
                foreach ($events as $event) {
                    $this->deleteEvent($event->id);
                }
                Storage::disk('upload')->delete($picture);
            }
        }


        return redirect()->route('admin.index');
    }

    public function deleteEvent($id = null)
    {
        $events = Event::all();
        $event = $events->find($id);

        $pic = $event->picture;
        $event->load('artists');
        $artists = $event->artists()->get();

        if ($event->delete()) {
            foreach ($artists as $artist) {
                $artist->events()->detach();
            }
            Storage::disk('upload')->delete($pic);
        }
        return redirect()->route('admin.index');
    }
}
