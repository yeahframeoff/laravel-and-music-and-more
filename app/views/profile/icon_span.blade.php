{{
HTML::image(
    $user->photo,
    $user->first_name . ' ' . $user->last_name,
    [
        'title' => $user->first_name . ' ' . $user->last_name,
        'class' => 'img-thumbnail',
    ]
) }}

<hr>
@if ($user->id == KAuth::getUserId())
<a class="btn btn-warning btn-block" href="{{ URL::route('import.sync') }}">
    <span class="glyphicon glyphicon-refresh"></span>&nbsp;<strong>Sync</strong>
</a>
@else
@include ('friendship_button', ['user' => $user])
@endif

<br>
@if($user->id == KAuth::getUserId())
<div class="btn-group">
    @foreach ($user->credentials as $cr)
    <a class="btn" href="{{ URL::route('profile.load', ['name' => $cr->social->name]) }}">
        <img src="{{ $cr->social->iconUrl() }}">
        {{ $cr->social->title }} @if($cr) <span class="glyphicon glyphicon-ok"></span>@endif
    </a>
    @endforeach

</div>

<div class="dropdown">
    <a href="#" class="dropdown-toggle btn" data-toggle="dropdown">
        <span class="glyphicon glyphicon-plus"></span>
        <b class="caret"></b>
    </a>

    <ul class="dropdown-menu">

        @foreach(Karma\Entities\Social::all() as $sn )
        @unless ($user->socials()->get()->contains($sn))
        <li><a href="{{URL::route('auth.connect', ['provider' => $sn->name])}}">{{ $sn->title }}</a></li>
        @endunless
        @endforeach
    </ul>
</div>
@endif