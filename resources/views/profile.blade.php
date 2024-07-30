<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_2.png') }}" />

    <title>{{ config('app.name', 'Tocky') }}</title>

    <meta name="description" content="" />

    <!-- Link Stylesheet -->
    <link rel="stylesheet" href="{{ asset('profile/style.css') }}" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <!------------------------------------------------ Boxicon CDN ------------------------------------------->

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Hero Section -->

    <section>
        
        <input type="hidden" id="direct_url" value="{{$directPath}}">
        
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-5 col-12 shadow-lg">
                    <div class="header_section shadow bg-white m-2 rounded-5">
                        <div class="pb-3 pt-1">
                            <div class="cover_image p-2">
                                <img src="{{ asset(isImageExist($user->cover_photo)) }}" class="img-fluid rounded-5"
                                    alt="" />
                            </div>
                            <div class="tikl_profile_image d-flex justify-content-center">
                                <div class="tikl_profile">
                                    <img src="{{ asset(isImageExist($user->photo, 'profile')) }}" class="img-fluid"
                                        alt="" />
                                </div>
                            </div>
                            <div class="tikl_profile_content text-center">
                                <h3 class="mt-2">
                                    {{ $user->name ? $user->name : $user->username }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image Section -->

                    <div class="info_section">
                        <div class="row d-flex justify-content-center">
                            <div class="col-11">
                                <div class="row mx-auto mt-2 px-0">

                                    <div class="text-center p-0">
                                        <a href="{{ route('save.contact', $user->id) }}">
                                            <button class="btn btn-primary w-100">Guardar Contacto</button>
                                        </a>
                                    </div>

                                </div>

                                <!-- About Section -->

                                <div class="about_section mt-3">
                                    <h1>Perfil</h1>
                                    @if($user->bio)
                                    <div class="content-container">
                                        <p class="m-0" style="{{ $is_private ? 'filter:blur(3px)' : '' }}">
                                            {{ $user->bio }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="about_section mt-3">
                                    @if($user->job_title)
                                    <div class="d-flex gap-2">
                                        <h1>Profesión: </h1>{{ $user->job_title }}
                                    </div>
                                    @endif
                                    @if($user->job_title)
                                    <div class="d-flex gap-2">
                                        <h1>Empresa: </h1> {{ $user->company }}
                                    </div>
                                    @endif
                                </div>



                                <!-- Social Icons -->

                                @if (count($userPlatforms))
                                    <h5 class="py-3 headings">Redes Sociales</h5>

                                    @for ($i = 0; $i < count($userPlatforms); $i++)
                                        <div class="row {{ $i > 0 ? 'my-3' : '' }}">
                                            <div class="social-media-links d-flex">
                                                @for ($j = 0; $j < count($userPlatforms[$i]); $j++)
                                                    <div class="col-3 col-lg-3 d-flex justify-content-center">
                                                        @if ($userPlatforms[$i][$j]->check_user_privacy)
                                                            <a href="javascript:void(0)" class="social"
                                                                style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter:blur(5px)' : '' }}"
                                                                target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                                <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                                    class="img-fluid" />
                                                            </a>
                                                        @else
                                                            @if ($userPlatforms[$i][$j]->base_url)
                                                                <a href="{{ $userPlatforms[$i][$j]->base_url . $userPlatforms[$i][$j]->path }}"
                                                                    class="social"
                                                                    onclick="platformIncrement({{ $userPlatforms[$i][$j]->platform_id }}, {{ $userPlatforms[$i][$j]->user_id }})"
                                                                    style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter:blur(5px)' : '' }}"
                                                                    target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                                    <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                                        class="img-fluid" />
                                                                </a>
                                                            @else
                                                                <a href="{{ $userPlatforms[$i][$j]->path }}"
                                                                    class="social"
                                                                    onclick="platformIncrement({{ $userPlatforms[$i][$j]->platform_id }}, {{ $userPlatforms[$i][$j]->user_id }})"
                                                                    style="{{ $userPlatforms[$i][$j]->check_user_privacy ? 'filter:blur(5px)' : '' }}"
                                                                    target="{{ $userPlatforms[$i][$j]->check_user_privacy ? '' : '_blank' }}">
                                                                    <img src="{{ asset(isImageExist($userPlatforms[$i][$j]->icon, 'platform')) }}"
                                                                        class="img-fluid" />
                                                                </a>
                                                                <!--{{$userPlatforms[$i][$j]->direct}} ---- {{$userPlatforms[$i][$j]->platform_id}} -->
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    @endfor
                                @endif


                                <!------------------------------------ Social Networks Section Ended --------------------------->

                                <!----------------------------------------- Contact Section Started ---------------------------->

                                <div class="social-info">
                                    <h5 class="headings py-3">Datos de contacto</h5>
                                    <div class="row my-3">
                                        <div class="col-2">
                                            <i class="bx bx-envelope fs-4"></i>
                                        </div>
                                        <div class="col-10">
                                            <a href="{{ $is_private ? 'javascript:void(0)' : 'mailto:business@vittortech.com' }}"
                                                target="{{ $is_private ? 'javascript:void(0)' : '_blank' }}"
                                                style="{{ $is_private ? 'filter:blur(3px)' : '' }}"
                                                class="d-flex justify-content-between contact-links text-decoration-none text-dark">
                                                <div class="contact-information"
                                                    style="{{ $is_private ? 'filter:blur(3px)' : '' }}">
                                                    {{ $user->email }}
                                                </div>
                                                <div>
                                                    <span>
                                                        <i class="bx bx-chevron-right"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!--@if ($user->address)-->
                                    <!--    <div class="row my-3">-->
                                    <!--        <div class="col-2">-->
                                    <!--            <i class="bx bx-map fs-4"></i>-->
                                    <!--        </div>-->
                                    <!--        <div class="col-10">-->
                                    <!--            <a href="{{ $is_private ? 'javascript:void(0)' : 'https://maps.google.com/?q=  Toronto Ontario  Canada' }}"-->
                                    <!--                style="{{ $is_private ? 'filter:blur(1.5rem)' : '' }}"-->
                                    <!--                target="{{ $is_private ? '' : '_blank' }}"-->
                                    <!--                class="d-flex justify-content-between text-decoration-none text-dark">-->
                                    <!--                <div class="contact-information">-->
                                    <!--                    {{ $user->address }}-->
                                    <!--                </div>-->
                                    <!--                <div>-->
                                    <!--                    <span>-->
                                    <!--                        <i class="bx bx-chevron-right"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </a>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--@endif-->
                                </div>

                                <!------------------------------------------ Contact Section Ended ----------------------------->
                            </div>
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
            if($('#direct_url').val()) {
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
