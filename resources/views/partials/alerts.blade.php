@if (session('success'))
    <div class="content pb-0 flex-grow-0">
        <div class="alert alert-success alert-dismissible fade show mb-0">
            <i class="ph-check-circle me-2"></i>
            <span class="fw-semibold">{{ session('success') }}</span>
        </div>
    </div>
@endif
@if (session('warning'))
    <div class="content pb-0 flex-grow-0">
        <div class="alert alert-warning alert-dismissible fade show  mb-0">
            <i class="ph-warning-circle me-2"></i>
            <span class="fw-semibold">{{ session('warning') }}</span>
        </div>
    </div>
@endif
@if (session('error'))
    <div class="content pb-0 flex-grow-0">
        <div class="alert alert-danger alert-dismissible fade show  mb-0">
            <i class="ph-x-circle me-2"></i>
            <span class="fw-semibold">{{ session('error') }}</span>
        </div>
    </div>
@elseif (Session::has('error'))
    <div class="content pb-0 flex-grow-0">
        <div class="alert alert-danger alert-dismissible fade show  mb-0">
            <i class="ph-x-circle me-2"></i>
            <span class="fw-semibold">{{ Session::get('error') }}</span>
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="content pb-0 flex-grow-0">
        <div class="alert alert-danger alert-dismissible fade show  mb-0">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

