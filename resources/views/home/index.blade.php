@extends('layouts.home')

@section('content')
    <section class="header9 cid-swVxdys4TP mbr-fullscreen mbr-parallax-background" id="header9-1">
        <div class="container">
            <div class="media-container-column mbr-white col-lg-8 col-md-10">
                <h1 class="mbr-section-title align-left mbr-bold pb-3 mbr-fonts-style display-1">adadimana.com</h1>
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('track_order') }}" method="get">
                            <div class="input-group input-group-lg">
                                <x-input class="form-control-lg px-4" name="no_order" caption="Delivery Order Code" />
                                <div class="input-group-append p-0">
                                    <button class="btn btn-primary m-0 px-5">Track Location</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px">
                    <div class="col-md-6 pl-1">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login</a>
                    </div>
                    <div class="col-md-6 pr-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-block">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
            <a href="#next">
                <i class="mbri-down mbr-iconfont"></i>
            </a>
        </div>
    </section>

    <section class="cid-sxDcZr4DFa mbr-fullscreen" id="header2-e">
        <div class="container align-center">
            <div class="row justify-content-md-center">
                <div class="mbr-white col-md-10">
                    <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-2">
                        <span style="font-weight: normal;">Starting from simple ideas</span>
                    </h1>
                    <p class="mbr-text pb-3 mbr-fonts-style display-5">In logistics, goods delivery activities are very important, and we are aware that transparency of common information between shippers, logistics service providers and cosignees is needed and the key of success in logistics.
                        <br>Our ideas are very simple, we provide common information about delivery activities in a logistics process by utilizing internet technology that can be accessed easily by all parties involved in delivery activities process.</p>
                </div>
            </div>
        </div>
        <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
            <a href="#next">
                <i class="mbri-down mbr-iconfont"></i>
            </a>
        </div>
    </section>

    <section class="features3 cid-swVFWwb6J2" id="features3-5">
        <div class="container">
            <div class="media-container-row">
                <div class="card p-3 col-12 col-md-6 col-lg-4">
                    <div class="card-wrapper">
                        <div class="card-img">
                            <img src="{{ asset('websites/images/ship-596x448.png') }}" alt="Mobirise" title="">
                        </div>
                        <div class="card-box">
                            <h4 class="card-title mbr-fonts-style display-7">
                                For Shipper</h4>
                            <p class="mbr-text mbr-fonts-style display-4">Our application will provide information on the readiness of the goods just before they are sent until they are loaded onto the chosen mode of transportation.
                                <br>All related information will be shared with transportation service providers and also to the consignee with the aim that all parties involved in the delivery of goods have the same information.&nbsp;<br></p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 col-12 col-md-6 col-lg-4">
                    <div class="card-wrapper">
                        <div class="card-img">
                            <img src="{{ asset('websites/images/trans-596x447.png') }}" alt="Mobirise" title="">
                        </div>
                        <div class="card-box">
                            <h4 class="card-title mbr-fonts-style display-7">
                                For Transport Provider</h4>
                            <p class="mbr-text mbr-fonts-style display-4">Our application able to track the selected cargo vehicle, so that the sender and receiver of the goods can participate in monitoring the position of the goods in real time.<br></p>
                        </div>

                    </div>
                </div>

                <div class="card p-3 col-12 col-md-6 col-lg-4">
                    <div class="card-wrapper">
                        <div class="card-img">
                            <img src="{{ asset('websites/images/cons-596x448.png') }}" alt="Mobirise" title="">
                        </div>
                        <div class="card-box">
                            <h4 class="card-title mbr-fonts-style display-7">
                                For Consignee</h4>
                            <p class="mbr-text mbr-fonts-style display-4">With the real time information on delivery activities, the recipient of the goods can estimate the arrival time of the goods which aims to more optimally prepare for unloading activities, which indirectly affects the overall business process.<br></p>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>

    <section class="progress-bars3 cid-swVIEBCsV4" id="progress-bars3-6">





        <div class="container">
            <h2 class="mbr-section-title pb-3 align-center mbr-fonts-style display-2">We're working hard to make it happen
            </h2>

            <h3 class="mbr-section-subtitle mbr-fonts-style display-5">We are different from logistic tech-startups in general, because we are not a logistics marketplace, we prefer to be called an information hub.
                <div>All commercial aspects that occur in the business between shippers, transporter and consignee are fully regulated by the parties and we are not willing to interfere with this.&nbsp;</div></h3>

            <div class="media-container-row pt-5 mt-2">
                <div class="card p-3 align-center">
                    <div class="wrap">
                        <div class="pie_progress progress1" role="progressbar" data-goal="100">
                            <p class="pie_progress__number mbr-fonts-style display-5">50%</p>
                        </div>
                    </div>
                    <div class="mbr-crt-title pt-3">
                        <h4 class="card-title py-2 mbr-fonts-style display-5">
                            Concept</h4>
                    </div>
                </div>

                <div class="card p-3 align-center">
                    <div class="wrap">
                        <div class="pie_progress progress2" role="progressbar" data-goal="10">
                            <p class="pie_progress__number mbr-fonts-style display-5"></p>
                        </div>
                    </div>
                    <div class="mbr-crt-title pt-3">
                        <h4 class="card-title py-2 mbr-fonts-style display-5">
                            Apps Development</h4>
                    </div>
                </div>

                <div class="card p-3 align-center">
                    <div class="wrap">
                        <div class="pie_progress progress3" role="progressbar" data-goal="0">
                            <p class="pie_progress__number mbr-fonts-style display-5"></p>
                        </div>
                    </div>
                    <div class="mbr-crt-title pt-3">
                        <h4 class="card-title py-2 mbr-fonts-style display-5">Launching</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <iframe frameborder="0" style="border:0;width: 100%;height:500px;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCZI5F_k6S1k46ujh0SNrapM89f7mJxd30&amp;q=place_id:ChIJtwRkSdcHTCwRhfStG-dNe-M" allowfullscreen=""></iframe>
@endsection
