<?php
$current = \KAuth::user();
$sentRequest = $current->friendships()->requests()->where('friend_id', '=', $user->id)->exists();
$receivedRequest  = $current->friendshipz()->requests()->where('user_id', '=', $user->id)->exists();
$isFriend    = $user->isFriend ($current->id);
$isNotFriend = !$user->isFriend ($current->id) && !$sentRequest && !$receivedRequest;

$data = ['user' => $user, 'current' => $current];
?>

@if ($isFriend)
    @include ('friendship_button.remove', $data)
@elseif ($isNotFriend)
    @include ('friendship_button.add', $data)
@elseif ($sentRequest)
    @include ('friendship_button.sent', $data)
@elseif ($receivedRequest)
    @include ('friendship_button.received', $data)
@endif
