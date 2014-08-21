<h3><strong>{{ $track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->title }}&nbsp;
    <?php
    $albums = array();
    foreach ($track->albums as $album)
        $albums[] = $album->name;
    ?>
    @if (!empty($albums))({{ implode (', ', $albums) }}) @endif
</h3>
<hr>