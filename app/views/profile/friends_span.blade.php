<a class="h2" href="{{ \URL::route('friends', ['user' => $user->id]) }}">Друзья</a>
<hr>
<?php
$friends = $user->friends();
$friends = ($friends->count() > 6 ? $friends->random(6) : $friends);
?>
@foreach ($friends as $i => $friend)
    @if($i % 3 == 0)
        <span class="terminator"></span>
    @endif

    <div class="tile-3 square">
        <a href="{{ URL::route('profile', array('user' => $friend->id)) }}">
            {{
            HTML::image(
                $friend->photo,
                $friend->first_name . ' ' . $friend->last_name,
                [
                    'title' => $friend->first_name . ' ' . $friend->last_name,
                    'class' => 'img-thumbnail'
                ]
            ) }}
        </a>
    </div>
@endforeach