@extends('layouts.layout')

@section('content')
<div class="p-0 m-0" >
    <div class="container-fluid px-lg-5 px-md-4 px-3 bg-light mb-5">
        <h1 class="text-center">Events</h1>
        <div class="carousel slide shadow" data-ride="carousel" id="carousel-1">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active" ><img class="w-100 d-block" src="{{ asset('img/homepage1.jpg') }}" alt="Slide Image" style="height: 450px; width: 290px;"></div>
                <div class="carousel-item"><img class="w-100 d-block" src="{{ asset('img/homepage2.png') }}" alt="Slide Image" style="height: 450px; width: 290px;"></div>
                <div class="carousel-item"><img class="w-100 d-block" src="{{ asset('img/homepage3.jpg') }}" alt="Slide Image" style="height: 450px; width: 290px;"></div>        </div>
            <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                    data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
            <ol class="carousel-indicators">
                <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-1" data-slide-to="1"></li>
                <li data-target="#carousel-1" data-slide-to="2"></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid py-4 px-5 "  style="background-color:rgba(9, 162, 255, 0.85);" >
        <div class="text-light ">
            <h2 class="text-center">What is RA 10931 or Universal Access to Quality Tertiary Education Act?</h2><br>
            <p> Signed by President Rodrigo Roa Duterte on 03 August 2017, Republic Act (RA) No. 10931, otherwise known as the Universal Access to Quality Tertiary Education Act is “an act promoting universal 
                access to quality tertiary education by providing free tuition and other school fees in State Universities and Colleges, Local Universities 
                <span id="mission"></span> Colleges, and State-Run Technical-Vocational Institutions, establishing the Tertiary Education Subsidy and Student Loan Program, strengthening the 
                Unified Student Financial Assistance System for Tertiary Education, and appropriating fund therefore,” as stated in the title of the Law.</p>
            <h2 class="text-center" id="vision">Mission</h2>
            <p>Cavite State University shall provide excellent, equitable, and relevant educational opportunities in the arts, sciences and technology through quality instruction and responsive research and development activities.
                It shall produce professional, skilled and morally upright individuals for global competitiveness.</p>
            <h2 class="text-center" id="goals">Vision</h2>
            <p>The Premier University in historic Cavite recognized for excellence in the development of globally competitive and morally upright individuals.</p>
            <h2 class="text-center">Goals</h2>
            <p>CvSU Naic shall endeavor to achieve the following goals:<br><hr>
                1.To produce technically competent and scientifically oriented graduates who are imbued with strong entrepreneurial spirit; possesses strong social consciousness; and guided by the positive values and high ethical standards;
                <br><hr> 
                2.To conduct relevant research and development activities along fisheries, education, business, information technology, arts and sciences that would contribute to sustainable development in its service areas;<br><hr style="color: white";> 
                3.Implement effective training and outreach programs that emphasize self-help, critical thinking and life-long learning;<br><hr style="color: white";> 
                4.Manage fishery and other enterprise projects to promote economically viable and environment-friendly approaches and techniques; and <br><hr style="color: white";> 
                5.Establish strong linkage with non-governmental organizations, other government entities and the basic sector for the realization of common goals.
            </p>
        </div>
    </div>
    <div class="container-fluid bg-dark text-light pt-5">
        <div class="row">
            <div class="col-sm-3 text-center mb-3 mb-sm-0">
                <h5>Get started</h5>
                <ul class="navbar-nav text-white">
                    <li class="nav-item"><a href="#">Home</a></li>
                    <li class="nav-item"><a href="#">Sign up</a></li>
                    <li class="nav-item"><a href="#">Sign in</a></li>
                </ul>
            </div>
            <div class="col-sm-3 text-center mb-3 mb-sm-0">
                <h5>About us</h5>
                <ul class="navbar-nav text-white">
                    <li class="nav-item"><a href="#">University Information</a></li>
                    <li class="nav-item"><a href="#">Contact us</a></li>
                    <li class="nav-item"><a href="#">Address</a></li>
                </ul>
            </div>
            <div class="col-sm-3 text-center mb-3 mb-sm-0">
                <h5>Support</h5>
                <ul class="navbar-nav text-white">
                    <li class="nav-item"><a href="#">FAQ</a></li>
                    <li class="nav-item"><a href="#">Help desk</a></li>
                    <li class="nav-item"><a href="#">Forums</a></li>
                </ul>
            </div>
            <div class="col-sm-3 text-center mb-3">
                <h5>Legal</h5>
                <ul class="navbar-nav text-white">
                    <li class="nav-item"><a href="#">Terms of Service</a></li>
                    <li class="nav-item"><a href="#">Terms of Use</a></li>
                    <li class="nav-item"><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="bg-secondary text-white text-center w-100 pt-2 pb-0 mt-2">
                <p>Copyright © 2021</p>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('js_area')
<script>
    var url = window.location.href;
    var index = url.indexOf('#');
    var active = url.substring(index);
    (index > 0)
        ? $('#hmenus').find('a[href="{{ route("home") }}'+active+'"]').addClass('active')
        : $('#hmenus').find('a[href="{{ route("home") }}"]').addClass('active')
</script>
@endsection