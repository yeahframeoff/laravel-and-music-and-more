<button id="{{ $user->id }}" type="button"
        class="btn btn-block btn-primary friendship-add"
        onclick="friendshipToggle(this, '{{ URL::route('friends.add', ['user' => $user->id]) }}' );" >
    
    <span class="btn-title">
        <span class="glyphicon glyphicon-plus"></span>&nbsp;
        Add to my friends
    </span>
    
    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</button>