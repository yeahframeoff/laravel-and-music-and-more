<a  id="{{ $userid }}"
    class="btn btn-block {{ $btncolor }} friendship {{ $btnClass }}"
    href="{{ $route }}" >

    <span class="btn-title">
        <span class="glyphicon {{ $glyphicon }}"></span>&nbsp;
        <span class="btn-label">{{ $title }}</span>
    </span>

    <strong hidden class="title-loading">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
    </strong>
</a>