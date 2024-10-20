<div class="card shadow-sm">
    <!-- Card Header -->
    <div class="card-header bg-primary text-white">
        {{ $title }}
    </div>

    <!-- Card Body -->
    <div class="card-body">
        {{ $slot }}
    </div>

    <!-- Card Footer (Optional) -->
    @if($footer)
    <div class="card-footer">
        {{ $footer }}
    </div>
    @endif
</div>