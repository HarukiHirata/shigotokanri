@if ($toastr = session('toastr'))
<script>
    document.querySelector('script[src="{{ asset("js/app.js") }}"]').onload = function() {
        toastr.{{ $toastr['type'] }}('{{ $toastr["text"] }}');
    }
</script>
@endif