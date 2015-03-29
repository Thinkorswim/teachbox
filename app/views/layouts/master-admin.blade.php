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
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stylesv1.css') }}" />
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
                var count_users = <?php echo json_encode($count_users);?>;
                var count_courses = <?php echo json_encode($count_courses); ?>;
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Month', 'Users', 'Courses'],
                  ['January',  count_users[1], count_courses[1]],
                  ['February',  count_users[2], count_courses[2]],
                  ['March',  count_users[3], count_courses[3]],
                  ['April',  count_users[4], count_courses[4]],
                  ['May',  count_users[5], count_courses[5]],
                  ['June',  count_users[6], count_courses[6]],
                  ['July',  count_users[7], count_courses[7]],
                  ['August',  count_users[8], count_courses[8]],
                  ['September',  count_users[9], count_courses[9]],
                  ['October',  count_users[10], count_courses[10]],
                  ['November',  count_users[11], count_courses[11]],
                  ['December',  count_users[12], count_courses[12]],
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