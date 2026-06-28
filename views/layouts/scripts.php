<!-- Bootstrap -->

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<!-- Chart JS -->

<script
src="https://cdn.jsdelivr.net/npm/chart.js">
</script>

<!-- Custom JS -->

<script src="<?= base_url('assets/js/script.js'); ?>"> </script>
<script src="<?= base_url('assets/js/wilayah.js') ?>"></script>

<script>

document.addEventListener(
'DOMContentLoaded',
function(){

    // toggle sidebar
    const sidebar =
    document.getElementById(
    'sidebar'
    );

    const toggle =
    document.getElementById(
    'toggleSidebar'
    );

    if(toggle){

        toggle.addEventListener(
        'click',
        function(){

            sidebar.classList.toggle(
            'collapsed'
            );

        });

    }

});

</script>