$(function() {

var SearchUser = Backbone.Model.extend({

});

var SearchUserView = Backbone.View.extend({
    tagName: 'div',
    template: _.template($('#search-user-template').html()),
    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    }
});

var SearchUserCollection = Backbone.Collection.extend({
    model: SearchUser
});

var SearchUserCollectionView = Backbone.View.extend({
    el: $('#people-fetched'),
    initialize: function() {
        this.collection.on('add', this.addOne, this);
        console.log(this.$el);
    },
    render: function() {
        console.log('Render!');
        this.collection.each(this.addOne, this);
        return this;
    },
    addOne: function (user) {
        console.log('Add One!');
        var userView = new SearchUserView({model: user});
        this.$el.append(userView.render().el);
    }
});

var PeopleSearchForm = Backbone.View.extend({
    el: '#form-people-search',
    events: {
        'submit' : 'submit'
    },
    submit: function(e) {
        e.preventDefault();

        var q = this.$el.find('input#query-text').val();
        this.model.fetch(q);
    }
});

var PeopleSearch = Backbone.Model.extend({
    fetch: function(q)
    {
        $.get(this.route, {q: q}).done(this.done);
    },
    done: function(data)
    {
        console.log(data);
        searchUserCollection.reset(data.result);
    }
});

var searchUserCollection = new SearchUserCollection;
var peopleSearch = new PeopleSearch({collection: searchUserCollection});
var peopleSearchForm = new PeopleSearchForm({model: peopleSearch});
var searchUserCollectionView = new SearchUserCollectionView({
    collection: searchUserCollection
});

});