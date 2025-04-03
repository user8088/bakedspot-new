@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="row">
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>Total Orders</h6>
                    <h2>80</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" width="50" src="{{asset("icons/order-icon.png")}}" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>Sold Today</h6>
                    <h2>17</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" width="50" src="{{asset("icons/sold-icon.png")}}" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>User Count</h6>
                    <h2>8</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" width="50" src="{{asset("icons/user-icon.png")}}" />
                </div>
            </div>
        </div>
    </div>
    <!-- DASHBOARD STATS CARD END HERE -->

    <div class="container pt-5" >
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="shadow" id="table-1" style="border-radius: 20px;" ></div>
            </div>
            <div class="col-lg-6">
                <div class="shadow" id="table-2" style="border-radius: 20px;"></div>
            </div>
        </div>
    </div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    const data2024 = [
        ['January', 10],
        ['February', 15],
        ['March', 20],
        ['April', 25],
        ['May', 30],
        ['June', 35],
        ['July', 40],
        ['August', 45],
        ['September', 50],
        ['October', 55],
        ['November', 60],
        ['December', 65]
    ];

    Highcharts.chart('table-1', {
        chart: { type: 'column' },
        title: { text: 'Sales 2024', align: 'center' },
        xAxis: {
            type: 'category',
            title: { text: 'Month' },
            categories: data2024.map(point => point[0])
        },
        yAxis: { title: { text: 'Brownies Sold' } },
        tooltip: {
            headerFormat: '<span style="font-size: 15px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y} sold</b><br/>'
        },
        series: [
            {
                name: '2024',
                data: data2024.map(point => ({
                    name: point[0],
                    y: point[1],
                    color: '#F79EB7'
                })),
            }
        ]
    });
    Highcharts.chart('table-2', {
        chart: { type: 'column' },
        title: { text: 'Sales 2024', align: 'center' },
        xAxis: {
            type: 'category',
            title: { text: 'Month' },
            categories: data2024.map(point => point[0])
        },
        yAxis: { title: { text: 'Brownies Sold' } },
        tooltip: {
            headerFormat: '<span style="font-size: 15px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y} sold</b><br/>'
        },
        series: [
            {
                name: '2024',
                data: data2024.map(point => ({
                    name: point[0],
                    y: point[1],
                    color: '#F79EB7'
                })),
            }
        ]
    });
</script>
<script>
    const users2024 = [
        ['January', 120],
        ['February', 150],
        ['March', 180],
        ['April', 210],
        ['May', 250],
        ['June', 280],
        ['July', 310],
        ['August', 340],
        ['September', 370],
        ['October', 400],
        ['November', 430],
        ['December', 460]
    ];

    Highcharts.chart('table-2', {
        chart: { type: 'line' },
        title: { text: 'Users (2024)', align: 'center' },
        xAxis: {
            type: 'category',
            title: { text: 'Month' },
            categories: users2024.map(point => point[0])
        },
        yAxis: { title: { text: 'Number of Users' } },
        tooltip: {
            headerFormat: '<span style="font-size: 15px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y} users</b><br/>'
        },
        series: [
            {
                name: 'Users 2024',
                data: users2024.map(point => ({
                    name: point[0],
                    y: point[1]
                })),
                color: '#F79EB7',
                dataLabels: [{ enabled: true, style: { fontSize: '12px' } }]
            }
        ]
    });
</script>




@endsection
