@php
    $url = $_SERVER['REQUEST_URI'];
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $url = strtok($url, '?');

    $pathSegments = explode('/', trim($url, '/'));

    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb custom-breadcrumb">'; // Adding custom class for styling

    $currentSegment = '';
    $currentPath = '';

    if ($pathSegments[0] != '') {
        echo '<li class="breadcrumb-item"><a href="' . url('/') . '">Home</a></li>';
    }

    foreach ($pathSegments as $key => $segment) {
        if ($segment == 'home' || $segment == 'dashboard') {
            continue;
        }

        if (!is_numeric($segment)) {
            $currentPath .= '/' . $segment;

            if ($currentSegment == $segment) {
                continue;
            }

            if ($key == count($pathSegments) - 1) {
                // Last segment (active)
                echo '<li class="breadcrumb-item active" aria-current="page">' . ucfirst($segment) . '</li>';
            } else {
                // Intermediate segments
                echo '<li class="breadcrumb-item"><a href="' . url($currentPath) . '">' . ucfirst($segment) . '</a></li>';
            }

            $currentSegment = $segment;
        }
    }

    echo '</ol>';
    echo '</nav>';
@endphp
