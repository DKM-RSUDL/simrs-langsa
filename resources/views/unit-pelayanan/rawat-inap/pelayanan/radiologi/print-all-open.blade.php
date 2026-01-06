<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Opening Radiology Files...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <div class="alert alert-info">Membuka <strong>{{ $count }}</strong> hasil radiologi. Jika tab tidak
            muncul, periksa popup blocker.</div>
        <ul class="list-group mb-3">
            @foreach ($files as $f)
                <li class="list-group-item">{{ $f['file_name'] }} &mdash; <a href="{{ $f['file_url'] }}"
                        target="_blank">Buka</a></li>
            @endforeach
        </ul>
        <a href="javascript:window.close();" class="btn btn-secondary">Tutup</a>
    </div>

    <script>
        (function() {
            var files = {!! json_encode($files) !!};
            // open with small delay to reduce popup blocking
            files.forEach(function(f, idx) {
                setTimeout(function() {
                    window.open(f.file_url, '_blank');
                }, idx * 350);
            });
        })();
    </script>
</body>

</html>
