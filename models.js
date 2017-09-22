"use strict";
APP.crudModel = Backbone.Model.extend({
    // you can set any defaults you would like here
    url: function() {
      var id = this.get('id');
      return "crud.php?p=item&&id=" + id;
    },
    defaults: {
        name: "",
        address: "",
        email: "",
        phone: "",
        // just setting random number for id would set as primary key from server
        id: "",
        active: 0
    },

    validate: function (attrs) {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
        var errors = {};
        if (!attrs.name) {
            errors.name = "name must be required";
        }
        if (!attrs.address) {
            errors.address = "address must be required";
        }
        if (!attrs.email) {
            errors.email = "email must be required";
        } else if (!attrs.email.match(mailformat)) {
            errors.email = "You have entered an invalid email address!" ;
        }
        if (!attrs.phone) {
            errors.phone = "phone must be required";
        } else if(isNaN(attrs.phone)) {
            errors.phone = "phone must be numeric";
        }
        if (!_.isEmpty(errors))
            return errors;
    }
});

APP.crudCollection = Backbone.Collection.extend({
    name: 'crudCollection',
    model: APP.crudModel,
    url: 'crud.php',
});