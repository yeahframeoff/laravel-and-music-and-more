<button id="{{ $user->id }}" type="button"
        class="btn btn-block btn-success friendship-accept"
        onclick="friendshipToggle(this, '{{ URL::route('friends.confirm', ['user' => $user->id]) }}' );" >
    
    <span class="btn-title">
        <span class="glyphicon glyphicon-ok"></span>&nbsp;
        Accept request
    </span>
    
    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</button>