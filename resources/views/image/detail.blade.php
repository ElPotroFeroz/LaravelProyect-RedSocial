@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h4><a href="{{ route('home') }}" style="color:gray">Volver</a></h4>
        <div class="col-md-8">
            @include('includes.message')
            
                <div class="card pub_image pub_image_detail">
                    <div class="card-header">
                        @if($image->user->image)
                        <div class="container-avatar">
                            <image src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar"/>                
                        </div>
                        @endif
                        <div class="data-user">
                            {{ $image->user->nick }}
                        </div>
                    </div>

                    <div class="card-body">
                        @if($image->image_path)
                        <div class="image-container">
                            <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" />  
                        </div>
                        
                        <div class="description">
                            {{ $image->description }}
                            </br> 
                            {{ $image->created_at }}
                        </div>
                        @if(Auth::user() && Auth::user()->id == $image->user->id)
                            <div class="actions">
                                <a href="{{route('image.edit', ['id' =>$image->id])}}" class="btn btn-sm btn-warning">Edit</a>
<!--                                <a href="{{route('image.delete', ['id' => $image->id])}}" class="btn btn-sm btn-danger">Delete</a>             -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                  Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar imagen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        ¿Estas seguro de que queires elimiarla?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Cancel</button>
                                        <a href="{{route('image.delete', ['id' => $image->id])}}" class="btn btn-sm btn-danger">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        @endif                       
                        <div class="likes">
                            <!--Check if the user hit like to the image -->
                            <?php $user_like = false; ?>
                            @foreach($image->likes as $like)
                                @if($like->user->id == \Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach
                            @if($user_like)
                                <img src="{{ asset('img/corazonrojo.png') }}" data-id="{{$image->id}}" class="btn-dislike" />
                            @else
                                <img src="{{ asset('img/corazongris.png') }}" data-id="{{$image->id}}" class="btn-like"/>
                            @endif
                            <span class="number_likes">{{count($image->likes)}}</span>
                        </div>
                        
                        <div class="coment">                           
                            <h3>Coments ({{count($image->coments)}})</h3>
                            <hr>
                            <form method="POST" action="{{ route('coment.save') }}">
                                @csrf
                                
                                <input type="hidden" name="image_id" value="{{$image->id}}"/>
                                <p>
                                    <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" autofocus></textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                            <hr>
                            @foreach($image->coments as $coment)
                                <div class="content">
                                    <span class="nickname">{{ '@'.$coment->user->nick }}</span>
                                    <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($coment->created_at) }}</span>
                                    </br>
                                    <strong>{{ $coment->content }}</strong>
                                    @if(Auth::check() && ($coment->user_id == Auth::user()->id || $coment->image->user_id == Auth::user()->id))                                  
                                       <a href="{{ route('coment.delete', ['id' => $coment->id]) }}" class="btn btn-sm btn-danger">
                                           Eliminar
                                       </a>                                   
                                    @endif
                                    </br></br>
                                </div>
                            @endforeach
                        </div>
                    </div>
                        @endif
                </div>           
        </div>         
    </div>   
</div>
@endsection

