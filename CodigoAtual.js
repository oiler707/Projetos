﻿function control() {
  var unlimited, prefix, time, mode, credits, group, html, event, limited, splitted, label, devices, rule,
    remove, renew, period, temp_prefix, temp_renew_day, temp_renew_hour  , temp_day_month , data, show_prop,
    hide_prop, hide_css  , show_css, week, month, hour, validation;

  var input = receiver;

  var init = function() {
    html = "";
    event = false;
    limited = false;
    splitted = ["","","",""];
    hide_prop = {style: "opacity: 1; pointer-events:none;", disabled: true };
    show_prop = {style: "opacity: 1; pointer-events:all; ", disabled: false};
    hide_css  = {"opacity": 0.3, "pointer-events": "none"};
    show_css  = {"opacity": 1  , "pointer-events": "all" };
    week = $();
    month = $();
    hour  = $();
    if (input && input.type == "credits") {
      temp_renew_day = "renew-credits-day";
      temp_renew_hour = "renew-credits-hour";
      temp_day_month = "renew-credits-day-number";
      rule = "renew-credits";
      unlimited = $("#unlimited-credits");
      time = $("#renew-credits-extension");
      mode = $("#toggle-credits-mode");
      credits = $("#initial-credits");
      group = $("#credits-options");
      temp_prefix = "day-prefix";
      credits.prop(hide_prop);
      disable();
      limited = !(unlimited.val() === "enabled");
      if (input && input.periodo && !limited)
        period.val(input.periodo);

      setEventUnlimited();
      if (!event || !event.change || !event.change.length) {
        unlimited.on('change',function() {
          init();
        });
      }
      if (limited) {
        if (input && input.periodo) {
          if (skylineConf != "slave_active") {
            enable();
            credits.prop(show_prop);
          }
          setEventPeriod();
          if (!event || !event.change || !event.change.length) {
            updatePeriod();
          }
          if (send !== true) {
            clean();
            if (period.val() === "daily") {
              getDaily();
            }
            if (period.val() === "weekly") {
              getWenkly();
              if (!event || !event.change || !event.change.length) {
                week.on('change', function() {
                  (week.val() === "0" || week.val() === "6") ? prefix.text("no") : prefix.text("na");
                });
              }
              week.trigger('change');
            }
            if (period.val() === "monthly") {
              getMonthly();
            }
            updateTime();
          }
        }
      }
      if (send == true) {
        getData();
        if (period.val() == "disabled" || validation) {
          if (!limited )
            period.val("");

        } else {
          send["error"] = "<br> - Você deve informar um horário para renovação de créditos.";
        }
      }
    }
    if (input && input.type == "devices") {
      temp_renew_day = "time_week";
      temp_renew_hour = "time_hour";
      temp_day_month = "time_month";
      rule = "auto_remove";
      unlimited = $("#unlimited_devices");
      time = $("#remove_time");
      label = $('label[for="auto_remove"]');
      devices = $("#amount_devices");
      group = $("#devices_options");
      temp_prefix = "time_prefix";
      unlimited.css(hide_css).prop("disabled", true).next().css(hide_css);
      devices.css(hide_css).prop("disabled", true).next().css(hide_css);

      if (skylineConf != "slave_active") {
        unlimited.css(show_css).prop("disabled", false).next().css(show_css);
      }
      disable();
      limited = !unlimited.prop("checked");
      if (input && input.periodo && !limited)
        period.val(input.periodo);

      setEventUnlimited();
      if (!event || !event.click || !event.click.length) {
        unlimited.on('click', function() {
          devices.prop("disabled", unlimited.prop("checked"));
          init();
        });
      }
      if (limited) {
        if (input && input.periodo) {
          if (skylineConf != "slave_active") {
            enable();
            devices.css(show_css).prop("disabled", false).next().css(show_css);
          }
          setEventPeriod();
          if (!event || !event.change || !event.change.length) {
            updatePeriod();
          }
          if (send !== true) {
            clean();
            if (period.val() === "daily") {
              getDaily();
            }
            if (period.val() === "weekly") {
              getWenkly();
              if (!event || !event.change || !event.change.length) {
                week.on('change', function() {
                  (week.val() === "0" || week.val() === "6") ? prefix.text("no") : prefix.text("na");
                });
              }
              week.trigger('change');
            }
            if (period.val() === "monthly") {
              getMonthly();
            }
            updateTime();
          }
        }
      }
      if (send == true) {
        getData();
        if (period.val() == "disabled" || validation) {
          if (!limited )
            period.val("");

        } else {
          send["error"] = "<br> - Você deve informar um horário para auto remover dispositivos inativos.";
        }
      }
    }
  }

  var setEventUnlimited = function() {
    event = $._data(unlimited[0], "events");
  }
  var setEventWeek = function() {
    event = $._data(week[0], "events");
  }
  var setEventPeriod = function() {
    event = $._data(period[0], "events");
  }
  var updateTime = function() {
    hour.mask("99:99");
    hour.timepicker({
      showLeadingZero: true,
      hourText: 'Hora',
      minuteText: 'Minuto',
      minutes: { starts: 0, ends: 59, interval: 1}
    });
  }
  var setDaily = function() {
    hour.val(input.hora + ":" + input.minuto);
  }
  var setWenkly = function() {
    week.val(input.dia_semana);
  }
  var setMonthly = function() {
    month.val(input.dia_mes );
  }
  var getData = function() {
    assingMonthly();
    assingWenkly ();
    assingDaily  ();
    validation = (hour && hour.val() && (hour.val().indexOf(':') > -1));
    splitted   = (validation ? hour.val ().split (":"):["",""] ).concat(week && week.val() || "", month && month.val() || "");
    data = {
      "periodo": period.val(),
      "hora": splitted[0],
      "minuto": splitted[1],
      "dia_semana": splitted[2],
      "dia_mes": splitted[3]
    };
    send = {};
    send[rule] = data;
  }
  var assingDaily = function() {
    hour = $("#" + temp_renew_hour);
  }
  var assingWenkly = function() {
    week = $("#" + temp_renew_day);
  }
  var assingMonthly = function() {
    month = $("#" + temp_day_month);
  }
  var getDaily = function() {
    html += " às <input type='text' class='form-control inputa width-30px padleft-2px' id='" + temp_renew_hour + "'> horas.";
    time.html(html);
    assingDaily();
    setDaily();
  }
  var getWenkly = function() {
    var config = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado" ]
    html += "<span id='" + temp_prefix +   "' style='padding-right:4px'> </span>";
    html += "<select class='selecta'   id='" + temp_renew_day + "'>";
    $(config).each(function(i, e) {
      html += "<option value='" + i + "'> " + e +"</option>";
    });
    html += "</select>";
    getDaily();
    assingWenkly();
    prefix = $("#" + temp_prefix);
    setEventWeek();
    setWenkly();
  }
  var getMonthly = function() {
    html += "no dia <img id='imagem' src='imagens/info.png' class='info'";
    html += " title='Se for informado o dia 29, 30 ou 31, e o mês atual terminar antes da data informada, a remoção acontecerá no último dia do mês.'";
    html += " style='cursor: pointer; display:inline-block;margin-right:2px' ></img>";
    html += "<select class='selecta' id='" + temp_day_month + "'>";
    for (var i = 1; i <= 31; i++) {
      html += "<option value='" + i + "'>" + i + "</option>";
    }
    html += "</select>";
    getDaily();
    assingMonthly();
    setMonthly();
  }
  var enable = function() {
    group.prop(show_prop);
    period.prop(show_prop);
    hour  .prop(show_prop);
    week  .prop(show_prop);
    month .prop(show_prop);
  }
  var disable = function() {
    period = $("#" + rule);
    group.prop(hide_prop ).css("opacity", 0.3);
    period.prop(hide_prop);
    hour  .prop(hide_prop);
    week  .prop(hide_prop);
    month .prop(hide_prop);
  }
  var clean = function() {
    html = "";
    time.html(html);
  }
  var updatePeriod = function() {
    period.on('change', function() {
      init();
    });
    period.val(input.periodo);
  }
  init();
}