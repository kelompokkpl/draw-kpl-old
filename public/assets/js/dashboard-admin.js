// Build the chart
Highcharts.chart('container-pie', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  credits: {
        enabled: false
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b> <br>{point.y} events'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: false
      },
      showInLegend: true
    }
  },
  series: [{
    name: 'Total',
    colorByPoint: true,
    data: [{
      name: 'Paid',
      y: payment.paid,
      sliced: true,
      selected: true
    }, {
      name: 'Unpaid',
      y: payment.unpaid
    }]
  }]
});

// Create the chart

// Create the chart
Highcharts.chart('container', {
  chart: {
    type: 'line'
  },
  title: {
    text: 'Event Organizer Activities Per Event'
  },
  credits: {
        enabled: false
  },
  subtitle: {
    text: 'Click the columns to view details.'
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'

  },
  legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y}'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} activities</b><br/>'
  },

  series: series,
  drilldown: {
    series: drillDown
  },
  responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});


Highcharts.chart('sales', {
  chart: {
    type: 'line'
  },
  title: {
    text: 'Sales Per Month'
  },
  credits: {
        enabled: false
  },
  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>Rp{point.y}</b><br/>'
  },
  xAxis: {
    categories: month
  },
  yAxis: {
    title: {
      text: 'Income (Rp)'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: true
    }
  },
  series: [{
    name: 'Income',
    data: total
  }],
  responsive: {
        rules: [{
            condition: {
                maxWidth: 300
            },
        }]
    }
});