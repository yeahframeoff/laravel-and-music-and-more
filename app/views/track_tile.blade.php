<h5>
    @if ($isTemplate)
        <% if (importedTrack == true) { %>
            <a href="#"
               data-src="{{ $trackUrl }}"
               data-cover="{{ $trackCover }}">
                <strong>{{ $trackArtistName }}</strong>&nbsp;-&nbsp;{{ $trackTitle }}
            </a>
            &nbsp;
            <a href="#" class="addTrack" data-id="{{ $trackId }}" deezer="{{ $isSetDeezer }}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        <% } else { %>
            <a href="#"
               data-src="{{ $importedTrackUrl }}"
               data-cover="{{ $importedTrackCover }}">
                <strong>{{ $trackArtistName }}</strong>&nbsp;-&nbsp;{{ $trackTitle }}
            </a>
            &nbsp;
            <a href="#" class="addTrack" data-id="{{ $importedTrackId }}" deezer="{{ $isSetDeezer }}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        <% } %>
    @else
    @if($importedTrack == true)
        <a href="#"
           data-src="{{ $trackUrl }}"
           data-cover="{{ $trackCover }}">
            <strong>{{ $trackArtistName }}</strong>&nbsp;-&nbsp;{{ $trackTitle }}
        </a>
        &nbsp;
        <a href="#" class="addTrack" data-id="{{ $trackId }}" deezer="{{ $isSetDeezer }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @else
        <a href="#"
           data-src="{{ $importedTrackUrl }}"
           data-cover="{{ $importedTrackCover }}">
            <strong>{{ $trackArtistName }}</strong>&nbsp;-&nbsp;{{ $trackTitle }}
        </a>
        &nbsp;
        <a href="#" class="addTrack" data-id="{{ $importedTrackId }}" deezer="{{ $isSetDeezer }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
    @endif

    @if ($isTemplate)
        <% if (isNotEmptyAlbums) { %>
            ({{ $albumss }})
        <% } %>
    @elseif ($isNotEmptyAlbums)
        ({{ $albumss }})
    @endif
</h5>