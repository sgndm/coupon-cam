@extends('layouts.user')
@section('upper_content')
@endsection
@section('content')

<div class="col-md-12">
    <div class="sub-menu-container">
        <div class="sub-menu-header">
            <div class="col-md-1" style="width: 80px;"></div>
            <div class="col-md-1 sub-menu-btn sub-menu-active" id="link_btn_1" onclick="display_form();" >STATS BY STORE</div>
            <div class="col-md-1" style="width: 45px;"></div>
            <div class="col-md-1 sub-menu-btn " id="link_btn_2" onclick="display_active();" >STATS BY PROMO</div>
            <div class="col-md-1" style="width: 40px;"></div>
            <div class="col-md-1 sub-menu-btn " id="link_btn_3" onclick="display_puase();" >TOTAL STATS</div>
            <div class="col-md-1" style="width: 50px;"></div>
            <div class="col-md-1 sub-menu-btn " style="width: 15%;" id="link_btn_4" onclick="display_finished();" >RETARGETED CUSTOMERS</div>
            <div class="col-md-1" style="width: 75px;"></div>
            <div class="col-md-1 sub-menu-btn search-menu-btn" id="link_btn_5" onclick="display_search();" >
                <table style="border:0;">
                    <tr>
                        <td >SEARCH</td>
                        <td><input type="text" class="search-input"> </td>
                        <td ><img src="{{url('resources/assets/CCUI/search.png')}}" style="width: 25px;" ></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="sub-menu-content">
            <div id="form_container">
            
                
                <div class="custom-slider">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        
                        <div class="carousel-inner">

<!--                            @foreach($stores as $store)-->
                            <div class="item active">
<!--                                <h3> {{ $store['store_name'] }} </h3>-->
                            
                            </div>
                            
<!--                            @endforeach-->
                        </div>                            
                                

                        <!-- Left and right controls -->
                        <a class="left carousel-control custom-slide-controller" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control custom-slide-controller" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                
                
                
                
            </div>
            <div id="active_container"></div>
            <div id="puased_container"></div>
            <div id="finished_container"></div>
            <div id="search_container"></div>
        </div>
    </div>
</div>
@endsection
@section('custom_css')
@endsection

@section('custom_js')
    <!-- | Add custom js that related to this page here | -->

    <script>
        function display_form(){
            $('#link_btn_1').addClass('sub-menu-active');
            $('#link_btn_2').removeClass('sub-menu-active');
            $('#link_btn_3').removeClass('sub-menu-active');
            $('#link_btn_4').removeClass('sub-menu-active');
            
            $('#form_container').show('slide', 200);
            $('#active_container').hide();
            $('#puased_container').hide();
            $('#finished_container').hide();
            $('#search_container').hide();
            
        }
        function display_active(){
            $('#link_btn_2').addClass('sub-menu-active');
            $('#link_btn_1').removeClass('sub-menu-active');
            $('#link_btn_3').removeClass('sub-menu-active');
            $('#link_btn_4').removeClass('sub-menu-active');
            
            $('#active_container').show('slide', 200);
            $('#form_container').hide();
            $('#puased_container').hide();
            $('#finished_container').hide();
            $('#search_container').hide();
        }
        function display_puase(){
            $('#link_btn_3').addClass('sub-menu-active');
            $('#link_btn_1').removeClass('sub-menu-active');
            $('#link_btn_2').removeClass('sub-menu-active');
            $('#link_btn_4').removeClass('sub-menu-active');
            
            $('#puased_container').show('slide', 200);
            $('#form_container').hide();
            $('#active_container').hide();
            $('#puased_container').hide();
            $('#search_container').hide();
        }
        function display_finished(){
            $('#link_btn_4').addClass('sub-menu-active');
            $('#link_btn_1').removeClass('sub-menu-active');
            $('#link_btn_2').removeClass('sub-menu-active');
            $('#link_btn_3').removeClass('sub-menu-active');
            
            $('#finished_container').show('slide', 200);
            $('#form_container').hide();
            $('#active_container').hide();
            $('#puased_container').hide();
            $('#search_container').hide();
        }
        function display_search(){
            $('#link_btn_1').removeClass('sub-menu-active');
            $('#link_btn_2').removeClass('sub-menu-active');
            $('#link_btn_3').removeClass('sub-menu-active');
            $('#link_btn_4').removeClass('sub-menu-active');
            
            $('#search_container').show('slide', 200);
            $('#form_container').hide();
            $('#active_container').hide();
            $('#puased_container').hide();
            $('#finished_container').hide();
        }
        
        
    </script>
    <script>
        $('.carousel').carousel({
            interval: false
        });
    </script>
@endsection