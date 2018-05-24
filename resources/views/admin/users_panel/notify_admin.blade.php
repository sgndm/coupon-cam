@extends('layouts.admin')

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
        @foreach($notifications as $key => $notification)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>
                <strong>{{ \App\User::find($notification->user_id)->name }}</strong> has {{ $notification->msg }}
                @if($notification->msgfrom == 'shop')
                    @if(\App\Store::where("place_id",$notification->recordid)->first())
                - <strong>{{ \App\Store::where("promo_id",$notification->recordid)->first()->name }}</strong>
                    @endif
                @elseif($notification->msgfrom == 'promo')
                    @if(\App\Promo::where("promo_id",$notification->recordid)->first())
                - <strong>{{ \App\Promo::where("promo_id",$notification->recordid)->first()->name }}</strong>
                    @endif
                @elseif($notification->msgfrom == 'coupon')
                    @if(\App\Coupon::where("promo_id",$notification->recordid)->first())
                - <strong>{{ \App\Coupon::where("promo_id",$notification->recordid)->first()->name }}</strong>
                    @endif
                @endif .
            </td>
            <td>
            @if($notification->msgfrom == 'shop')
            <a href="{{ url('admin/stores/edit') }}/{{ $notification->recordid }}" class="btn btn-xs btn-primary">view</a>
            @elseif($notification->msgfrom == 'promo')
            <a href="{{ url('admin/promos/edit') }}/{{ $notification->recordid }}" class="btn btn-xs btn-primary">view</a>
            @elseif($notification->msgfrom == 'coupon')
            <a href="{{ url('admin/coupons/edit') }}/{{ $notification->recordid }}" class="btn btn-xs btn-primary">view</a>
            @endif
            </td>
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