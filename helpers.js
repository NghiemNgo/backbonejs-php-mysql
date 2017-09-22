(function () {
  APP.helpers = {

    debug: function (collection) {
      collection.on('all', function () {
        $('#output').text(JSON.stringify(collection.toJSON(), null, 4));
      });
      collection.trigger('reset');
    },

    showErrors: function (note, errors) {
//      $('.has-error').removeClass('has-error');
//      $('.alert').html(_.values(errors).join('<br>')).show();

      // highlight the fields with errors
        $('.help-block').remove();
      _.each(_.keys(errors), function (key) {
        $('*[name=' + key + ']').parent().addClass('has-error');
        $('<span class="help-block has-error">'+ errors[key] +'</span>').insertAfter($('*[name=' + key + ']'));
      });
    }
  };
}());