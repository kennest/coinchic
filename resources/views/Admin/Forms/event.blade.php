<div class="col-lg-12">
	@if($event)
	<h1>Modifier {{$event->title}}</h1>
	{{ Form::open(['route' => ['event.update'],'files'=>true])}}
	<div class="form-group">
		<label for="nom">Titre:</label>
		<input type="text" class="form-control" id="nom" placeholder="Nom..." value="{{$event->title}}" name="title">
		<input hidden name="id" value="{{$event->id}}">
	</div>
	<img src="{{ env('APP_URL').'/uploads/'.$event->picture}}" height="150" width="150" class="img-thumbnail">
	<div class="form-group">
		<label for="photo">Affiche:</label>
		<input type="file" class="form-control" id="photo" placeholder="Photo..." name="picture">
	</div>
	<div class="form-group">
		<label>Type:</label>
		<select name="type_id" class="form-control">
			@foreach($types as $type)
			<option value="{{$type->id}}" {{$r=(($type->id==$event->type->id)) ? 'selected' : ''}}>{{$type->type}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="photo">Date de Debut:</label>
		<input type="date" name="begin" value="{{$event->begin}}" class="form-control">
	</div>
	<div class="form-group">
		<label for="photo">Date de Fin:</label>
		<input type="date" name="end" value="{{$event->end}}" class="form-control">
	</div>
	<div class="form-group">
		<label>Artistes:</label>	
		<select name="artists[]" class="form-control" multiple="true">
			@foreach($artists as $a)
			<option value="{{$a->id}}" {{$r=( in_array($a->id,$list)) ? 'selected' : ''}}>
				<h1>
				{{$a->name}}
				</h1>
			</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>Espaces:</label>
		<select name="place_id" class="form-control">
			@foreach($places as $p)
			<option value="{{$p->id}}" {{$r=( $p->id== $event->place_id) ? 'selected' : ''}}>
				{{$p->title}}
			</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<textarea name="description" placeholder="Description..." class="form-control">{{$event->description}}</textarea>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
	{{Form::close()}} @else
	<h1>Ajouter un Evenement</h1>
	{{ Form::open(['route' => ['event.add'],'files'=>true])}}
	<div class="form-group">
		<label for="nom">Titre:</label>
		<input type="text" class="form-control" id="nom" placeholder="Nom..." value="" name="title">
	</div>
	<div class="form-group">
		<label for="photo">Affiche:</label>
		<input type="file" class="form-control" id="photo" placeholder="Photo..." name="picture">
    </div>
    <div class="form-group">
		<label>Type:</label>
		<select name="type_id" class="form-control">
			@foreach($types as $type)
			<option value="{{$type->id}}">{{$type->type}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="photo">Date de Debut:</label>
		{!! Form::date('begin', \Carbon\Carbon::now(),['class'=>'form-control']); !!}
	</div>
	<div class="form-group">
		<label for="photo">Date de Fin:</label>
		{!! Form::date('end', \Carbon\Carbon::now(),['class'=>'form-control']); !!}
	</div>
	<div class="form-group">
		<label>Artistes:</label>
		<select name="artists[]" class="form-control" multiple="true">
			@foreach($artists as $a)
			<option value="{{$a->id}}">{{$a->name}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>Espaces:</label>
		<select name="place_id" class="form-control">
			@foreach($places as $p)
			<option value="{{$p->id}}">{{$p->title}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<textarea name="description" placeholder="Description..." class="form-control"></textarea>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
	{{ Form::close() }} @endif

</div>