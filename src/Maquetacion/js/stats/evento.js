// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
Chart.defaults.global.animation.duration = 2000;

$(document).ready(function () {
  function rdco() {
    var r = Math.floor(Math.random() * 200);
    var g = Math.floor(Math.random() * 200);
    var b = Math.floor(Math.random() * 200);
    return 'rgb(' + r + ', ' + g + ', ' + b + ')';
  }
  $.ajax({
    url: "/Lisis/evento.php",
    method: "GET",
    data: {
        "x": "1"
    },
    success: function (data) {
      var xi = [];
      var fi = [];
      var cl = [];
      for (var i in data) {
        xi.push(data[i].eve);
        fi.push(parseInt(data[i].num));
        cl.push(rdco());
      }
      var vari = new Chart($("#total"), {
        responsive: true,
        maintainAspectRatio: false,
        type: 'bar',
        data: {
          labels: xi,
          datasets: [{
              data: fi,
              backgroundColor: cl,
              label:"Productos",
            }]
        },
        options: {
          legend: {
            display: false
          },
//          tooltips: {
//            enabled: true,
//            mode: 'single',
//            callbacks: {
//              label: function (item) {
//                var x = Math.round((parseFloat(fi[item.index] / sum) * 100) * 100) / 100;
//                return xi[item.index] + ": " + x + '%';
//              }
//            }
//          }
        }
      });
    },
    error: function (data) {
      console.log(data);
    }
  });
  $.ajax({
    url: "/Lisis/evento.php",
    method: "GET",
    data: {
        "x": "2"
    },
    success: function (data) {
      var xi = [];
      var fi = [];
      var cl = [];
      for (var i in data) {
        xi.push(data[i].eve);
        fi.push(parseInt(data[i].bs));
        cl.push(rdco());
      }
      var vari = new Chart($("#sus"), {
        responsive: true,
        maintainAspectRatio: false,
        type: 'bar',
        data: {
          labels: xi,
          datasets: [{
              data: fi,
              backgroundColor: cl,
              label:"Ingreso Bs",
            }]
        },
        options: {
          legend: {
            display: false
          },
//          tooltips: {
//            enabled: true,
//            mode: 'single',
//            callbacks: {
//              label: function (item) {
//                var x = Math.round((parseFloat(fi[item.index] / sum) * 100) * 100) / 100;
//                return xi[item.index] + ": " + x + '%';
//              }
//            }
//          }
        }
      });
    },
    error: function (data) {
      console.log(data);
    }
  });
});



