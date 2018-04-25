<div>
    <ul class="list-group">
        @foreach($artists as $a)
            <li class="list-group-item">
                <div class="col-lg-6">
                    {{$a->name}}
                </div>
                <div class="col-lg-6">
                    <a href="{{route('form.artist',['id'=>$a])}}" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="{{route('artist.delete',$a->id)}}" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                </div>
            </li>
        @endforeach
    </ul>
</div>