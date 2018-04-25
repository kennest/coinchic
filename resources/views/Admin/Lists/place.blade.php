<div>
    <ul class="list-group">
        @foreach($places as $p)
            <li class="list-group-item ">
                <div class="col-lg-6">
                    {{$p->title}}
                </div>
                <div class="col-lg-6">
                    <a href="{{route('form.place',['id'=>$p])}}" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="{{route('place.delete',$p->id)}}" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                </div>
            </li>
        @endforeach
    </ul>
</div>