(function ($, Drupal) {
    Drupal.behaviors.officeFilter = {
      attach: function (context, settings) {
        var officesByCountry = settings.offices.officesByCountry;
  
        window.showOffices = function(country) {
          var officeList = $('#office-list');
          officeList.empty(); // Clear the current list
  
          if (officesByCountry[country]) {
            officesByCountry[country].forEach(function(office) {
              var officeItem = $('<div>', { class: 'office-item' });
  
              $('<h2>', { class: 'office-name', text: 'Name: ' + office.name }).appendTo(officeItem);
              $('<p>', { class: 'office-address', text: 'Address: ' + office.address }).appendTo(officeItem);
              $('<p>', { class: 'office-phone', text: 'Phone: ' + office.phone }).appendTo(officeItem);
              $('<p>', { class: 'office-email', text: 'Email: ' + office.email }).appendTo(officeItem);
  
              officeItem.appendTo(officeList);
            });
          } else {
            officeList.html('<p>No offices found for the selected country.</p>');
          }
        };
      }
    };
  })(jQuery, Drupal);
  