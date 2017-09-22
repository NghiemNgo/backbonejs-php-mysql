"use strict";
APP.crudIndexView = Backbone.View.extend({

    template: _.template($('#indexTemplate').html()),
    
    events: {
        'click .item-destroy': 'destroy'
    },
    destroy: function (e) {
        $('#modalDelete .modal-content .modal-body .content').html("are you sure delete ?");
        $('#modalDelete').modal('toggle');
        var id = $(e.currentTarget).attr("data-id");
        var crud = this.collection.get(id);
        $('#delete').click(function(){
            $('#modalDelete').modal('hide');
            if (crud.destroy()) {
                new APP.AlertView.show("CRUD", "Deleted Success", "success");
            } else {
                new APP.AlertView.show("CRUD", "Deleted Error", "danger");
            }
            $.post("crud.php?p=trash", {id: id}, function (data) {
                Backbone.history.navigate("crud/index", {trigger: true});
            });
        });
    },
    render: function () {
        this.$el.html(
                this.template({cruds: this.collection.toJSON()})
                );
        return this;
    }
});