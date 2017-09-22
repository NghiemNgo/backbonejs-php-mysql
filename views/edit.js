"use strict";
APP.crudEditView = Backbone.View.extend({
    // functions to fire on events
    events: {
        "click button.save": "save"
    },

    // the template
    template: _.template($('#formTemplate').html()),

    initialize: function (options) {
        this.model.bind('invalid', APP.helpers.showErrors, APP.helpers);
        this.model.bind('invalid', this.invalid, this);
    },

    invalid: function () {
        this.$el.find('a.cancel').hide();
    },

    save: function (event) {
        event.stopPropagation();
        event.preventDefault();
        var at = this.$el.find('input[name=active]').prop('checked');
        if (at) {
            at = 1;
        } else {
            at = 0;
        }
        // update our model with values from the form
        this.model.set({
            id: this.model.id,
            name: this.$el.find('input[name=name]').val(),
            email: this.$el.find('input[name=email]').val(),
            phone: this.$el.find('input[name=phone]').val(),
            address: this.$el.find('textarea[name=address]').val(),
            active: at
        });

        if (this.model.isValid()) {
            if (this.model.save) {
                new APP.AlertView.show("CRUD", "Edited Success", "success");
            } else {
                new APP.AlertView.show("CRUD", "Edited Error", "danger");
            }
            var id = this.model.id;
            var nm = this.$el.find('input[name=name]').val();
            var em = this.$el.find('input[name=email]').val();
            var hp = this.$el.find('input[name=phone]').val();
            var ad = this.$el.find('textarea[name=address]').val();
        }

        $.post("crud.php?p=edit", {id: id, name: nm, email: em, phone: hp, address: ad, active: at}, function (data) {
            Backbone.history.navigate("crud/index", {trigger: true});
        });
    },

    // populate the html to the dom
    render: function () {
        this.$el.html(
                this.template(this.model.toJSON())
                );
        return this;
    }
});