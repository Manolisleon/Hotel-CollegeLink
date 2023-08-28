$(document).ready(function () {
  var checkin = $("#datepicker1");
  var checkout = $("#datepicker2");

  checkin.datepicker({
      minDate: 0,
      dateFormat: 'yy-mm-dd',
      onSelect: function (selectedDate) {
          var minCheckoutDate = new Date(selectedDate);
          minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
          checkout.datepicker("option", "minDate", minCheckoutDate);
      }
  });

  checkout.datepicker({
      minDate: 1,
      dateFormat: 'yy-mm-dd'
  });
});
