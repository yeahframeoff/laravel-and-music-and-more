<button id="{{ $user->id }}" type="button"
        class="btn btn-block btn-warning friendship-cancel"
        onclick="friendshipToggle(this, '{{ URL::route('friends.cancel', ['user' => $user->id]) }}' );" >
    
    <span class="btn-title">
        <span class="glyphicon glyphicon-minus"></span>&nbsp;
        Cancel request
    </span>
    
    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</button>