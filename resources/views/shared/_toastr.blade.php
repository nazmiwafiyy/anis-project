@if(Session::has('message'))
{!!'<script>'!!}
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true,
    "positionClass": "toast-bottom-right",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
    toastr.success("{{ session('message') }}");
{!!'</script>'!!}
@endif

@if(Session::has('success'))
{!!'<script>'!!}
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true,
    "positionClass": "toast-bottom-right",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
    toastr.success("{{ session('success') }}");
{!!'</script>'!!}
@endif

@if(Session::has('error'))
{!!'<script>'!!}
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true,
    "positionClass": "toast-bottom-right",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
    toastr.error("{{ session('error') }}");
{!!'</script>'!!}
@endif

@if(Session::has('info'))
{!!'<script>'!!}
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true,
    "positionClass": "toast-bottom-right",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
    toastr.info("{{ session('info') }}");
{!!'</script>'!!}
@endif

@if(Session::has('warning'))
{!!'<script>'!!}
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true,
    "positionClass": "toast-bottom-right",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
    toastr.warning("{{ session('warning') }}");
{!!'</script>'!!}
@endif
