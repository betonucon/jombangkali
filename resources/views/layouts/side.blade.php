    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        @if(Auth::user()->role_id==2)

          <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('warga')}}"><i class="fa fa-users text-white"></i> <span>Warga</span></a></li>
        @endif
        @if(Auth::user()->role_id==1)
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('warga')}}"><i class="fa fa-users text-white"></i> <span>Warga</span></a></li>
          @endif
        <li><a href="#"><i class="fa fa-circle-o text-white"></i> <span>Information</span></a></li>
      </ul>