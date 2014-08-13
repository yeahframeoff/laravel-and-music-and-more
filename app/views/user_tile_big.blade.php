<div class="user-tile-big">
    <div class="container-fluid" id="{{$user->id}}">
        <div class="row">
            <div class="col-md-5">
                <div class="user-tile-pic-big">
                    <img src="{{$user->photo}}" alt="{{$user->first_name . ' ' . $user->last_name }}" class="img-thumbnail">
                </div>
            </div>
            <div class="col-md-7">
                <h3>{{ $user->first_name . ' ' . $user->last_name }}</h3>

                @if ($user->id != $current->id)

                    @if ($user->isFriend ($current->id))
                        <button type="button" class="btn btn-default btn-block friendship-remove" onclick="friendshipToggle(this);">
                            <span class="glyphicon glyphicon-minus"></span>
                            <span class="title title-remove"><strong>Remove from my friends</strong></span>
                            <span class="title title-add" hidden="hidden"><strong>Add to my friends</strong></span>
                        </button>

                    @else
                        <button type="button" class="btn btn-primary btn-block friendship-add" onclick="friendshipToggle(this);">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="title title-add"><strong>Add to my friends</strong></span>
                            <span class="title title-remove" hidden="hidden"><strong>Remove from my friends</strong></span>
                        </button>

                    @endif

                @endif

                <a href="#{{--$user->profileUrl()--}}" class="btn btn-default btn-block" >
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="title"><strong>Watch profile</strong></span>
                </a>

                <a href="#" class="btn btn-success btn-block">
                    <span class="glyphicon glyphicon-headphones"></span>
                    <span class="title"><strong>Listen music</strong></span>
                </a>
            </div>
        </div>
    </div>
</div>