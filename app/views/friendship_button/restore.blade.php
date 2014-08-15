<button id="{{ $user->id }}" type="button"
        class="btn btn-block btn-primary friendship-restore"
        onclick="friendshipToggle(this, '{{ URL::route('friends.restore', ['user' => $user->id]) }}' );" >
    
    <span class="btn-title">
        <span class="glyphicon glyphicon-repeat"></span>&nbsp;
        Restore friend
    </span>
    
    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</button>