Friends =
{
    init: function() {
        $('#content.container').on('click', 'a.friendship', this.friendshipToggle);
    },

    btnjq : null,

    friendshipToggle: function(e)
    {
        e.preventDefault();
        var that = Friends;
        that.btnjq = $(this);
        that.btnjq.find('> span.btn-title').hide();
        that.btnjq.find('> strong.title-loading').show();

        that.btnjq.attr('disabled', 'disabled');
        $.get(that.btnjq.attr('href'), 'json')
            .done(that.updateBtnContent)
            .always(function()
            {
                that.btnjq.find('> span.btn-title').show();
                that.btnjq.find('> strong.title-loading').hide();
                that.btnjq.removeAttr('disabled');
            });
    },

    updateBtnContent: function (d)
    {
        var btn = Friends.btnjq;
        btn.attr('href', d.route);
        [
            'friendship-add',
            'friendship-accept',
            'friendship-remove',
            'friendship-restore',
            'friendship-cancel',
            'btn-default',
            'btn-warning',
            'btn-primary',
            'btn-success'
        ].forEach(function(cl) { btn.removeClass(cl); });
        btn.addClass(d.class);
        btn.addClass(d.btncolor);
        btn.find('> span.btn-title > span.btn-label').text(d.title);
        var glyphicon = btn.find('> span.btn-title > span.glyphicon');
        [
            'glyphicon-plus',
            'glyphicon-minus',
            'glyphicon-remove',
            'glyphicon-repeat',
            'glyphicon-ok'
        ].forEach(function(gl) { glyphicon.removeClass(gl); });

        glyphicon.addClass(d.glyphicon);
    },

    updateBtns : function (data)
    {
        data.forEach(function (d)
        {
            Friends.btnjq = $('a#' + d.id + '.friendship');
            Friends.updateBtnContent(d.data);
        })
    }
};
