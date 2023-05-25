    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        @if(Auth::user()->role_id==2)

          <li class="@if(Request::is('warga')==1 || Request::is('warga/*')==1) active @endif"><a href="{{url('warga')}}"><i class="fa fa-users text-white"></i> <span>Warga</span></a></li>
          <li class="@if(Request::is('kk')==1 || Request::is('kk/*')==1) active @endif"><a href="{{url('kk')}}"><i class="fa fa-users text-white"></i> <span>Kepala Keluarga</span></a></li>
          <li class="@if(Request::is('keuangan')==1 || Request::is('keuangan/*')==1) active @endif"><a href="{{url('keuangan')}}"><i class="fa fa-money text-white"></i> <span>Keuangan</span></a></li>
        @endif
        @if(Auth::user()->role_id==1)
          <li class="@if(Request::is('warga')==1 || Request::is('warga/*')==1) active @endif"><a href="{{url('warga')}}"><i class="fa fa-users text-white"></i> <span>Warga</span></a></li>
          <li class="@if(Request::is('keuangan')==1 || Request::is('keuangan/*')==1) active @endif"><a href="{{url('keuangan')}}"><i class="fa fa-money text-white"></i> <span>Keuangan</span></a></li>
        @endif
        @if(Auth::user()->role_id==3 || Auth::user()->role_id==4)
        <li class="@if(Request::is('keuangan')==1 || Request::is('keuangan/*')==1) active @endif"><a href="{{url('keuangan')}}"><i class="fa fa-money text-white"></i> <span>Keuangan</span></a></li>
        @endif
      </ul>