<button id="{{ $user->id }}" type="button"
        class="btn btn-block btn-default friendship-remove"
        onclick="friendshipToggle(this, '{{ URL::route('friends.delete', ['user' => $user->id]) }}' );" >
    
    <span class="btn-title">
        <span class="glyphicon glyphicon-remove"></span>&nbsp;
        Delete from my friends
    </span>
    
    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</button>