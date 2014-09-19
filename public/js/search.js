var Search = {};

Search.User = Backbone.Model.extend({});

Search.UserView = Backbone.View.extend({
    tagName: 'div',
    className: 'user-tile-big',
    template: _.template($('#search-user-template').html()),
    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    }
});

Search.UserCollection = Backbone.Collection.extend({
    model: Search.User,
    page: 1
});

Search.UserCollectionView = Backbone.View.extend({
    el: '#people-fetched',
    initialize: function() {
        this.collection.on('add', this.addOne, this);
        this.collection.on('reset', this.render, this);

        this.options.searchForm.on('loadingAll', this.showloadingAll, this);
        this.options.searchForm.on('loadingPending', this.showLoadingPending, this);
        this.options.searchForm.on('loaded', this.hideLoading, this);

        this.render();
    },
    render: function() {
        this.clear();
        this.collection.each(this.addOne, this);
        return this;
    },
    addOne: function (user) {
        var userView = new Search.UserView({model: user});
        this.$el.append(userView.render().el);
    },
    clear: function() {
        this.$el.html('');
    },

    showloadingAll: function() {
        console.log('loading all');
        this.$el.hide();
        $('#loading-span').show();
    },
    showLoadingPending: function() {
        console.log('loading pending');
        $('#loading-span').show();
    },
    hideLoading: function() {
        console.log('loaded');
        this.$el.show();
        $('#loading-span').hide();
    }
});

Search.PeopleSearch = Backbone.View.extend({
    el: '#form-people-search',
    events: {
        'submit' : 'submit'
    },
    initialize: function() {
        var instance = this;
        this.onScroll = function() {
            if ($(window).scrollTop() != 0 && $(window).scrollTop() == $(document).height() - $(window).height())
            {
                $(window).off('scroll', this.onScroll);
                instance.fetchMore();
            }
        };

        $(window).on('scroll', this.onScroll);

        this.onLoaded = function() {
            $(window).on('scroll', this.onScroll);
        }

        this.on('loaded', this.onLoaded);
    },
    submit: function(e) {
        e.preventDefault();

        var q = this.$el.find('input#query-text').val();
        this.lastQuery = q;
        this.fetch();
    },
    page: 1,
    loadedFirstTime: true,
    fetch: function() {
        var This = this;
        this.trigger('loadingAll');
        $.get(this.route, {q: this.lastQuery}).done(function(data) {
            if (This.loadedFirstTime) {
                This.collection.set(data.result);
                This.loadedFirstTime = false;
            }
            else
                This.collection.reset(data.result);
            This.trigger('loaded');
        });
    },
    fetchMore: function() {
        var This = this;
        this.trigger('loadingPending');
        $.get(this.route, {q: this.lastQuery, page: this.page + 1}).done(function(data) {
            This.page++;
            This.collection.add(data.result);
            This.trigger('loaded');
        });
    },
});

Search.users = new Search.UserCollection();
Search.peopleSearchForm = new Search.PeopleSearch({collection: Search.users});
Search.usersView = new Search.UserCollectionView({
    collection: Search.users,
    searchForm: Search.peopleSearchForm
});

