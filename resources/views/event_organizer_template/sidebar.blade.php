<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-{{ cbLang('left') }} image">
                <img src="{{ CRUDBooster::myPhoto() }}" class="img-circle" alt="{{ cbLang('user_image') }}"/>
            </div>
            <div class="pull-{{ cbLang('left') }} info">
                <p>{{ CRUDBooster::myName() }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ cbLang('online') }}</a>
            </div>
        </div>


        <div class='main-menu'>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{cbLang("menu_navigation")}}</li>
                <!-- Optionally, you can add icons to the links -->
                
                @if(Str::contains(URL::current(), 'dashboard_event'))
                    <li data-id='{{$dashboard->id}}' class="{{ (!Str::contains(URL::current(), 'category') && !Str::contains(URL::current(), 'participant') && !Str::contains(URL::current(), 'mail') && !Str::contains(URL::current(), 'preferences')) ? 'active' : '' }}"><a href='{{URL::to('eo/dashboard_event/'.Session::get('event_id'))}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-dashboard'></i>
                        <span>{{cbLang("text_dashboard")}}</span> </a>
                    </li>
                @else
                    <li data-id='{{$dashboard->id}}' class="{{ (!Str::contains(URL::current(), '/event') && !Str::contains(URL::current(), 'payment') && !Str::contains(URL::current(), 'report')) ? 'active' : '' }}"><a href='{{URL::to('eo')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-dashboard'></i>
                        <span>{{cbLang("text_dashboard")}}</span> </a>
                    </li>
                @endif

                @if(!Str::contains(URL::current(), 'dashboard_event'))
                    <li data-id='{{$dashboard->id}}' class="{{ (Str::contains(URL::current(), '/event')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/event')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'>
                            <i class='fa fa-bars'></i>
                            <span>Event</span> 
                        </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'payment')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/payment')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'>
                            <i class='fa fa-money'></i>
                            <span>Payment</span> 
                        </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'report')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/report')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'>
                            <i class='fa fa-file-pdf-o'></i>
                            <span>Event Report</span> 
                        </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'demo')) ? 'active' : '' }}">
                        <a href='{{URL::to('demo')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><button class="btn btn-success" style="width: 90%"><i class='fa fa-laptop'></i>
                        <span>Draw Demo</span></button> </a>
                    </li>
                @else
                    <li class="{{ (Str::contains(URL::current(), 'dashboard_event/draw')) ? 'active' : '' }}">
                        <a class='{{($dashboard->color)?"text-".$dashboard->color:""}}' target="{{(Session::get('event_active')=='Active' && Session::get('can_draw') > 0 && Session::get('can_part') > 0)?'_blank':''}}" href="{{(Session::get('event_active')=='Active' && Session::get('can_draw') > 0 && Session::get('can_part') > 0)?URL::to('eo/dashboard_event/draw'):'javascript:;'}}"
                        @if(Session::get('event_active')!='Active')
                            onclick="swal({   
                                title: 'Warning',   
                                text: 'Your event status is Not Active, so you can not to draw!',   
                                type: 'warning',   
                                showCancelButton: false,   
                                confirmButtonColor: '#ff0000',   
                                confirmButtonText: 'OK',  
                                closeOnConfirm: false 
                            });"
                        @else
                            @if(Session::get('can_draw')==0 || Session::get('can_part')==0)
                            onclick="swal({   
                                title: 'Warning',   
                                text: 'You do not have categories or participant for drawing yet',   
                                type: 'warning',   
                                showCancelButton: false,   
                                confirmButtonColor: '#ff0000',   
                                confirmButtonText: 'OK',  
                                closeOnConfirm: false 
                            });"
                            @endif
                        @endif
                        >
                            <i class='fa fa-magic'></i>
                            <span>Let's Draw!</span> 
                        </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'category') && !(Str::contains(URL::current(), '_disabled'))) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/dashboard_event/category')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-bars'></i>
                        <span>Category</span> </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), '/participant')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/dashboard_event/participant')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-users'></i>
                        <span>Participant</span> </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'category_disabled') || Str::contains(URL::current(), 'selected_participant')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/dashboard_event/category_disabled')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-ban'></i>
                        <span>Category Disabled</span> </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'mails')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/dashboard_event/mails')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-envelope'></i>
                        <span>Mail to Winners</span> </a>
                    </li>
                    <li class="{{ (Str::contains(URL::current(), 'preferences')) ? 'active' : '' }}">
                        <a href='{{URL::to('eo/dashboard_event/preferences')}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'><i class='fa fa-gear'></i>
                        <span>Preferences</span> </a>
                    </li>
                @endif
            </ul><!-- /.sidebar-menu -->

        </div>

    </section>
    <!-- /.sidebar -->
</aside>
