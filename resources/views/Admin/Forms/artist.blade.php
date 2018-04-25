<div class="col-lg-12">
    @if($artist)
        <h1>Modifier "{{$artist->name}}"</h1>
        {{ Form::open(['route' => ['artist.update'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom..." value="{{$artist->name}}" name="name">
            <input type="text" class="form-control" id="nom" placeholder="Nom..." value="{{$artist->id}}" name="id" hidden>
        </div>
        <img src="{{env('APP_URL').'/uploads/'.$artist->avatar}}" class="img-thumbnail" height="150" width="150"/>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" id="photo" placeholder="Photo..." name="avatar">
        </div>
        <div class="form-group">
            <label for="photo">Extrait mp3:</label>
            <input type="file" class="form-control" id="photo" placeholder="mp3..." name="urlSample">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{Form::close()}}
    @else
        <h1>Ajouter un artiste</h1>
        {{ Form::open(['route' => ['artist.add'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom..." name="name">
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" name="avatar" id="photo" placeholder="Photo...">
        </div>
        <div class="form-group">
            <label for="photo">Extrait mp3:</label>
            <input type="file" class="form-control" id="photo" placeholder="mp3..." name="urlSample">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    @endif

</div>