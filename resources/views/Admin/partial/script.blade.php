<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/sweet_alert/sweetalert2.all.min.js') }}" ></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script>
document.getElementById('mobileSidebarToggle')
.addEventListener('click',function(){

    document.getElementById('sidebar')
    .classList.toggle('active');

    document.getElementById('sidebarOverlay')
    .classList.toggle('active');
});

document.getElementById('sidebarOverlay')
.addEventListener('click',function(){

    document.getElementById('sidebar')
    .classList.remove('active');

    this.classList.remove('active');
});
</script>
