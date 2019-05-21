<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Select Date</h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="reservation" readonly>
          </div>
        </div>
        <div class="col-xs-12" style="padding-top:10px;
        ">
          <button type="button" class="btn btn-info" name="">Apply</button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>984,900</h3>
        <p>Amount Total</p>
      </div>
      <div class="icon">
        <i class="fa fa-handshake-o"></i>
      </div>
      <a href="<?=$LinkWeb;?>" class="small-box-footer">This Month <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>530,320</h3>
        <p>Actual amount paid</p>
      </div>
      <div class="icon">
        <i class="fa fa-thumbs-o-up"></i>
      </div>
      <a href="<?=$LinkWeb;?>" class="small-box-footer">This Month <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>454,580</h3>
        <p>Overdue</p>
      </div>
      <div class="icon">
        <i class="fa fa-exclamation-triangle"></i>
      </div>
      <a href="<?=$LinkWeb;?>" class="small-box-footer">This Month <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">Age Chart</h3>
        <div class="box-tools pull-right">
          <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
        </div>
      </div>
      <div class="box-body">
        <div id="donut-chart" style="height: 300px;"></div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">Order Chart</h3>
        <div class="box-tools pull-right">
          <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
        </div>
      </div>
      <div class="box-body">
        <div class="chart">
          <canvas id="barChart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>





<!-- CHART -->
<script src="<?=$LinkHostWeb;?>plugins/chart.js/Chart.js"></script>
<!-- FLOT CHARTS -->
<script src="<?=$LinkHostWeb;?>plugins/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?=$LinkHostWeb;?>plugins/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?=$LinkHostWeb;?>plugins/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?=$LinkHostWeb;?>plugins/Flot/jquery.flot.categories.js"></script>




<!-- date-range-picker -->
<script src="<?=$LinkHostWeb;?>plugins/moment/min/moment.min.js"></script>
<script src="<?=$LinkHostWeb;?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/bootstrap-daterangepicker/daterangepicker.css">
<!--- DATE -->
<script>
  $(function () {
    //Date range picker
    $('#reservation').daterangepicker()
  })
</script>

<!--- Order Chart -->
<script>
  $(function () {

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Online',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label               : 'Offline',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = true
    barChart.Bar(barChartData, barChartOptions)
  })
</script>

<!--- Age Chart -->
<script>
  $(function () {


    var donutData = [
      { label: 'Unknown', data:10, color: '#3c8dbc' },
      { label: 'Female', data: 70, color: '#0073b7' },
      { label: 'Male', data: 20, color: '#00c0ef' }
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */

  })

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
</script>
