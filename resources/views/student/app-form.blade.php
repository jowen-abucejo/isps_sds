@extends('layouts.mainview')

@section('active_view')
<h4>Online Application Form</h4>
<h6><i>Please fill-up required <span class="text-danger">*</span> fields.</i></h6>
@endsection
@section('bottom_view')
<div>
    <form action="" method="POST">
        @csrf
        <div id="carousel4Form" class="carousel slide px-md-5" data-interval="false" data-wrap="false">
            <ol class="carousel-indicators">
                <li data-target="#carousel4Form" class="active bg-dark"></li>
                <li data-target="#carousel4Form" class="bg-dark"></li>
                <li data-target="#carousel4Form" class="bg-dark"></li>
                <li data-target="#carousel4Form" class="bg-dark"></li>
            </ol>
            <div class="carousel-inner px-md-5" id="inputs_container">

                {{-- Page 1 --}}
                <div class="carousel-item active">
                    <div class="card">
                        <div class="card-header text-center">
                            Personal Information
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                {{-- Last name --}}
                                <div class="col-md-6  form-group">
                                    <label for="LastName" class="col-form-label col-form-label-sm">Last Name  * (<i><small>put extension if any</small></i>)</label>
                                    <input type="text" id="LastName" name="lname" class="form-control form-control-sm" pattern="[a-zA-Z ñÑ]+" required>                                    
                                </div>
                                {{-- Middle name --}}
                                <div class="col-md-6  form-group">
                                    <label for="MiddleName" class="col-form-label col-form-label-sm">Middle Name *</label>
                                    <input type="text" id="MiddleName" name="mname" class="form-control form-control-sm" pattern="[a-zA-Z ñÑ]+">
                                </div>
                                {{-- First name --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="FirstName" class="col-form-label col-form-label-sm">First Name *</label>
                                    <input type="text" id="FirstName" name="fname" class="form-control form-control-sm" pattern="[a-zA-Z ñÑ]+" required>
                                </div>
                                {{-- Maiden name --}}
                                <div class="col-md-6  form-group">
                                    <label for="MaidenName" class="col-form-label col-form-label-sm">Maiden Name (<i><small>for Married Women</small></i>)</label>
                                    <input type="text" id="MaidenName" name="mdname" class="form-control form-control-sm " pattern="[a-zA-Z ñÑ]+">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Birth Date --}}
                                <div class="col-md-6  form-group">
                                    <label for="BDate" class="col-form-label col-form-label-sm">Birth Date *</label>
                                    <input type="date" id="BDate" name="bdate" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Birth Place --}}
                                <div class="col-md-6  form-group">
                                    <label for="BPlace" class="col-form-label col-form-label-sm">Birth Place *</label>
                                    <input type="text" id="BPlace" name="bplace" class="form-control form-control-sm" required>
                                </div>
                                {{-- Sex --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="Sex" class="col-form-label col-form-label-sm">Sex *</label>
                                    <select name="sex" id="Sex" class="form-control form-control-sm" required>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                    </select>
                                </div>
                                {{-- Civil Status --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="CivilStatus" class="col-form-label col-form-label-sm">Civil Status *</label>
                                    <select name="cStatus" id="CivilStatus" class="form-control form-control-sm" required>
                                        <option value="1">SINGLE</option>
                                        <option value="2">MARRIED</option>
                                        <option value="3">WIDOWED</option>
                                        <option value="4">SEPERATED</option>
                                        <option value="5">OTHERS</option>   
                                    </select>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="card-header text-center">
                            Permanent Address & Other Information
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                {{-- Street & Barangay --}}
                                <div class="col-md-6  form-group">
                                    <label for="strtbrgy" class="col-form-label col-form-label-sm">Street & Barangay  *</label>
                                    <input type="text" id="strtbrgy" name="strtbrgy" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Town/City/Municipality --}}
                                <div class="col-md-6  form-group">
                                    <label for="townCM" class="col-form-label col-form-label-sm">Town/City/Municipality *</label>
                                    <input type="text" id="townCM" name="towncm" class="form-control form-control-sm" required>
                                </div>
                                {{-- Province --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="Province" class="col-form-label col-form-label-sm">Province *</label>
                                    <input type="text" id="Province" name="province" class="form-control form-control-sm" required>
                                </div>
                                {{-- Zip Code --}}
                                <div class="col-md-6  form-group">
                                    <label for="Zip" class="col-form-label col-form-label-sm">Zip Code *</label>
                                    <input type="text" id="Zip" name="zip" class="form-control form-control-sm " pattern="[0-9]{4}" required>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Citizenship --}}
                                <div class="col-md-6  form-group">
                                    <label for="citizenship" class="col-form-label col-form-label-sm">Citizenship  *</label>
                                    <input type="text" id="citizenship" name="citizenship" class="form-control form-control-sm" pattern="[a-zA-Z ñÑ]+" required>                                    
                                </div>
                                {{-- Tribal Membership --}}
                                <div class="col-md-6  form-group">
                                    <label for="tribe" class="col-form-label col-form-label-sm">Tribal Membership (<i><small>if applicable</small></i>)</label>
                                    <input type="text" id="tribe" name="tribe" class="form-control form-control-sm" required>
                                </div>
                                {{-- Mobile --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="Mobile" class="col-form-label col-form-label-sm">Mobile Number * (11-digit)</label>
                                    <input type="text" id="Mobile" name="mobile" class="form-control form-control-sm" pattern="09[0-9]{9}" required>
                                </div>
                                {{-- Email --}}
                                <div class="col-md-6  form-group">
                                    <label for="Email" class="col-form-label col-form-label-sm">Email *</label>
                                    <input type="email" id="Email" name="email" class="form-control form-control-sm " required>
                                </div>                        
                            </div>
                            <div class="row">
                                {{-- Disability --}}
                                <div class="col-md-6  form-group">
                                    <label for="disability" class="col-form-label col-form-label-sm">Disability (<i><small>if applicable</small></i>)</label>
                                    <input type="text" id="disability" name="disability" class="form-control form-control-sm ">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>

                {{-- Page 2 --}}
                <div class="carousel-item">
                    <div class="card">
                        <div class="card-header text-center">
                            Educational Background
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                {{-- Last School Attended --}}
                                <div class="col-md-6  form-group">
                                    <label for="last_school" class="col-form-label col-form-label-sm">Last School Attended *</label>
                                    <input type="text" id="last_school" name="last_school" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- School ID Number --}}
                                <div class="col-md-6  form-group">
                                    <label for="school_id" class="col-form-label col-form-label-sm">School ID Number *</label>
                                    <input type="text" id="school_id" name="sc_id" class="form-control form-control-sm" required>
                                </div>
                                {{-- School Address --}}
                                <div class="col-md-6  form-group">                                                
                                    <label for="School Address" class="col-form-label col-form-label-sm">School Address *</label>
                                    <input type="text" id="School Address" name="school_add" class="form-control form-control-sm" required>
                                </div>
                                {{-- School Sector --}}
                                <div class="col-md-6  form-group">
                                    <label for="school_sec" class="col-form-label col-form-label-sm">School Sector *</label>
                                    <select name="school_sec" id="school_sec" class="form-control form-control-sm" required>
                                        <option value="1">PUBLIC</option>
                                        <option value="2">PRIVATE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Highest Grade/Year/Level Achieved --}}
                                <div class="col-md-6  form-group">
                                    <label for="highest_year_level" class="col-form-label col-form-label-sm">Highest Attained Grade/Year/Level *</label>
                                    <input type="text" id="highest_year_level" name="hyl" class="form-control form-control-sm" required>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center">
                            Family Background
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <label>Your father is: </label>
                                    <div class="form-check form-check-inline ml-2">
                                        <input class="form-check-input" type="radio" id="fstate1" name="fstate" value="living" checked>
                                        <label class="form-check-label" for="fstate1">Living</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="fstate2" name="fstate" value="deceased">
                                        <label class="form-check-label" for="fstate2">Deceased</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- Father's Name --}}
                                <div class="col-md-6  form-group">
                                    <label for="fathers_name" class="col-form-label col-form-label-sm">Father's Name *</label>
                                    <input type="text" id="fathers_name" name="fathers_name" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Father's Address --}}
                                <div class="col-md-6  form-group">
                                    <label for="fathers_add" class="col-form-label col-form-label-sm">Father's Address *</label>
                                    <input type="text" id="fathers_add" name="fathers_add" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Father's Occupation --}}
                                <div class="col-md-6  form-group">
                                    <label for="fathers_occ" class="col-form-label col-form-label-sm">Father's Occupation *</label>
                                    <input type="text" id="fathers_occ" name="fathers_name" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Father's Educational Attainment --}}
                                <div class="col-md-6  form-group">
                                    <label for="fathers_educ" class="col-form-label col-form-label-sm">Educational Attainment *</label>
                                    <input type="text" id="fathers_educ" name="fathers_educ" class="form-control form-control-sm" required>                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <label>Your mother is: </label>
                                    <div class="form-check form-check-inline ml-2">
                                        <input class="form-check-input" type="radio" id="mstate1" name="mstate" value="living" checked >
                                        <label class="form-check-label" for="mstate1">Living</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="mstate2" name="mstate" value="deceased">
                                        <label class="form-check-label" for="mstate2">Deceased</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- Mother's Name --}}
                                <div class="col-md-6  form-group">
                                    <label for="mothers_name" class="col-form-label col-form-label-sm">Mother's Name *</label>
                                    <input type="text" id="mothers_name" name="mothers_name" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Mother's Address --}}
                                <div class="col-md-6  form-group">
                                    <label for="mothers_add" class="col-form-label col-form-label-sm">Mother's Address *</label>
                                    <input type="text" id="mothers_add" name="mothers_add" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Mother's Occupation --}}
                                <div class="col-md-6  form-group">
                                    <label for="mothers_occ" class="col-form-label col-form-label-sm">Mother's Occupation *</label>
                                    <input type="text" id="mothers_occ" name="mothers_name" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Mother's Educational Attainment --}}
                                <div class="col-md-6  form-group">
                                    <label for="mothers_educ" class="col-form-label col-form-label-sm">Educational Attainment *</label>
                                    <input type="text" id="mothers_educ" name="mothers_educ" class="form-control form-control-sm" required>                                    
                                </div>
                            </div>

                            <div class="row">
                                {{-- Total Parent's Income --}}
                                <div class="col-md-6  form-group">
                                    <label for="p_income" class="col-form-label col-form-label-sm">Parent's Gross Income *</label>
                                    <input type="number" step="1" min="0" id="p_income" name="p_income" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- Number of Siblings --}}
                                <div class="col-md-6  form-group">
                                    <label for="siblings" class="col-form-label col-form-label-sm">Number of Siblings *</label>
                                    <input type="number" id="siblings" name="siblings" step="1" min="0" class="form-control form-control-sm" required>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>

                {{-- Page 3 --}}
                <div class="carousel-item">
                    <div class="card">
                        <div class="card-header text-center">
                            {{-- Documentary Requirements --}}Additonal Information
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                {{-- Street & Barangay --}}
                                <div class="col-12 col-md-6 form-group">
                                    <label for="school_name2" class="col-form-label col-form-label-sm">School Intended to enroll or enrolled in: *</label>
                                    <input type="text" id="school_name2" name="school_name2" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- School Address --}}
                                <div class="col-12 col-md-6 form-group">
                                    <label for="school_add2" class="col-form-label col-form-label-sm">School Address *</label>
                                    <input type="text" id="school_add2" name="school_add2" class="form-control form-control-sm" required>                                    
                                </div>
                                {{-- School Sector2 --}}
                                <div class="col-12  col-md-6 form-group">
                                    <label for="school_sec2" class="col-form-label col-form-label-sm">Type of School *</label>
                                    <select name="school_sec2" id="school_sec2" class="form-control form-control-sm" required>
                                        <option value="1">PUBLIC</option>
                                        <option value="2">PRIVATE</option>
                                    </select>
                                </div>
                                {{-- Degree Program  --}}
                                <div class="col-12 col-md-6 form-group">
                                    <label for="current_course2" class="col-form-label col-form-label-sm">Degree Program *</label>
                                    <input type="text" id="current_course2" name="current_course2" class="form-control form-control-sm" required>                                    
                                </div>  
                            </div>
                            <hr>
                            <p class="text-center">Are you enjoying other educational financial assistance? If yes, please specify.</p>
                            <div class="row">
                                <div class="col-md-3 col-12 form-group">
                                    <label for="osc_type1" class="col-form-label col-form-label-sm">Type of Scholarship</label>
                                    <select name="osc_type[]" id="osc_type1" class="form-control form-control-sm">
                                        <option value="Government">GOVERNMENT</option>
                                        <option value="Private">PRIVATE</option>
                                    </select>
                                </div>
                                <div class="col-md-9 col-12 form-group">
                                    <label for="agencies1" class="col-form-label col-form-label-sm">Grantee Institution/Agency</label>
                                    <input type="text" id="agencies1" name="agencies[]" class="form-control form-control-sm">                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-12 form-group">
                                    <label for="osc_type2" class="col-form-label col-form-label-sm">Type of Scholarship</label>
                                    <select name="osc_type[]" id="osc_type2" class="form-control form-control-sm">
                                        <option value="Government">GOVERNMENT</option>
                                        <option value="Private">PRIVATE</option>
                                    </select>
                                </div>
                                <div class="col-md-9 col-12 form-group">
                                    <label for="agencies2" class="col-form-label col-form-label-sm">Grantee Institution/Agency</label>
                                    <input type="text" id="agencies2" name="agencies[]" class="form-control form-control-sm">                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                {{-- Page 4 --}}
                <div class="carousel-item">
                    <div class="card">
                        <div class="card-header text-center">
                            Upload the following:
                        </div>
                        <div class="card-body px-5">
                                {{-- E-signature --}}                           
                                <div class="col-10 offset-1 form-group">
                                    <label for="eSignature" class="col-form-label col-form-label-sm">Upload e-signature * (PNG file only)</label>
                                    <input type="file" class="form-control form-control-sm" id="eSignature" name="e_Signature" required accept="image/png">
                                </div>
                                {{-- 2x2  Picture--}}
                                <div class="col-10 offset-1 form-group">
                                    <label for="pic2x" class="col-form-label col-form-label-sm">Upload 2x2 picture * (JPG/JPEG file only)</label>
                                    <input type="file" class="form-control form-control-sm" id="pic2x" name="pic2x" required accept="image/jpg,image/jpeg">
                                </div>
                        </div>
                        <div class="card-footer pb-5">
                            <button type="submit" class="btn btn-info float-right">Submit Application Form</button>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev float-left bg-dark" href="#carousel4Form" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next float-righ bg-dark" role="button">
                <span class="carousel-control-next-icon"  aria-hidden="true" ></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </form>
</div>
@endsection

@section('js_area')
    <script type="text/javascript">
        // hide the carousel prev btn on load
        $('.carousel-control-prev').hide();

        $('a.carousel-control-next').on('click', function () {
             var err = false;
            // //get and check all required inputs on the current slide
            // var currentInputs=$("div.active").first().find('input');
            // var inplength=currentInputs.length;
            // for(var i=0; i<inplength; i++){
            //     if(currentInputs[i].checkValidity()===false){
            //         err=true;
            //         currentInputs[i].reportValidity();
            //         break;
            //     }
            // }
            
            //if all required inputs are valid let the carousel slide
            if (!err) {
                $('.carousel-control-next').attr('href', '#carousel4Form');
                $('.carousel-control-next').attr('data-slide', 'next');
            }
        });

        $('.carousel').on('slide.bs.carousel', function () {
            $('.carousel-indicators').hide();
            $('.carousel-control-prev').hide();
            $('.carousel-control-next').hide();
        });

        $('.carousel').on('slid.bs.carousel', function () {
            //check if next/prev button is to be displayed on current slide
            if ($('#carousel4Form ol').children().first().hasClass('active')) {
                $('.carousel-control-prev').hide();
                $('.carousel-control-next').show();
            } else if ($('#carousel4Form ol').children().last().hasClass('active')) {
                $('.carousel-control-next').hide();
                $('.carousel-control-prev').show();
            } else {
                $('.carousel-control-prev').show();
                $('.carousel-control-next').show();
            }
            //prevent the carousel slide to next part when clicking the next button
            $('.carousel-control-next').removeAttr('href');
            $('.carousel-control-next').removeAttr('data-slide');

            $('.carousel-indicators').show();
        });
    </script>
@endsection