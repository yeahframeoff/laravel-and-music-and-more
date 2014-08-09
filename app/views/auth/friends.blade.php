@foreach($requests as $request)
	{{ $request->first_name . ' ' . $request->last_name . ' (' . $request->id . ')'}}
    {{ HTML::linkAction('Karma\Controllers\ProfileController@confirmFriend', 'Confirm', array('id' => $request->id))}}<br/>
@endforeach

@foreach($friends as $friend)
	{{ $friend->first_name . ' ' . $friend->last_name . ' (' . $friend->id . ')'}}
    {{ HTML::linkAction('Karma\Controllers\ProfileController@deleteFriend', 'Delete', array('id' => $friend->id))}}<br/>
@endforeach