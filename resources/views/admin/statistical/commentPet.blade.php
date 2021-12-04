@section('title', 'Thông kê comment')
@extends('layouts.admin.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Thông kê comment</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="month" id="time" class="form-control">
                            <div id="data" data-pro="1" data-count=""></div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered data-table" style="width:100%">
                    <thead>
                        <th>Sản phẩm</th>
                        <th>Bình luận</th>
                        <th>Tác vụ</th>
                    </thead>
                    <tbody>
                        @foreach($product as $pro)
                        <tr>
                            <td>{{$pro->name}}</td>
                            <td>{{$pro->reviews()->where('product_type', 1)->count()}}</td>
                            <td>
                                <a href="{{route('statistical.detail',['id'=>$pro->id])}}">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="warpper">
                    <canvas id="myChart" style="height: 300px; display: block; box-sizing: border-box;"></canvas>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<style>
.warpper {
    height: 700px;
}
</style>
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css')}}">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>.
<script>
$(document).ready(function() {
    var product = <?= json_encode($product) ?>;
    var count = <?= json_encode($count) ?>;

    label = ''
    $.each(product, function(key, value) {
        label += value['name'] + ',';
    });
    var labels = label.slice(0, -1)
    var counts = count.slice(0, -1)

    const data = {
        labels: labels.split(','),
        datasets: [{
            label: 'My First Dataset',
            data: counts.split(','),
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 234)',
                'rgb(255, 205, 83)',
                'rgb(192,192,192)',
                'rgb(255,0,255)',
                'rgb(0,0,255)',
                'rgb(128,128,0)',
                'rgb(128,0,128)',
                'rgb(0,128,128)',
                'rgb(0,0,128)',
                'rgb(0,128,128)',
                'rgb(0,0,0)',
                'rgb(0,255,0)',
                'rgb(255,0,0)',
                'rgb(128,0,0)',
                'rgb(0,255,255)'
            ],
            hoverOffset: 4
        }]
    };
    const config = {
        type: 'doughnut',
        data: data,
        options: {
            plugins: {
                legend: {
                    labels: {
                        margin: 40
                    }
                },
                title: {
                    display: true,
                    text: 'Biểu đồ thống kê bình luận sản phẩm thú cưng',
                    font: {
                        size: 14
                    }
                }
            },
            radius: '70%',
            responsive: true,
            maintainAspectRatio: false,

        },
        plugins: [{
            beforeInit: function(chart, legend, options) {
                const fitValue = chart.legend.fit;
                chart.legend.fit = function fit() {
                    fitValue.bind(chart.legend)();
                    return this.height -= 10;
                }
            }
        }]
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );


    $('#time').change(function(e) {
        $.ajax({
            url: "{{ route('statistical.cmtAccess') }}",
            type: 'GET',
            data: {
                time: $('#time').val()
            },
            success: function(data) {
                label = ''
                $.each(data.product, function(key, value) {
                    label += value['name'] + ',';
                });
                var labels = label.slice(0, -1);
                var counts = data.review.slice(0, -1);

                myChart.data.labels = labels.split(',')
                myChart.data.datasets[0].data = counts.split(',')
                myChart.update();
            },
        });
    })
});
</script>
@endsection