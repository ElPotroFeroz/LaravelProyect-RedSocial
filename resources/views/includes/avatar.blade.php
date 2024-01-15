@if(auth::user()->image)
    <image src="{{ route('user.avatar', ['filename' => auth::user()->image]) }}" class="avatar"/>
@endif
