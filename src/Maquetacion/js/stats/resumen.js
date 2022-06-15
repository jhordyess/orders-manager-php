// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
Chart.defaults.global.animation.duration = 2000;

$(document).ready(function () {
  var o = "0";
  var lincha;
  linea(o);
  $('#als').click(function () {
    if (o === "0") {
      lincha.destroy();
      o = "1";
      linea(o);
      $('#als').val("número de semana");
//      $('#va').text("número de semana");
    } else {
      lincha.destroy();
      o = "0";
      linea(o);
      $('#als').val("mes");
//       $('#va').text("mes");
    }
  });

  function rdco() {
    var r = Math.floor(Math.random() * 200);
    var g = Math.floor(Math.random() * 200);
    var b = Math.floor(Math.random() * 200);
    return 'rgb(' + r + ', ' + g + ', ' + b + ')';
  }
  function linea(ot) {
    $.ajax({
      url: "/Lisis/total.php",
      method: "GET",
      data: {
        "a": ot
      },
      success: function (data) {
        var xi = [];
        var fi = [];
        var sum = 0.00;
        if (ot === "1") {//mismo que php
          for (var i in data) {
            var t = parseInt(data[i].sem) + 1;
            xi.push("Sem " + t);
            fi.push(parseInt(data[i].tot));
            sum += parseInt(data[i].tot);
          }
        } else {
          var dias = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
          for (var i in data) {
            xi.push(dias[data[i].sem]);
            fi.push(parseInt(data[i].tot));
            sum += parseInt(data[i].tot);
          }
        }
        lincha = new Chart($("#me"), {
          type: 'line',
          data: {
            labels: xi, //_/
            datasets: [{
                label: "Ingreso", //_/
                lineTension: 0.3, //?
                backgroundColor: "rgba(2,117,216,0.2)", //?
                borderColor: "rgba(2,117,216,1)", //?
                pointRadius: 5, //?
                pointBackgroundColor: "rgba(2,117,216,1)", //?
                pointBorderColor: "rgba(255,255,255,0.8)", //?
                pointHoverRadius: 5, //?
                pointHoverBackgroundColor: "rgba(2,117,216,1)", //?
                pointHitRadius: 50, //?
                pointBorderWidth: 2, //?
                data: fi, //_/
              }]
          },
          options: {
            legend: {
              display: false, //_/
            },
            scales: {
              xAxes: [{
                  gridLines: {
                    display: false//_/
                  }
//          time: {
//            unit: 'date'
//          },  
//          ticks: {
//            maxTicksLimit: 7
//          }
                }],
              yAxes: [{
                  gridLines: {
                    color: "rgba(0, 0, 0, .125)"//_/
                  },
//                  ticks: {
//                    min: 0,
//                    max: 10000,
//                    maxTicksLimit: 5
//                  },
                }]
            }
          }
        });
      },
      error: function (data) {
        console.log(data);
      }
    });
  }
  $.ajax({
    url: "/Lisis/destinos.php",
    method: "GET",
    success: function (data) {
      var xi = [];
      var fi = [];
      var sum = 0.00;
      var cl = [];
      for (var i in data) {
        xi.push(data[i].nom);
        fi.push(parseInt(data[i].can));
        sum += parseInt(data[i].can);
        cl.push(rdco());
      }
      var vari = new Chart($("#destinos"), {
        responsive: true,
        maintainAspectRatio: false,
        type: 'pie',
        data: {
          labels: xi,
          datasets: [{
              data: fi,
              backgroundColor: cl
            }]
        },
        options: {
          tooltips: {
            enabled: true,
            mode: 'single',
            callbacks: {
              label: function (item) {
                var x = Math.round((parseFloat(fi[item.index] / sum) * 100) * 100) / 100;
                return xi[item.index] + ": " + x + '%';
              }
            }
          }
        }
      });
    },
    error: function (data) {
      console.log(data);
    }
  });
  $.ajax({
    url: "/Lisis/proce.php",
    method: "GET",
    success: function (data) {
      var xi = [];
      var fi = [];
      var sum = 0.00;
      //var cl = [];
      for (var i in data) {
        xi.push(data[i].nom);
        fi.push(parseInt(data[i].can));
        sum += parseInt(data[i].can);
        //cl.push(rdco());
      }
      var vari = new Chart($("#proce"), {
        responsive: true,
        maintainAspectRatio: false,
        type: 'pie',
        data: {
          labels: xi,
          datasets: [{
              data: fi,
              backgroundColor: ["#2ECC40", "#FF4136", "#0074D9"]
                      //backgroundColor: cl
            }]
        },
        options: {
          tooltips: {
            enabled: true,
            mode: 'single',
            callbacks: {
              label: function (item) {
                var x = Math.round((parseFloat(fi[item.index] / sum) * 100) * 100) / 100;
                return xi[item.index] + ": " + x + '%';
              }
            }
          }
        }
      });
    },
    error: function (data) {
      console.log(data);
    }
  });
});


