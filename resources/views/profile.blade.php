<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />

    <title>{{ config('app.name', 'GoTap') }}</title>

    <meta name="description" content="" />

    <!-- Link Stylesheet -->
    {{-- <link rel="stylesheet" href="{{ asset('profile/style.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('profile/newstyle.css') }}" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <!------------------------------------------------ Boxicon CDN ------------------------------------------->

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        .profile_img {
            display: flex;
            justify-content: center;
            border-radius: 50%;
            margin-top: -10%;

        }

        .profile_img img {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            border: 7px solid #fff;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->

    <section>

        <input type="hidden" id="direct_url" value="{{ $directPath }}">

        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 col-12" style="box-shadow: 0 0 15px 5px #ccc">
                    <div class="row d-flex justify-content-center">
                        <a target="_blank" href="https://www.gotaps.me" class="col-12 header-navbar TopBanner">
                            <div class="TopBanner">
                                Tap here to get your Gotap profile
                            </div>
                        </a>
                        <div class="col-12 d-flex justify-content-center" style="padding: 0px;">
                            <div class="col-12" style="padding: 0px;">
                                <img style=" width: 100%;" src="{{ asset(isImageExist($user->cover_photo)) }}">
                                <div class="profile_img">
                                    <img src="{{ asset(isImageExist($user->photo, 'profile')) }}" alt="Profile Photo">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center" style="padding: 0px;">
                            <div class="col-md-11" style="padding: 0px;">
                                <h1 style=" margin-left:30px;" class="user-name">
                                    {{ $user->name ? $user->name : $user->username }}
                                </h1>
                                <p style=" margin-left:30px; font-size:16px; color:#24171E;" class="user-name">
                                    {{ $user->job_title }} at {{ $user->company }}

                                </p><br>


                                <h1 style="font-size:20px; width:auto; margin-left:auto; margin-right:auto"
                                    class="user-bio"> {{ $user->bio }}</h1><br>
                                <!-- <h1 class="user-tiks"><?= $user->tiks ?></h1>--><br><br><br>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center" style="padding: 0px;">
                            <div class=" col-md-6 col-8" style="padding: 0px;">
                                <button id="connectBTN" class="btn btn-block AddBtn rounded-pill px-4 py-3 "
                                    style="background-color: #000000;">
                                    <a style="text-decoration: none;" target="_blank" class="text-white"
                                        href="{{ route('save.contact', $user->id) }}"><b>Save to contact</b></a>
                                </button>
                            </div>
                        </div>


                        <div class="container">
                            <div class="row">
                                @if (count($userPlatforms))
                                    @php $itemCount = 0; @endphp
                                    @for ($i = 0; $i < count($userPlatforms); $i++)
                                        @for ($j = 0; $j < count($userPlatforms[$i]); $j++)
                                            @if ($itemCount % 3 === 0 && $itemCount > 0)
                                                </div> <!-- Close the previous row -->
                                                <div class="row my-3"> <!-- Start a new row -->
                                            @endif

                                            <div class="col-4 d-flex justify-content-center">
                                                @if ($userPlatforms[$i][$j]->check_user_privacy)
                                                    <a href="javascript:void(0)" class="social"
                                                        style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter: blur(5px);' : '' }}"
                                                        target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                        <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                            class="gallery-image img-fluid"
                                                            style="max-width: 100px; max-height: 100px; object-fit: cover;" />
                                                    </a>
                                                @else
                                                    @if ($userPlatforms[$i][$j]->base_url)
                                                        <a href="{{ $userPlatforms[$i][$j]->base_url . $userPlatforms[$i][$j]->path }}"
                                                            class="social"
                                                            onclick="platformIncrement({{ $userPlatforms[$i][$j]->platform_id }}, {{ $userPlatforms[$i][$j]->user_id }})"
                                                            style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter: blur(5px);' : '' }}"
                                                            target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                            <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                                class="gallery-image img-fluid"
                                                                style="max-width: 100px; max-height: 100px; object-fit: cover;" />
                                                        </a>
                                                    @else
                                                        <a href="{{ $userPlatforms[$i][$j]->path }}"
                                                            class="social"
                                                            onclick="platformIncrement({{ $userPlatforms[$i][$j]->platform_id }}, {{ $userPlatforms[$i][$j]->user_id }})"
                                                            style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter: blur(5px);' : '' }}"
                                                            target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                            <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                                class="gallery-image img-fluid"
                                                                style="max-width: 100px; max-height: 100px; object-fit: cover;" />
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>

                                            @php $itemCount++; @endphp
                                        @endfor
                                    @endfor
                                @endif
                            </div> <!-- Close the last row -->
                        </div>

                        <div class="col-12  d-flex justify-content-center">

                            <div class=".col-6 .col-md-4" style="padding: 0px;">
                                <br>
                                <button id="connectBTN" class="btn btn-block AddBtn rounded-pill px-4 py-3 "
                                    style="background-color: white; color:black; margin-top:5px;">
                                    <a target="_blank" style="text-decoration:none;color:black; " class="text-black"
                                        href="https://www.bit.ly/39sWoAJ"><b>Create your own profile</b></a>
                                </button> <br>
                            </div>
                            <!-- butoni tod -->




                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Bootstrap script -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            if ($('#direct_url').val()) {
                location.href = $('#direct_url').val()
            }
        });

        function platformIncrement(p_id, u_id) {
            $.ajax({
                url: "{{ route('inc.platform.click') }}",
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'platform_id': p_id,
                    'user_id': u_id
                },
                success: function(res) {
                    console.log(res);
                }
            })
        }
    </script>

    <script></script>

    {{-- <script>
        $(document).ready(function() {

            $(".see-more-btn").on("click", function() {
                $(this).siblings(".extra-content").toggle();
                $(this).text(function(i, text) {
                    return text === "See More" ? "See Less" : "See More";
                });
            });
        });
    </script> --}}

</body>

</html>
