@extends('layouts.app')

<h1>Editar foto</h1>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar imagen</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            @if($image)
                                <div class="profile-edit">
                                    <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" class=""/>                
                                </div>
                            @endif
                        </div>
                        <form method="POST" action="{{route('image.update')}}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}"/>
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Descripción</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autofocus>{{$image->description}}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection