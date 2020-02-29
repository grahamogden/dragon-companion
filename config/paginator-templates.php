<?php
return [
    'nextActive'     => '<a class="next btn btn-secondary" rel="next" href="{{url}}" role="button">{{text}}</a>',
    'nextDisabled'   => '<a class="next disabled btn btn-secondary" href="" onclick="return false;" role="button">{{text}}</a>',
    'prevActive'     => '<a class="prev btn btn-secondary" rel="prev" href="{{url}}" role="button">{{text}}</a>',
    'prevDisabled'   => '<a class="prev disabled btn btn-secondary" href="" onclick="return false;" role="button">{{text}}</a>',
    'counterRange'   => '{{start}} - {{end}} of {{count}}',
    'counterPages'   => '{{page}} of {{pages}}',
    'first'          => '<a class="first btn btn-secondary" href="{{url}}" role="button">{{text}}</a>',
    'last'           => '<a class="last btn btn-secondary" href="{{url}}" role="button">{{text}}</a>',
    'number'         => '<a class="btn btn-secondary" href="{{url}}" role="button">{{text}}</a>',
    'current'        => '<a class="active btn btn-secondary disabled" href="" role="button">{{text}}</a>',
    'ellipsis'       => '<li class="ellipsis">...</li>',
    'sort'           => '<a href="{{url}}">{{text}}</a>',
    'sortAsc'        => '<a class="asc" href="{{url}}">{{text}}</a>',
    'sortDesc'       => '<a class="desc" href="{{url}}">{{text}}</a>',
    'sortAscLocked'  => '<a class="asc locked" href="{{url}}">{{text}}</a>',
    'sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>',
];