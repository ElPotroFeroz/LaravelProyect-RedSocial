<div class="card pub_image">

        <div class="card-header">
            <a href="{{route('profile', ['id' => $image->user->id])}}"  style="text-decoration: none; color: black;">
                @if($image->user->image)
                <div class="container-avatar">
                    <image src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar"/>                
                </div>
                @endif
                <div class="data-user">
                    {{ $image->user->nick }}
                </div>
            </a>
        </div>

        <div class="card-body">
            @if($image->image_path)
            <div class="image-container">
                <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                    <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" /> 
                </a>
            </div>

            <div class="description">
                {{ $image->description }}
                </br>
                {{ \FormatTime::LongTimeFilter($image->created_at) }}
            </div>

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
                <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-warning bet-comments">
                    Coments ({{count($image->coments)}})
                </a>
            </div>
        </div>
            @endif
    </div>
