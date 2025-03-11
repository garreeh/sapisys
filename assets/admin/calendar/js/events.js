(function ($) {
  "use strict";

  var today = new Date();
  var dd = today.getDate();

  var mm = today.getMonth() + 1;
  var yyyy = today.getFullYear();

  if (dd < 10) {
    dd = "0" + dd;
  }

  if (mm < 10) {
    mm = "0" + mm;
  }
  today = yyyy + "-" + mm + "-" + dd;
  console.log(today);

  var options = {
    events_source: "./../../controllers/admin/calendar_events_process.php",
    view: "month",
    tmpl_path: "tmpls/",
    tmpl_cache: false,
    day: today,
    onAfterEventsLoad: function (events) {
      if (!events) {
        return;
      }
      var list = $("#eventlist");
      list.html("");

      $.each(events, function (key, val) {
        $(document.createElement("li"))
          .html('<a href="' + val.url + '">' + val.title + "</a>")
          .appendTo(list);
      });
    },
    onAfterViewLoad: function (view) {
      $(".page-header h3").text(this.getTitle());
      $(".btn-group button").removeClass("active");
      $('button[data-calendar-view="' + view + '"]').addClass("active");
    },
    classes: {
      months: {
        general: "label",
      },
    },
  };
  var calendar = $("#showEventCalendar").calendar(options);
  $(".btn-group button[data-calendar-nav]").each(function () {
    var $this = $(this);
    $this.click(function () {
      calendar.navigate($this.data("calendar-nav"));
    });
  });
  $(".btn-group button[data-calendar-view]").each(function () {
    var $this = $(this);
    $this.click(function () {
      calendar.view($this.data("calendar-view"));
    });
  });
  $("#first_day").change(function () {
    var value = $(this).val();
    value = value.length ? parseInt(value) : null;
    calendar.setOptions({ first_day: value });
    calendar.view();
  });
  $("#language").change(function () {
    calendar.setLanguage($(this).val());
    calendar.view();
  });
  $("#events-in-modal").change(function () {
    var val = $(this).is(":checked") ? $(this).val() : null;
    calendar.setOptions({ modal: val });
  });
  $("#format-12-hours").change(function () {
    var val = $(this).is(":checked") ? true : false;
    calendar.setOptions({ format12: val });
    calendar.view();
  });
  $("#show_wbn").change(function () {
    var val = $(this).is(":checked") ? true : false;
    calendar.setOptions({ display_week_numbers: val });
    calendar.view();
  });
  $("#show_wb").change(function () {
    var val = $(this).is(":checked") ? true : false;
    calendar.setOptions({ weekbox: val });
    calendar.view();
  });
})(jQuery);
