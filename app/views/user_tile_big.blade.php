<div class="user-tile-big">
    <div class="container-fluid" id="{{$user->id}}">
        <div class="row">
            <div class="col-md-5">
                <div class="user-tile-pic-big">
                    <img src="{{$user->photo}}" alt="{{$user->first_name . ' ' . $user->last_name }}" class="img-thumbnail">
                </div>
            </div>
            <div class="col-md-7">
                <a class="h3" href="#{{--$user->profileUrl()--}}" style="text-align: center">
                    {{ $user->first_name . ' ' . $user->last_name }}
                </a>

                
                @if ($user->id != $current->id)
                    @include ('friendship_button', ['user' => $user, 'current' => $current])
                @endif

                <a href="#" class="btn btn-success btn-block">
                    <span class="glyphicon glyphicon-headphones"></span>
                    <span class="title"><strong>Listen music</strong></span>
                </a>
                
                <a href="{{\URL::route('friends', ['user' => $friend->id ]) }}"
                   class="btn btn-default btn-block" >
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="title"><strong>Watch friends</strong></span>
                </a>
            </div>
        </div>
    </div>
</div>