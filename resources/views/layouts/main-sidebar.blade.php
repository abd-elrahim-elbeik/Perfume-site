<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->


                    <!-- Dashboard-->
                    <li>
                        <a href="{{ route('dashboard') }}"><i class="ti-pie-chart"></i><span class="right-nav-text">Dashboard</span> </a>
                    </li>

                    <!-- Categories-->
                    <li>
                        <a href="{{ route('categories.index') }}"><i class="ti-menu-alt"></i><span class="right-nav-text">Categories</span> </a>
                    </li>

                    <!-- Product-->
                    <li>
                        <a href="{{ route('products.index') }}"><i class="ti-menu-alt"></i><span class="right-nav-text">Products</span> </a>
                    </li>



                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
