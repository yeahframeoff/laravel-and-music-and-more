<?php
if (empty($btndata))
    $btndata = Karma\FriendButtonComposer::compose($user);
?>
<a  id="{{$user->id}}"
    class="btn btn-block {{ $btndata['btncolor'] }} friendship {{ $btndata['class'] }}"
    href="{{ $btndata['route'] }}" >

    <span class="btn-title">
        <span class="glyphicon {{ $btndata['glyphicon'] }}"></span>&nbsp;
        <span class="btn-label">{{ $btndata['title'] }}</span>
    </span>

    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</a>
<?php $btnData = array(); ?>