function friendshipToggle(btn)
{
    $btn = $(btn);
    $btn.find('span.glyphicon').toggleClass('glyphicon-minus');
    $btn.find('span.glyphicon').toggleClass('glyphicon-plus');
    $btn.toggleClass('btn-primary');
    $btn.toggleClass('btn-default');
    $btn.find('span.title-add').toggle();
    $btn.find('span.title-remove').toggle();
}