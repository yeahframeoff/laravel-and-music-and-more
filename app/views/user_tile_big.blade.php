<div class="user-tile-big">
    <div class="container-fluid" id="{{ $id }}">
        <div class="row">
            <div class="col-md-5">
                <div class="user-tile-pic-big">
                    <a href="{{ $profileUrl }}">
                        <img src="{{ $photoUrl}} "
                             alt="{{ $username }}"
                             class="img-thumbnail">
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <a class="h3" href="{{ $profileUrl }}">
                    {{ $username }}
                </a>

                @if ($isTemplate)
                    <% if (isAnotherUser) { %>
                    @include ('friendship_button', $friendshipBtnData)
                    <% } %>
                @elsif ($user->id != \Karma\Auth\OAuth::getUserId())
                    @include ('friendship_button', $friendshipBtnData)
                @endif

                <a href="{{ $audioUrl }}" class="btn btn-success btn-block">
                    <span class="glyphicon glyphicon-headphones"></span>
                    <span class="title"><strong>Listen music</strong></span>
                </a>
                
                <a href="{{ $friendsUrl }}"
                   class="btn btn-default btn-block" >
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="title"><strong>Watch friends</strong></span>
                </a>
                <a href="{{ $messagesUrl }}"
                   class="btn btn-default btn-block send-message" >
                    <span class="glyphicon glyphicon-envelope"></span>
                    <span class="title"><strong>Send message</strong></span>
                </a>
            </div>
        </div>
    </div>
</div>