<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GoTap') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />


    <meta name="description" content="" />

    @include('partials.css')

    <!-- Page CSS -->

    @yield('style')

    @livewireStyles

  </head>

  <body>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('partials.sidebar')

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          @include('partials.nav')
          <!-- / Navbar -->

          <div id="loader">
            <div class="wrapper">
                <div class="loading-spinner"></div>
            </div>
        </div>
          <!-- Content wrapper -->
          <div class="content-wrapper" id="main-content" style="visibility: hidden;">
            <!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y" >
                {{ $slot }}
            </div>


            <!-- / Content -->

            <!-- Footer -->

            @include('partials.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

  <!-- Modal -->

    @include('partials.js')


    @yield('script')

    <script>
        $(document).ready(function() {
            $("#loader").hide();
            $('#main-content').css('visibility', 'visible');
        })
        $('#footer-date').text(new Date().getFullYear())
    </script>
    @livewireScripts
  </body>
</html>
