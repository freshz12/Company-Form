@extends('layouts.main')
@section('container')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <form action="/updateform" method="post">
        @csrf
        <div id="mainbodyaddform">
            <br>

            <div id="carding">
                <div class="card">
                    <div class="card-header">
                        {{-- {{ $formData['company_name'] }} --}}
                        FR0001
                    </div>
                </div>

                <br>

                {{-- Company Details --}}
                <div class="card">
                    <div class="card-header">
                        Company Details
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">
                            <input type="hidden" name="id" class="form-control" value="" required>
                            <div class="col">
                                <label for="">Company Name </label>
                                <input type="text" class="form-control" value="" placeholder="Company Name"
                                    required>
                            </div>

                            <div class="col">
                                <label for="">HQ Office Address </label>
                                <input type="text" name="hq" class="form-control" value=""
                                    placeholder="HQ Office Address" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Company Website </label>
                                <input type="text" name="company_website" class="form-control" value=""
                                    placeholder="Company Website" required>
                            </div>

                            <div class="col">
                                <label for="">Country of origin </label>
                                <input type="text" class="form-control" value="" placeholder="Company Name"
                                    required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Year of establishment </label>
                                <input type="number" maxlength="4" min="1900" max="2099" name="year"
                                    value="" class="form-control" placeholder="Year of establishment" required>
                            </div>
                        </div>
                    </div>
                </div>
                <br>





                {{-- Contact Person --}}
                <div class="card">
                    <div class="card-header">
                        Contact Person
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Name </label>
                                <input type="text" name="contact_name" class="form-control" placeholder="Name"
                                    value="" required>
                            </div>

                            <div class="col">
                                <label for="">Designation </label>
                                <input type="text" name="contact_designation" class="form-control" value=""
                                    placeholder="Destignation" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Email Address </label>
                                <input type="text" name="contact_email" class="form-control" value=""
                                    placeholder="Email Address" required>
                            </div>


                            <div class="col">
                                <label for="">Phone Number </label>
                                <input type="text" name="contact_phone" class="form-control" value=""
                                    placeholder="Phone Number" required>
                            </div>

                        </div>

                    </div>
                </div>

                <br>






                {{-- Products Offering --}}
                <div class="card">
                    <div class="card-header">
                        Products Offering
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Type of Products </label>
                                <input type="text" class="form-control" value="" placeholder="Type of Products"
                                    required>
                            </div>

                            <div class="col">
                                <label for="">Care Segment </label>
                                <input type="text" class="form-control" value="" placeholder="Care Segment"
                                    required>
                            </div>


                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Main Products </label>
                                <textarea class="form-control" placeholder="Main Products" required></textarea>
                            </div>

                            <div class="col">
                                <label for="">Presence of distributor </label>
                                <input type="text" class="form-control" value=""
                                    placeholder="Presence of distributor" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Country of interest for distribution <span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control" value=""
                                    placeholder="Country of interest for distribution" required>
                            </div>

                        </div>


                    </div>
                </div>


                <br>

                {{-- Potential Partnetship --}}
                <div class="card">
                    <div class="card-header">
                        Potential Partnership
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">

                        <div class="row">

                            <div class="col">
                                <label for="">Potential Relationship </label>
                                <input type="text" class="form-control" value=""
                                    placeholder="Potential Relationship" required>
                            </div>

                            <div class="col">
                                <label for="">Potential Service offered by Company </label>
                                <input type="text" class="form-control" value=""
                                    placeholder="Potential Service offered by Company" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col" id="other_1">
                                <label for="">Other Potential Relationship </label>
                                <input type="text" class="form-control" placeholder="Other Potential Relationship"
                                    required>
                            </div>

                            <div class="col" id="other_2">
                                <label for="">Other Potential Service offered by Company </label>
                                <input type="text" class="form-control"
                                    placeholder="Other Potential Service offered by Company" required>
                            </div>

                        </div>

                    </div>
                </div>

                <br>


                {{-- Documents File --}}
                <div class="card">
                    <div class="card-header">
                        Documents Files
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Company Profile</label><br><br>
                                <input type="text" class="form-control" value="" placeholder="Company Profile"
                                    required>
                            </div>

                            <div class="col">
                                <label for="">Product Brochure</label><br><br>
                                <input type="text" class="form-control" value="" placeholder="Product Brochure"
                                    required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Other relevant Documents</label><br><br>
                                <input type="text" class="form-control" value=""
                                    placeholder="Other relevant Documents" required>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>
@endsection
