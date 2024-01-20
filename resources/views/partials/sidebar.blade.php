<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <div class="sidebar-content">
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                @canany(['feedback-list', 'feedback-create'])
                    <li class="nav-item nav-item-submenu {{ Request::url() ==  route('feedback.index') ? 'nav-item-expanded nav-item-open' : '' }} {{ Request::url() ==  route('feedback.create') ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="ph-bounding-box"></i>
                            <span>feedbacks</span>
                        </a>
                        <ul class="nav-group-sub {{ !(\Request::is('feedback*')) ? 'collapse' : ''}} {{ Request::url() ==  route('feedback.index') ? 'show' : '' }} {{ Request::url() ==  route('feedback.create') ? 'show' : '' }}">
                            @can('feedback-list')
                                <li class="nav-item">
                                    <a href="{{route('feedback.index')}}" class="nav-link {{ Request::url() == route('feedback.index') ? 'active' : '' }}">
                                        <span>List</span>
                                    </a>
                                </li>
                            @endcan
                            @can('feedback-create')
                                <li class="nav-item">
                                    <a href="{{route('feedback.create')}}" class="nav-link {{ Request::url() == route('feedback.create') ? 'active' : '' }}">
                                        <span>Create</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
