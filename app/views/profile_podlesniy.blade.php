<div class="container">
    <div class="row">
        <div class="col-sm-8"><h1>{{$user->first_name . ' ' . $user->last_name}}</h1></div>
        @unless ($user->id == \Karma\Auth\OAuth::getUserId())
        <div class="col-sm-8">
            @include ('friendship_button', ['user' => $user, 'current' => \Karma\Auth\OAuth::getUser()])
            {{-- HTML::linkAction('Karma\Controllers\ProfileController@addFriend', 'Add to friend', array('id' => $user->id)) --}}
        </div>
        @endunless
    </div>
    <div class="row">
    
        <div class="col-lg-3"><!--left col-->

            <ul class="list-group">
                <li class="list-group-item text-muted">Profile</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Info1</strong></span> Text1</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Info2</strong></span> Text2</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Info3</strong></span> Text3</li>
            </ul> 
            
            <a href="/users" class="pull-left"><img title="profile image" class="img-responsive" src={{$user->photo}}></a>
            
        </div><!--/col-3-->
                
        <div class="col-lg-3">
            <audio preload></audio>
            <div id="dz-root"></div>
            <br/>
            <ol>
                <!--
                <li><a href="#" data-src="https://cs9-1v4.vk.me/p12/4ed504c6d852b2.mp3?extra=bxHpPTsyZ_KltJAcPUd4BlIaPgnAQTJMzXo4DO-3nf1vlKqwg5yWnXPzkiIulNGMy4fk8lvV1mp6lhevxWqjF-b-11iNNNQ">karma police</a></li>
                <li><a href="#" data-src="https://cs9-1v4.vk.me/p4/aef0de06703409.mp3?extra=08fN6XbDsUAMnJ5nR6yLAjKReYL9EHTy9zXUq5eUJwmQPgXSMjZm3qELA6PCeKE2ECQ-Jv6ez50eCOXu_k_7ShyQKtau-Q">creep</a></li>
				-->
                @foreach($tracks as $track)
                	<li><a href="#" data-src="{{$track->track_url}}"> {{$track->track->title}}</a></li>
                @endforeach
            </ol>
        </div>
        
        <div class="col-lg-3 pull-right">
            <h1>Friends:</h1>

            {{--
            @if (isset($requests))
                @foreach($requests as $request)
                    {{ $request->first_name . ' ' . $request->last_name . ' (' . $request->id . ')'}}
                    {{ HTML::linkAction('Karma\Controllers\ProfileController@confirmFriend', 'Confirm', array('id' => $request->id))}}<br/>
                @endforeach
            @endif

            @foreach($friends as $friend)
                {{ $friend->first_name . ' ' . $friend->last_name . ' (' . $friend->id . ')'}}
                {{ HTML::linkAction('Karma\Controllers\ProfileController@deleteFriend', 'Delete', array('id' => $friend->id))}}<br/>
            @endforeach
            
            --}}
        </div>
    </div>
</div>