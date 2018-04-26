<div class="col-lg-12">
    @if($place)
        <h1>Modifier "{{$place->title}}"</h1>
        {{ Form::open(['route' => ['place.update'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Titre:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom de l'espace..." value="{{$place->title}}" name="title">
            <input type="text" class="form-control" id="nom" placeholder="Nom..." value="{{$place->id}}" name="id" hidden>
        </div>
        <img src="{{env('APP_URL').'/uploads/'.$place->picture}}" class="img-thumbnail" height="150" width="150"/>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" id="photo" placeholder="Photo de la devanture..." name="picture">
        </div>
        <hr>
        <fieldset>
            <legend>Addresse</legend>
            <div class="form-group">
                <label>Commune:</label>
                <select name="district" class="form-control">
                    @foreach($districts as $d)
                        @if($place->district===$d))
                        <option value="{{$d}}"  selected="true">{{$d}}</option>
                            @else
                            <option value="{{$d->id}}">{{$d->label}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div id="map"></div>
            <input hidden id="lat" name="lat" value="{{$place->address->lat}}">
            <input hidden id="long" name="long" value="{{$place->address->long}}">
        </fieldset>

        <button type="submit" class="btn btn-primary">Submit</button>

        <script>
            var oldmarkers = [];

            function initMap() {
                var lat ={{$place->geolocation->lat}};
                var long ={{$place->geolocation->long}};
                var placecoord = {lat: lat, lng: long};

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: placecoord
                });

                var marker = new google.maps.Marker({
                    position: placecoord,
                    map: map,
                    title: '{{$place->title}}'
                });

                oldmarkers.push(marker);


                map.addListener('click', function (e) {
                    placeMarkerAndPanTo(e.latLng, map);
                    $('input#lat').attr('value', e.latLng.lat);
                    $('input#long').attr('value', e.latLng.lng);
                });
            }

            function placeMarkerAndPanTo(latLng, map) {
                //Remove current marker
                oldmarkers.forEach(function (t) {
                    t.setMap(null);
                });

                //add new marker
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                oldmarkers.push(marker);
                map.panTo(latLng);
            }
        </script>

        {{Form::close()}}
    @else
        <h1>Ajouter un Espace</h1>
        {{ Form::open(['route' => ['place.add'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Titre:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom de l'espace..." name="title">
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" id="photo" placeholder="Photo de la devanture..." name="picture">
        </div>
        <fieldset>
            <legend>Addresse</legend>
            <div class="form-group">
                <label for="photo">Commune:</label>
                <select name="district" class="form-control">
                    @foreach($districts as $d)
                        <option value="{{$d->id}}">{{$d->label}}</option>
                    @endforeach
                </select>
            </div>
            <div id="map"></div>
            <input hidden id="lat" name="lat" value=""/>
            <input hidden id="long" name="long" value=""/>
        </fieldset>
        <hr/>
        <button type="submit" class="btn btn-primary">Submit</button>
        <script>
            var oldmarkers = [];

            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: {lat: 5.3482788, lng: -4.0377703}
                });

                map.addListener('click', function (e) {
                    placeMarkerAndPanTo(e.latLng, map);
                    $('input#lat').attr('value', e.latLng.lat);
                    $('input#long').attr('value', e.latLng.lng);
                });
            }

            function placeMarkerAndPanTo(latLng, map) {
                //Remove current marker
                oldmarkers.forEach(function (t) {
                    t.setMap(null);
                });

                //add new marker
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                oldmarkers.push(marker);
                map.panTo(latLng);
            }
        </script>

        {{ Form::close() }}
    @endif

</div>
