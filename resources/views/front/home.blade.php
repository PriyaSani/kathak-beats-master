@extends('layouts.front')
@section('title','KathakBeats: Best Classical Dance Academy in Mumbai')
@section('description','KathakBeats is a Classical Dance Academy which offers Regular Training, Workshops and other modules of training in KATHAK in both online and studio class modes.')
@section('content')
<style type="text/css">
    .main {
        margin-top: 80px;
    }
</style>
<main class="main">
    <section class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Our land infuses a sense of belonging, the art in us and to perform is to give back to this land, what we get from it."
                    </h1>
                </div>
            </div>
            <ul class="social-icons">
                <li>
                    <a href="https://youtube.com/channel/UCKByDSEbOFftIQTBi54DGew" title="Youtube" target="_blank"><img src="{{ asset('front/images/youtube.svg') }}" alt=""></a>
                </li>
                <li>
                    <a href="https://www.facebook.com/DancewithSanikaPurohit/" title="Facebook" target="_blank"><img src="{{ asset('front/images/facebook.svg') }}" alt=""></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/kathakbeats/?igshid=1xltn4f2p6pge" title="Instagram" target="_blank"><img src="{{ asset('front/images/instagram.svg') }}" alt=""></a>
                </li>
            </ul>
        </div>
    </section>
    <section class="home-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h2 class="no-border">We tell stories that inspire people through dance</h2>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <p>KathakBeats is a Classical Dance Academy which offers Studio and Online
                                    Training and Workshops for Kathak Enthusiasts.
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p>KathakBeats has been associated with classical training & choreographies with
                                    various schools, colleges, social events and corporates.
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p>Based in Mumbai, it has taught Kathak to over 500+ Students in the past 3
                                    Years of its Inception.
                                </p>
                               
                            </div>
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-12">
                                <a href="{{ route('about') }}" class="yellow-btn" title="Get To Know Us">Get To Know
                                    Us</a>
                                <a href="#batches-gallery" class="yellow-btn filled ml-4" title="View our Batches">
                                    View our Batches
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="batch-workshops" data-sec='batches-gallery' id="batches-gallery">
        <div class="tabbing-wrapper">
            <div class="tabbing-link">
                <ul class="tabbing-list">
                    @if(count($worskhop) > 0)
                        <li><a href="#" class="active" title="Workshops" data-link="workshops">Workshops</a></li>
                    @endif
                    @if(count($batch) > 0)
                        <li><a href="#"  title="Batches" data-link="batches">Batches</a></li>
                    @endif
                    
                    <li><a href="#" title="Gallery" data-link="gallery">Gallery</a></li>
                </ul>
            </div>
            <div class="tabbing-content">
                @if(count($worskhop) > 0)
                    <div class="tabbing-outer active" data-content="workshops">
                        <div class="inner-filter">
                            <ul>
                                <li>
                                    <a href="#" title="Studio Batches" class="workshopFilter active workshopall" data-id="all">All</a>
                                </li>
                                <li>
                                    <a href="#" title="Studio Workshops" class="workshopFilter workshopstudio" data-id="studio">Studio Workshops</a>
                                </li>
                                <li>
                                    <a href="#" title="Online Workshops" class="workshopFilter workshoponline" data-id="online">Online Workshops</a>
                                </li>
                            </ul>
                        </div>

                        <div class="inner-filter month">
                            <ul>
                                <li><a href="#" title="Back" class="go-back"><img src="{{ asset('front/images/left-arrow-pink.svg') }}" alt=""></a>
                                </li>
                                <li><a href="#" title="All">All</a></li>
                                <li><a href="#" title="Jan">Jan</a></li>
                                <li><a href="#" title="Feb">Feb</a></li>
                                <li><a href="#" title="Mar">Mar</a></li>
                                <li><a href="#" title="Apr">Apr</a></li>
                                <li><a href="#" title="May">May</a></li>
                                <li><a href="#" title="June">June</a></li>
                                <li><a href="#" title="July">July</a></li>
                                <li><a href="#" title="Aug">Aug</a></li>
                                <li><a href="#" title="Sept">Sept</a></li>
                                <li><a href="#" title="Oct">Oct</a></li>
                                <li><a href="#" title="Nov">Nov</a></li>
                                <li><a href="#" title="Dec">Dec</a></li>
                            </ul>
                        </div>

                        <div class="batch-slider swiper-container">
                            <div class="swiper-wrapper">
                                @if(!is_null($worskhop))
                                    @foreach($worskhop as $ok => $ov)
                                        @php
                                            $date = array();
                                            if(!is_null($ov->timetable)){
                                                foreach($ov->timetable as $bk => $bv){
                                                    $date[] = date('M d',strtotime($bv->date));
                                                }
                                            }
                                        @endphp
                                        <div class="swiper-slide batch-slide @if($ov->engagement_mode == 1) studioworkshop  @else onlineworkshop  @endif">
                                            <div class="batch-thumb"
                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/poster/{{ $ov->poster }});"></div>
                                            <div class="batch-info">
                                                <h5>{{ $ov->title }}</h5>
                                                <!-- @if(!is_null($date))
                                                    <p class="participants date">{{  implode(', ',$date) }}</p>
                                                @endif -->
                                                <a href="{{ route('workSpaceDetails',$ov->uuid) }}" class="learn-more-link" title="Click Here to Register">Click Here to Register</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                @endif

                @if(count($batch) > 0)
                    <div class="tabbing-outer" data-content="batches">
                        <div class="inner-filter">
                            <ul>
                                <li>
                                    <a href="#" title="Studio Batches" class="batchFilter active batchall" data-id="all">All</a>
                                </li>
                                <li>
                                    <a href="#" title="Studio Batches" class="batchFilter batchstudio" data-id="studio">Studio Batches</a>
                                </li>
                                <li>
                                    <a href="#" title="Online Batches" class="batchFilter batchonline" data-id="online">Online Batches</a>
                                </li>
                            </ul>
                        </div>

                        <div class="inner-filter month">
                            <ul>
                                <li><a href="#" title="Back" class="go-back"><img src="{{ asset('front/images/left-arrow-pink.svg') }}" alt=""></a>
                                </li>
                                <li><a href="#" title="All">All</a></li>
                                <li><a href="#" title="Jan">Jan</a></li>
                                <li><a href="#" title="Feb">Feb</a></li>
                                <li><a href="#" title="Mar">Mar</a></li>
                                <li><a href="#" title="Apr">Apr</a></li>
                                <li><a href="#" title="May">May</a></li>
                                <li><a href="#" title="June">June</a></li>
                                <li><a href="#" title="July">July</a></li>
                                <li><a href="#" title="Aug">Aug</a></li>
                                <li><a href="#" title="Sept">Sept</a></li>
                                <li><a href="#" title="Oct">Oct</a></li>
                                <li><a href="#" title="Nov">Nov</a></li>
                                <li><a href="#" title="Dec">Dec</a></li>
                            </ul>
                        </div>

                        <div class="batch-slider swiper-container">
                            <div class="swiper-wrapper">
                                @if(!is_null($batch))
                                    @foreach($batch as $ok => $ov)
                                        <div class="swiper-slide batch-slide @if($ov->engagement_mode == 1) studiobatch @else onlinebatch  @endif">
                                            <div class="batch-thumb"
                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/poster/{{ $ov->poster }});"></div>
                                            <div class="batch-info">
                                                <h5>{{ $ov->title }}</h5>
                                                <!-- <p class="participants">{{ $ov->students }} Participants</p> -->
                                                <a href="{{ route('batchDetail',$ov->uuid) }}" class="learn-more-link" title="Click Here to Register">Click Here to Register</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                        </div>
                    </div>
                @endif
                
                <!-- Gallery Tab starts -->
                <div class="tabbing-outer" data-content="gallery">
                    <div class="inner-tabbing-wrapper">
                        <div class="inner-filter">
                            <ul>
                                <li>
                                    <a href="#" title="Photos" class="active" data-inner-link="photos">Photos</a>
                                </li>
                                <li>
                                    <a href="#" title="Videos" data-inner-link="videos">Videos</a>
                                </li>
                            </ul>
                        </div>

                        <div class="inner-content-wrapper">

                            <!-- Photos tab -->
                            <div class="inner-tabbing-content active" data-inner-content="photos">
                                <div class="gallery-slider swiper-container">
                                    <div class="swiper-wrapper">
                                        @if(!is_null($gallery))
                                            @foreach($gallery as $gk => $gv)
                                                @if($gv->grid_type == 1)
                                                    <div class="swiper-slide gallery-slide">
                                                        <div class="thumb-outer">
                                                            <a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }}" class="html5lightbox" data-group="img-kb-gallery">
                                                                <div class="gallery-thumb" 
                                                                    style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }});">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="swiper-slide gallery-slide is-multiple">
                                                        <div class="thumb-outer">
                                                            <a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }} " class="html5lightbox" data-group="img-kb-gallery">
                                                                <div class="gallery-thumb"
                                                                    style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }});">
                                                                </div>
                                                            </a>
                                                            <a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_two }} " class="html5lightbox" data-group="img-kb-gallery">
                                                                <div class="gallery-thumb"
                                                                    style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_two }});">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                                <div class="view-all">
                                    <a href="{{ route('gallery') }}" title="View All">View All</a>
                                </div>
                            </div>

                            <!-- Videos tab -->
                            <div class="inner-tabbing-content" data-inner-content="videos">
                                <div class="gallery-slider swiper-container">
                                    <div class="swiper-wrapper">
                                        @if(!is_null($video))
                                            @foreach($video as $vk => $vv)
                                                @if($vv->grid_type == 1)
                                                    <div class="swiper-slide gallery-slide has-video">
                                                        <div class="thumb-outer">
                                                            <a href="{{ $vv->video_url_one }}"
                                                                class="gallery-thumb html5lightbox" data-group="kb-video-gallery"
                                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/video/{{ $vv->video_thumbnail_one }} );">
                                                                <div class="inner-content">
                                                                    <h4>{{ $vv->video_title_one }}</h4>
                                                                    <em class="play-btn"></em>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    
                                                @elseif($vv->grid_type == 2)
                                                    <div class="swiper-slide gallery-slide has-video is-multiple">
                                                        <div class="thumb-outer">
                                                            <a href="{{ $vv->video_url_one }}"
                                                                class="gallery-thumb html5lightbox lg" data-group="kb-video-gallery"
                                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/video/{{ $vv->video_thumbnail_one }} );">
                                                                <div class="inner-content">
                                                                    <h4>{{ $vv->video_title_one }}</h4>
                                                                    <em class="play-btn"></em>
                                                                </div>
                                                            </a>
                                                            <a href="{{ $vv->video_url_two }}"
                                                                class="gallery-thumb html5lightbox" data-group="kb-video-gallery"
                                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/video/{{ $vv->video_thumbnail_two }} );">
                                                                <div class="inner-content">
                                                                    <h4>{{ $vv->video_title_two }}</h4>
                                                                    <em class="play-btn"></em>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="swiper-slide gallery-slide has-video is-multiple">
                                                        <div class="thumb-outer">
                                                            <a href="{{ $vv->video_url_one }}"
                                                                class="gallery-thumb html5lightbox" data-group="kb-video-gallery"
                                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/video/{{ $vv->video_thumbnail_one }} );">
                                                                <div class="inner-content">
                                                                    <h4>{{ $vv->video_title_one }}</h4>
                                                                    <em class="play-btn"></em>
                                                                </div>
                                                            </a>
                                                            <a href="{{ $vv->video_url_two }}"
                                                                class="gallery-thumb html5lightbox lg" data-group="kb-video-gallery"
                                                                style="background-image: url({{ Config::get('constants.awsUrl') }}/video/{{ $vv->video_thumbnail_two }} );">
                                                                <div class="inner-content">
                                                                    <h4>{{ $vv->video_title_two }}</h4>
                                                                    <em class="play-btn"></em>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                                <div class="view-all">
                                    <a href="{{ route('gallery') }}" title="View All">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Gallery Tab ends -->
            </div>
        </div>
    </section>

    <section class="home-kalabhumi-block" data-sec="kalabhumi" id="kalabhumi">
        <div class="kalabhumi-text-ticker-mob">
            <img src="{{ asset('front/images/kalabhoomi_mobile.svg') }}" alt="">
            <img src="{{ asset('front/images/kalabhoomi_mobile.svg') }}" alt="">
        </div>
        <div class="container">
            <div class="kalabhumi-tabbing">
                <ul class="links">
                    <li class="active">
                        <a href="#" year-link="2019">
                            <span class="h2"><em>Kalabhoomi</em> 2019</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#" year-link="2022">
                            <span><em>Kalabhoomi</em> 2022</span>
                        </a>
                    </li> -->
                </ul>

                <div class="kalabhumi-tab-content">
                    <div class="kalabumi-tab-content-outer" year-data="2019">
                        <div class="row">
                            <div class="col-md-9 content-block">
                                <!-- <h2>Kalabhumi 2019</h2> -->
                                <p>
                                    Kathak Beats Presented it’s First Annual Kathak Showcase Event, “ Kalabhoomi 2019” on 6th October, 2019  at Terapant Bhavan, Kandivali East which was Attended by over 400 People. It was a Showcase Event which was Presented by Over 45 Students from Kathak Beats.
                                </p>
                                <p>
                                    It was conducted in Association with Prabhu Associates Consultants Pvt. Ltd ( PACPL ) & Co-Sponsored by Inme Learning Pvt. Ltd and Easy Eastin- Aishwarya Talegaon. 
                                </p>
                                <p>
                                    Other Notable Association included Vama Jewels, Pooja Entereprises, Physiocube and Supriya Lifescience Ltd. 
                                </p>
                                <p>
                                    A Strategic Tie-Ups was entered into with BookMyShow ( Online ticketing Partner ) which contributed the show to be 100% Sold Out with respect to the ticketing.
                                </p>
                                <a href="https://youtu.be/SnGng5oncMo" class="yellow-btn filled registerForBatch html5lightbox video-item" title="Watch Trailer" data-id="5868f4eb-de97-4572-99fd-bfbc62287cd2">
                                    Watch Trailer
                                </a><br><br>
                            </div>
                            <div class="col-md-3">
                                <div class="kalabhumi-text-ticker">
                                    <img src="{{ asset('front/images/kalabhoomi.svg') }}" alt="">
                                    <img src="{{ asset('front/images/kalabhoomi.svg') }}" alt="">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="kalabhumi-ticker-wrapper">
                                    <div class="kalabhumi-ticker str_wrap">

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-12.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-12.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-1.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-1.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-4.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-4.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>
                                        
                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-3.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-3.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-7.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-7.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>
                                        
                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-8.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-8.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                         <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-5.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-5.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>
                                        
                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-10.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-10.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>
                                       
                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-9.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-9.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-11.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-11.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-2.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-2.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-13.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-13.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-14.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-14.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-15.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-15.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-16.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-16.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-17.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-17.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-18.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-18.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-19.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-19.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-20.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-20.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-21.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-21.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-22.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-22.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-23.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-23.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-24.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-24.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-25.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-25.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-26.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-26.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-27.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-27.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-28.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-28.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-29.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-29.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-30.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-30.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-31.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-31.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-32.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-32.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-33.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-33.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-34.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-34.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-35.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-35.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-36.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-36.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-37.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-37.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-38.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-38.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-39.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-39.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-40.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-40.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-41.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-41.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-42.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-42.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-43.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-43.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-44.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-44.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-45.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-45.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-46.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-46.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-47.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-47.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-48.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-48.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-49.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-49.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-50.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-50.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-51.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-51.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-52.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-52.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-53.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-53.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-54.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-54.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-55.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-55.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-56.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-56.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-57.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-57.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-58.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-58.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-59.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-59.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-60.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-60.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-61.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-61.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-62.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-62.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-63.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-63.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-64.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-64.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-65.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-65.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-66.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-66.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-67.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-67.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-68.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-68.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-69.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-69.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-70.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-70.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-71.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-71.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-72.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-72.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-73.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-73.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-74.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-74.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                        <div class="kalabhumi-item">
                                            <div class="kalabhumi-image"
                                                style="background-image: url({{ asset('front/images/TSE_KBH-75.jpg')}} );">
                                                <img src="{{ asset('front/images/TSE_KBH-75.jpg')}} " alt="Kalabhoomi 2019">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="kalabumi-tab-content-outer" year-data="2022">
                        <div class="row">
                            <div class="col-md-9 content-block">
                                <p>Coming Soon!</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <section class="home-association" data-sec='association' id="association">
        <div class="container">
            <h2 class="no-border">Our Associations</h2>
            
            <div class="association-grid">
                <div class="association-grid">
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/mumbai-university.png') }}" alt="mumbai-university">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/eastin.png') }}" alt="eastin">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/inme.png') }}" alt="inme">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/prabhu-associate.png') }}" alt="prabhu-associate">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/supriya.png') }}" alt="supriya">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/magic-bangkok.png') }}" alt="magic-bangkok">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/ramniklal-co.png') }}" alt="ramniklal-co">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/rotary-logo.png') }}" alt="rotary-logo">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/fab_india.png') }}" alt="ramniklal-co">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/saffron_threads_clothing.png') }}" alt="rotary-logo">
                        </a>
                    </div>
                    <div class="grid-item">
                        <a href="#">
                        <img src="{{ asset('front/images/association/physiocube.png') }}" alt="rotary-logo">
                        </a>
                    </div>
                </div>
            </div>
            <!-- <div class="btn-wrapper">
                <a href="#" title="View all" class="primary-link">View all</a>
            </div> -->
        </div>
    </section>

    <section class="kathak-spirit">
        <div class="trigger-wpsec">
            <div class="spacer" id="trigger"></div>
        </div>
        <div class="spirit-slider-outer">
            <div class="spirit-slider">
                <div class="">
                    <div class="slider slider-slide1" data-index="1">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/elegance_grace.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Elegance & Grace</h2>
                                    <p>
                                        Kathak, one of the most elegant dance forms of India, revolves around the concept of storytelling. An art form with inexplicable charm, mesmerising footwork, and graceful movements, Kathak figures among the eight Indian classical dance forms and originates from the North of India.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider slider-slide2" data-index="2">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/guru_shishya.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Artistic & Expressive</h2>
                                    <p>
                                        In Kathak, the artist depicts a story through facial expressions along with hand gestures and body movements. Thus, developing a very expressive personality. Kathak encompasses knowledge of classical vocals, instruments and movements thereby developing an artistic personality. 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider slider-slide3" data-index="3">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/indian_culture.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Indian Culture</h2>
                                    <p>
                                        Learning Kathak offers a great opportunity to understand about great Indian culture and Heritage. In Kathak, various stories from Indian mythology are depicted most illustratively about Ramayana, Mahabharata and other epic stories of Indian Gods and Goddesses.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider slider-slide4" data-index="4">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/confidence.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Confidence</h2>
                                    <p>
                                        Learning Classical Art develops and disciplines personnel and builds a confident personality to present the art from the very early stages of life. This quality helps in every walk of life and not limiting it to dance only. It definitely boosts self confidence and within no time one would discover a whole new spiritual and ethereal experience.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider slider-slide5" data-index="5">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/healthy_lifestyle.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Healthy Lifestyle</h2>
                                    <p>
                                        The Indian Classical dance forms, specially Kathak, vastly aids in maintaining an active life for those indulged in the same. This ensures a healthy lifestyle and provides adequate physical and mental well being. It also plays a vital role in moderating one’s breathing techniques(for recitals), building up stamina (for performance).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider slider-slide6" data-index="6">
                        <div class="spirit-wrapper">
                            <div class="spirit-banner"
                                style="background-image: url({{ asset('front/images/spirit/gurushishya.png')}} )"></div>
                            <div class="spirit-content">
                                <div class="inner-content">
                                    <h6>Spirit Of Kathak</h6>
                                    <h2 class="no-border">Guru Shishya Parampara</h2>
                                    <p>
                                        The epitome of any classical dance art is establishing a disciplined routine which is paved through the Guru-Shishya Parampara where the art is preached by the Guru and is practised by the Shishya. This Parampara or practice  has been followed in India since ancient times and is the crux of our rich Indian heritage.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navigation-block">
                    <ul class="nav-dots">
                        <li data-nav="1" class="active">
                            <span></span>
                        </li>
                        <li data-nav="2">
                            <span></span>
                        </li>
                        <li data-nav="3">
                            <span></span>
                        </li>
                        <li data-nav="4">
                            <span></span>
                        </li>
                        <li data-nav="5">
                            <span></span>
                        </li>
                        <li data-nav="6">
                            <span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="spirit-slider-mobile">
            <div class="container">
                <!-- Swiper -->
                <div class="swiper-container spirit-top">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Elegance & Grace</h2>
                            <p>
                                Kathak, one of the most elegant dance forms of India, revolves around the concept of storytelling. An art form with inexplicable charm, mesmerising footwork, and graceful movements, Kathak figures among the eight Indian classical dance forms and originates from the North of India.
                            </p>
                        </div>
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Artistic & Expressive</h2>
                            <p>
                                In Kathak, the artist depicts a story through facial expressions along with hand gestures and body movements. Thus, developing a very expressive personality. Kathak encompasses knowledge of classical vocals, instruments and movements thereby developing an artistic personality. 
                            </p>
                        </div>
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Indian Culture</h2>
                            <p>
                                Learning Kathak offers a great opportunity to understand about great Indian culture and Heritage. In Kathak, various stories from Indian mythology are depicted most illustratively about Ramayana, Mahabharata and other epic stories of Indian Gods and Goddesses.
                            </p>
                        </div>
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Confidence</h2>
                            <p>
                                Learning Classical Art develops and disciplines personnel and builds a confident personality to present the art from the very early stages of life. This quality helps in every walk of life and not limiting it to dance only. It definitely boosts self confidence and within no time one would discover a whole new spiritual and ethereal experience.
                            </p>
                        </div>
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Healthy Lifestyle</h2>
                            <p>
                                The Indian Classical dance forms, specially Kathak, vastly aids in maintaining an active life for those indulged in the same. This ensures a healthy lifestyle and provides adequate physical and mental well being. It also plays a vital role in moderating one’s breathing techniques(for recitals), building up stamina (for performance).
                            </p>
                        </div>
                        <div class="swiper-slide">
                            <h6>Spirit Of Kathak</h6>
                            <h2 class="no-border">Guru Shishya Parampara</h2>
                            <p>
                                The epitome of any classical dance art is establishing a disciplined routine which is paved through the Guru-Shishya Parampara where the art is preached by the Guru and is practised by the Shishya. This Parampara or practice  has been followed in India since ancient times and is the crux of our rich Indian heritage.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-container spirit-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/elegance_grace.png')}} )">
                        </div>
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/guru_shishya.png')}} )">
                        </div>
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/indian_culture.png')}} )">
                        </div>
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/confidence.png')}} )">
                        </div>
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/healthy_lifestyle.png')}} )">
                        </div>
                        <div class="swiper-slide" style="background-image:url({{ asset('front/images/spirit/gurushishya.png')}} )">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-latest-work">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h2 class="no-border">Our latest work</h2>
                    <p>{{ $getWork->first_paragraph}} 
                    </p>
                    <p>{{ $getWork->second_paragraph}} 
                    </p>
                </div>
                <div class="col-md-6 offset-md-1">
                    <div class="video-sidebar-wrapper custom-scroll">
                        @if(!is_null($getWork->video))
                            @foreach($getWork->video as $vk => $vv)
                                @if($vv->is_active == 1)
                                    <a href="{{ $vv->url }}" class="html5lightbox video-item"
                                        data-group="latest-work-videos"
                                        style="background-image: url({{ Config::get('constants.awsUrl') }}/work/{{ $vv->thumb }} );">
                                        <div class="video-heading">
                                            <h4>{{ $vv->title }}</h4>
                                            <em><img src="{{ asset('front/images/play.svg') }}" alt=""></em>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-about-studio">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="no-border">About Studio</h2>
                    <p>Our studio provides live training of the kathak dance form
                        to all the age groups. We provide immersive environment
                        with talented faculties to pay utmost attention to develop
                        your kathak dance form skills.
                    </p>
                    <div class="address-wrapper">
                        <div class="address-block">
                            <p>Goregaon East : The Desi Art Studio,
                                Gala No 23, Building No 2,
                                Sainath Industrial Estate,
                                Vishveshwar Nagar Rd,
                                Opp. Pravasi Ind Estate,
                                Goregaon-East, Mumbai,
                                Maharashtra 400063
                            </p>
                        </div>
                        <div class="address-block">
                            <p>Andheri West : Meraki Performing Arts Studio <br />
                                Shastri Nagar, Andheri West, Mumbai, Maharashtra 400047</p>
                        </div>
                        <div class="address-block">
                            <p>Bandra West - Coming Soon</p>
                        </div>
                        <div class="address-block">
                            <p>Bandra West - Coming Soon</p>
                        </div>
                    </div>
                    <!-- <div class="image-block">
                        <img src="{{ asset('front/images/about-studio-img.jpg')}} " alt="">
                    </div> -->
                </div>
                <!-- <div class="col-md-5">
                    <a href="https://www.youtube.com/embed/ktF0l4ObblA" class="html5lightbox video-block"
                        style="background-image: url({{ asset('front/images/about-studio-video.jpg')}} );">
                    <em><img src="{{ asset('front/images/play-white.svg') }}" alt=""></em>
                    </a>
                </div> -->
                <div class="col-md-5">
                    <a href="javascript:void(0);" class="video-block"
                        style="background-image: url({{ asset('front/images/about-studio-video.png')}} );">
                    <!-- <em><img src="{{ asset('front/images/play-white.svg') }}" alt=""></em> -->
                    </a>
                </div>
            </div>
        </div>
    </section>

    

</main>
@endsection