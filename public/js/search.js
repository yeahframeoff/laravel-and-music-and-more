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

        this.searchEngine.on('loadingAll', this.showloadingAll, this);
        this.searchEngine.on('loadingPending', this.showLoadingPending, this);
        this.searchEngine.on('loaded', this.hideLoading, this);

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

Search.PeopleSearch = Backbone.Model.extend({
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
            $(window).on('scroll', onScroll);
        }

        this.on('loaded', this.onLoaded);

        $('#form-people-search').submit(this.submit);
    },
    submit: function(e) {
        e.preventDefault();

        var q = $('#form-people-search').find('input#query-text').val();
        this.lastQuery = q;
        this.fetch();
    },
    page: 1,
    loadedFirstTime: true,
    fetch: function() {
        this.trigger('loadingAll');
        $.get(this.route, {q: this.lastQuery}).done(this.loaded);
    },
    loaded: function(data) {
        if (this.loadedFirstTime) {
            Search.users.set(data.result);
            this.loadedFirstTime = false;
        }
        else
            Search.users.reset(data.result);
        this.trigger('loaded');
    },
    fetchMore: function() {
        this.trigger('loadingPending');
        $.get(this.route, {q: this.lastQuery, page: this.page + 1}).done(this.loadedMore);
    },
    loadedMore: function(data) {
        this.page++;
        this.collection.add(data.result);
        this.trigger('loaded');
    }
});

Search.users = new Search.UserCollection();
Search.peopleSearch = new Search.PeopleSearch({collection: Search.users});
Search.usersView = new Search.UserCollectionView({
    collection: Search.users,
    searchEngine: Search.peopleSearch
});

