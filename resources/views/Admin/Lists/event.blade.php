<div>
    <ul class="list-group">
        @foreach($events as $e)
            <li class="list-group-item ">
                <div class="col-lg-6">
                    {{$e->title}}
                </div>
                <div class="col-lg-6">
                    <a href="{{route('form.event',['id'=>$e])}}" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="{{route('event.delete',$e->id)}}" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                </div>

            </li>
        @endforeach
    </ul>
</div>