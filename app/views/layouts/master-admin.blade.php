<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>@yield('title')Admin Panel</title>
        <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @if(Route::current()->getName() == 'admin-home-show')
        <script type="text/javascript"
              src="https://www.google.com/jsapi?autoload={
                'modules':[{
                  'name':'visualization',
                  'version':'1',
                  'packages':['corechart']
                }]
              }"></script>
        @endif
    </head>
    <body>
    <header class="header-not-reg">
        <div class="col-xs-3">
            <nav class="navbar navbar-fixed-top categories">
               <div class="navbar-header"> 
                <a class="navbar-brand before-brand" href="{{ URL::route('home') }}" >
                    <img alt="Brand" src="{{ URL::asset('img/logo.png') }}"/>
                    <small>teachbox</small>
                </a>
                </div>
            </nav>
        </div>
        <div class="col-xs-9">
            <ul class="nav nav-tabs navbar-before-registration pull-right">
                        <li><a href="{{ URL::action('AdminController@adminHome') }}" class="btn btn-info pull-left">Home</a></li>
                        <li><a href="{{ URL::action('AdminController@showUsers') }}" class="btn btn-info pull-left">Users</a></li>
                        <li><a href="{{ URL::action('AdminController@showCourses') }}" class="btn btn-info pull-left">Courses</a></li>
                        <li><a href="{{ URL::action('AdminController@coursesApprove') }}" class="btn btn-info pull-left">To approve</a></li>
            </ul>
        </div>
    </header>
    <div class="main">
        @yield('content')
    </div>
    @if(Route::current()->getName() == 'admin-home-show')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
         google.setOnLoadCallback(drawChart);
                var users_last_month = <?php echo json_encode($users_last_month);?>;
                var users_this_month = <?php echo json_encode($users_this_month); ?>;
                var courses_this_month = <?php echo json_encode($courses_this_month); ?>;
                var courses_last_month = <?php echo json_encode($courses_last_month); ?>;
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Year', 'Users', 'Courses'],
                  ['January',  users_last_month, courses_last_month],
                  ['February',  users_this_month, courses_this_month]
                ]);

                var options = {
                  title: 'Company Performance',
                  curveType: 'function',
                  legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
              }
        </script>
    @endif
    </body>
</html>