<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/fav-icon.png') }}" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

{{-- fa icons  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/input_file.css') }}">

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

<style>
    #loader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    :root {
        --loading-spinner-background: rgba(200, 200, 200, 0.20);
        --loading-spinner-body: blue;
    }

    html {
        background: #101013;
    }

    .wrapper {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loading-spinner,
    .loading-spinner::after {
        width: 70px;
        height: 70px;
        border-radius: 50%;
    }

    .loading-spinner {
        border-top: 3px solid var(--loading-spinner-background);
        border-right: 3px solid var(--loading-spinner-background);
        border-bottom: 3px solid var(--loading-spinner-background);
        border-left: 3px solid var(--loading-spinner-body);
        position: relative;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-name: loading-spinner-animation;
        animation-name: loading-spinner-animation;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        -webkit-animation-duration: 0.8s;
        animation-duration: 0.8s;
        -webkit-animation-timing-function: linear;
        animation-timing-function: linear;
    }

    @-webkit-keyframes loading-spinner-animation {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes tw-loading-spinner-animation {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }



    .pagination {
        justify-content: center;
    }

    .page-link:first-child {
        padding: 10px;
        font-size: 15px;
        font-weight: bolder;
        border-radius: 50px;
    }

    .error-message {
        text-transform: capitalize;
    }

    .prev-links {
        display: flex;
    }

    .bottom {
        align-self: flex-end;
        width: 100px;
        height: 50px;
    }

    .ck-editor__editable {
        min-height: 250px;
    }
</style>
