    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        @if(Auth::user()->role_id==2)

          <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('warga')}}"><i class="fa fa-users text-white"></i> <span>Warga</span></a></li>
        @endif
        @if(Auth::user()->role_id==1)
          <li class="treeview @if(Request::is('barang/*')==1 || Request::is('barang')==1 || Request::is('konsumen')==1 || Request::is('sales')==1 || Request::is('employe')==1) menu-open @endif">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('warga/*')==1 || Request::is('warga')==1 || Request::is('rw')==1 || Request::is('rw/*')==1 || Request::is('rt')==1 || Request::is('rt/*')==1 ) block @endif">
              <li><a href="{{url('warga')}}">&nbsp;<i class="fa  fa-sort-down"></i> Warga</a></li>
              <li><a href="{{url('rw')}}">&nbsp;<i class="fa  fa-sort-down"></i> RW</a></li>
              <li><a href="{{url('rt')}}">&nbsp;<i class="fa  fa-sort-down"></i> RT</a></li>
            </ul>
          </li>
          <li class="treeview @if(Request::is('salesorder/*')==1 || Request::is('salesorder')==1 ) menu-open @endif">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Sales Order (SO)</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('salesorder/*')==1 || Request::is('salesorder')==1) block @endif">
              <li><a href="{{url('salesorder')}}">&nbsp;<i class="fa  fa-sort-down"></i> New Request</a></li>
              <li><a href="{{url('salesorder/approved')}}">&nbsp;<i class="fa  fa-sort-down"></i> Approved Request</a></li>
              <li><a href="{{url('customer')}}">&nbsp;<i class="fa  fa-sort-down"></i> Customer</a></li>
            </ul>
          </li>
          @endif
        <li><a href="#"><i class="fa fa-circle-o text-white"></i> <span>Information</span></a></li>
      </ul>