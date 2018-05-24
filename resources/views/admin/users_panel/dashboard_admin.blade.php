@extends('layouts.admin')
@section('upper_content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter">{{ $users }}</p>
                    <span class="info-box-title">Total Active Users</span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-users"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter">{{ $stores }}</p>
                    <span class="info-box-title">Total Active Stores</span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-home"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter">{{ $promos }}</p>
                    <span class="info-box-title">Active Promos</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><span class="counter">{{ $coupons }}</span></p>
                    <span class="info-box-title">Active Coupons</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- Row -->
@endsection
@section('content')

        <h2>Notifications</h2>

    <div class="clearfix"></div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td style="width:20px;">#</td>
            <td>Message</td>
            <td style="width:50px;">View</td>
        </tr>
    <tbody>
        <?php $count = 0; ?>
        @foreach($notifications as $key => $notification)
        <?php $count += 1 ?>
        <tr>
            <td>{{ $key+1 }}</td>
            <td>You have {{ \App\Common::GetTotalNotify($notification->user_id) }} notifications from {{ \App\Common::UserInfo($notification->user_id)->name }}.</td>
            <td><a href="{{ url('admin/notify') }}/{{ $notification->user_id }}" class="btn btn-xs btn-primary">view</a></td>
        </tr>
        @endforeach
    </tbody>
    </thead>
</table>
<div class="clearfix"></div>
<div class="pagination">
   {{ $notifications->links() }}
</div>

@endsection

@section('custom_css')
<link href="{{ asset('resources/assets/user/plugins/metrojs/MetroJs.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('resources/assets/user/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('custom_js')
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/metrojs/MetroJs.min.js') }}"></script>

@endsection
