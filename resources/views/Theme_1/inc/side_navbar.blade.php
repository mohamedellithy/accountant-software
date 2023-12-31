  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon rotate-n-15">
              <i class="fas fa-laugh-wink"></i>
          </div>
          <div class="sidebar-brand-text mx-3">
              SB Admin <sup>2</sup>
          </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" />

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ IsActiveOnlyIf(['dashboard']) }}">
          <a class="nav-link" href="{{ route('dashboard') }}">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>لوحة التحكم</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider" />

      {{-- <!-- Heading -->
            <div class="sidebar-heading">Interface</div> --}}

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ IsActiveOnlyIf(['suppliers.create', 'suppliers.edit', 'suppliers.index']) }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
              aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-user-friends"></i>
              <span>الموردين</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">

                  <a class="collapse-item {{ IsActiveOnlyIf(['suppliers.create']) }}"
                      href="{{ route('suppliers.create') }}">اضافة</a>
                  <a class="collapse-item {{ IsActiveOnlyIf(['suppliers.index']) }}"
                      href="{{ route('suppliers.index') }}" href="cards.html">عرض</a>
              </div>
          </div>
      </li>
      <li class="nav-item {{ IsActiveOnlyIf(['customers.create', 'customers.edit', 'customers.index']) }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
              aria-expanded="true" aria-controls="collapseThree">
              <i class="fas fa-users"></i>
              <span>العملاء</span>
          </a>
          <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">

                  <a class="collapse-item {{ IsActiveOnlyIf(['customers.create']) }}"
                      href="{{ route('customers.create') }}">اضافة</a>
                  <a class="collapse-item {{ IsActiveOnlyIf(['customers.index']) }}"
                      href="{{ route('customers.index') }}" href="cards.html">عرض</a>
              </div>
          </div>
      </li>
      <li class="nav-item {{ IsActiveOnlyIf(['products.create', 'products.edit', 'products.index']) }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
              aria-expanded="true" aria-controls="collapseFour">
             <i class="far fa-clone"></i>
              <span>الاصناف</span>
          </a>
          <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">

                  <a class="collapse-item {{ IsActiveOnlyIf(['products.create']) }}"
                      href="{{ route('products.create') }}">اضافة</a>
                  <a class="collapse-item {{ IsActiveOnlyIf(['products.index']) }}"
                      href="{{ route('products.index') }}" href="cards.html">عرض</a>
              </div>
          </div>
      </li>
 <li class="nav-item {{ IsActiveOnlyIf(['orders.create', 'orders.edit', 'orders.index']) }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
              aria-expanded="true" aria-controls="collapseFive">
             <i class="far fa-clone"></i>
              <span>الطلبات</span>
          </a>
          <div id="collapseFive" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">

                  <a class="collapse-item {{ IsActiveOnlyIf(['orders.create']) }}"
                      href="{{ route('orders.create') }}">اضافة</a>
                  <a class="collapse-item {{ IsActiveOnlyIf(['orders.index']) }}"
                      href="{{ route('orders.index') }}" href="cards.html">عرض</a>
              </div>
          </div>
      </li>
      <!-- Nav Item - Utilities Collapse Menu -->


      <!-- Divider -->
      <hr class="sidebar-divider" />

      {{-- <!-- Heading -->
            <div class="sidebar-heading">Addons</div> --}}

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
              aria-expanded="true" aria-controls="collapsePages">
              <i class="fas fa-fw fa-folder"></i>
              <span>Pages</span>
          </a>
          <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Login Screens:</h6>
                  <a class="collapse-item" href="login.html">Login</a>
                  <a class="collapse-item" href="register.html">Register</a>
                  <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                  <div class="collapse-divider"></div>
                  <h6 class="collapse-header">Other Pages:</h6>
                  <a class="collapse-item" href="404.html">404 Page</a>
                  <a class="collapse-item" href="blank.html">Blank Page</a>
              </div>
          </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
          <a class="nav-link" href="charts.html">
              <i class="fas fa-fw fa-chart-area"></i>
              <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
          <a class="nav-link" href="tables.html">
              <i class="fas fa-fw fa-table"></i>
              <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

      <!-- Sidebar Message -->

  </ul>
  <!-- End of Sidebar -->
