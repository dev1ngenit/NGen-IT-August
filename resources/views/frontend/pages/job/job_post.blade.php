@extends('frontend.master')
@section('content')
    @php
        $setting = App\Models\Site::first();
    @endphp

    <!--======// Header Title //======-->
    <section class="common_product_header"
        style="background-image: linear-gradient(
        rgba(0,0,0,0.8),
        rgba(0,0,0,0.8)
        ),url('https://fjwp.s3.amazonaws.com/blog/wp-content/uploads/2020/03/11140107/find-remote-job-1024x512.png');">
        <div class="container ">
            <h1>Find Work</h1>

            <div class="row ">
                <div class="input-group w-50 mx-auto">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn job_search_btn" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <!--BUTTON START-->
                <div class="d-flex justify-content-center align-items-center">
                    <div class="m-4">
                        <a class="common_button2" href="{{route('contact')}}">Talk to a Specialist</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!----------End--------->

    <!--========// Job Post //========-->
    <section class="container">
        <div class="row mt-5">
            <!--------Job Post item------->

            @foreach ($jobs as $item)
                <div class="col-lg-6 col-sm-12">
                    <div class="job_post_card my-3">
                        <div class="job_post_card_img">
                            <img class="img-fluid"
                                src="{{ !empty($setting->logo) ? asset('storage/' . $setting->logo) : url('upload/no_image.jpg') }}"
                                alt="">
                        </div>
                        <div class="job_post_card_details">
                            <h6>{{ $item->name }}</h6>
                            <ul>
                                {{-- <li><i class="fa-solid fa-location-dot"></i> <span> Ring Road, Mohammadpur, Dhaka</span></li>
                                <li><i class="fa-solid fa-graduation-cap"></i>Bachelor degree in any discipline</li> --}}
                                <li><i class="fa-solid fa-user-tie"></i> {{ $item->experience }}</li>
                            </ul>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="job_post_btn" href="{{ route('job.details', $item->slug) }}">Learn more <i
                                            class="fa-solid fa-angles-right"></i></a>
                                </div>
                                <div class="job_post_end_date">
                                    <p><i class="fa-solid fa-calendar-day"></i> Deadline:</p>
                                    <p> <strong>{{ $item->deadline }}</strong> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!--------Job Post item------->

        </div>
    </section>
    <!---------End--------->
    <!---------
     <section>
        <div class="container">
            <div class="row d-flex justify-content-between mt-5 mb-5">
                <div class="col-md-3 col-sm-6">
                    <div class="card card-block">
                        <img src="https://static.pexels.com/photos/7096/people-woman-coffee-meeting.jpg"
                            alt="Photo of sunset">
                        <div class="px-3 py-3 d-flex flex-column justify-content-center">
                            <h5 class="card-title mt-3 mb-3 fw-bold">
                                Web & Graphics Designer</h5>
                            <p class="card-text">All reqirement here please check the details.</p>
                            <div class="row d-flex">
                                <div class="col">
                                    <i class="fa-solid fa-user-tie"></i>Vacancy <br>
                                    {{-- <span class="text-danger">{{ $item->experience }}</span> --}}
                                </div>
                                <div class="col">
                                    <i class="fa-solid fa-calendar-day"></i> Deadline
                                    {{-- <span class="text-danger">{{ $item->deadline }}</span> --}}
                                </div>
                            </div>
                            <a href="" class="common_button effect01 mt-2" tabindex="-1">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    --------->
@endsection
