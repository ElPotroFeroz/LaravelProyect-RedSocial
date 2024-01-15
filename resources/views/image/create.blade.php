@extends('layouts.app')

<h1>Subir foto</h1>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Subir nueva imagen</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="image_path" class="col-md-4 col-form-label text-md-end">Imagen</label>

                                <div class="col-md-6">
                                    <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" required autofocus>

                                    @error('image_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image_path') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 
                            
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Descripción</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autofocus></textarea>

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
                                        Subir
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