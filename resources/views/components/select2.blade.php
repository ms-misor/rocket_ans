<select {{ $attributes->merge(['class'=>'form-control select2']) }}>
    {{ $slot }}</select>

@push('lib-styles')
<!-- Select 2 -->
<link href="{{ admin_asset('vendors/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('lib-scripts')
<!-- Select 2-->
<script src="{{ admin_asset('vendors/select2/select2.min.js') }}"></script>

@endpush
@push('extra-scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            {{ $config??'' }}
        });
    });
</script>
@endpush