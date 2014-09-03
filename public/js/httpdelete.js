HttpDelete =
{
    init: function()
    {
        $('#content.container').on('click', '.please-work-http-delete-button', this.executeDelete);
    },
    executeDelete: function(e)
    {
        e.preventDefault();
        var href   = $(this).attr('href'),
            method = $(this).data('method');
        $.ajax({
            url : href,
            type: 'post',
            data: {_method: method}
        })
        .done(function(data)
        {
            if (data.hasOwnProperty('url'))
                window.location.href = data.url;
        });
    }
};