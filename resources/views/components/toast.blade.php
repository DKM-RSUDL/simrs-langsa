<script>
    function showToast(type, message) {
        iziToast[type]({
            title: type,
            message: message,
            position: 'topRight',
            timeout: 3000,
            progressBar: true,
            displayMode: 'once',
        });
    }
</script>
