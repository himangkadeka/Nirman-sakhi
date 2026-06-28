@extends('layouts.user-app')

@section('title', ' Contact Us')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/contactus.css') }}" /> --}}
    <style>
        .fa-envelope {
            margin-top: 3%;
        }

        .fa-phone {
            margin-top: 3%;
        }

        /* body {
                font-family: 'Roboto', Sans-Serif;
            } */

        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .card-deck {
            width: 970px;
        }

        /* Barak Valley triangle CSS */
    </style>
@endsection


@section('content')

    <!-- start contact us -->
    <section class="contactus">
        <div class="heading">
            <h2>{{ trans('contactus.contact_us') }}</h2>
            <div class="centerHeading"></div>
        </div>
        <div class="contactBox">
            <div class="left">
                <div class="address">
                    <img src="../assets/template/images/pin.png" alt="pin" id="pin">
                    <div class="location">
                        <img src="../assets/template/images/contactus/pin icon.png" alt="">
                        <p><strong>{{ trans('contactus.officeaddress') }}:</strong> <br> {{ trans('contactus.address') }}
                        </p>
                    </div>
                    <div class="email">
                        <img src="../assets/template/images/contactus/email icon.png" alt="">
                        <p><strong>{{ trans('contactus.email') }}:</strong> <br>abocww.board@assam.gov.in</p>
                    </div>
                </div>
            </div>
            <div class="right">
                <iframe class="bocwMap"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15394978.354381913!2d75.16971646939419!3d19.604214011932672!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375a5bd3e7f340c5%3A0xb1591812c4135a5f!2sLabour%20Commissioner%3A%20Assam!5e0!3m2!1sen!2sin!4v1732963634532!5m2!1sen!2sin"style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">

                </iframe>
            </div>
        </div>
        <div class="" style="width: 90%; margin:0 auto;">
            <div class="Contact-helpdesk">
                <div>
                    <img src="../assets/template/images/helpdesk.png" alt="">
                    <!-- <h5 class="col-md-12 mt-5">Our Helpdesk Support</h5> -->
                    <h5>{{ trans('helpdesk.our') }} <span>{{ trans('helpdesk.Helpdesk') }}</span>
                        {{ trans('helpdesk.support') }}</h5>
                </div>
                {!! __('helpdesk.helpdeskpara') !!}
                <p>{{ trans('helpdesk.helpdeskpara2') }} <a href="#" data-toggle="modal"
                        data-target="#grievance-modal" class="text-primary">{{ trans('helpdesk.here') }}</a>
                    {{ trans('helpdesk.helpdeskpara22') }}</p>

                <p>
                    <strong>{{ trans('helpdesk.email') }}:</strong> abocww.board@assam.gov.in
                </p>
                {{-- <div class="container" style=" ">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto">

                        </div>
                        <div class="col-12 col-md-auto ml-1" style="font-weight:600;">
                            <span class="text-break"> </span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </section>



    <section class="officerDetails">
        <div class="officer-contact">
            <div class="bocwOfficer">
                <div class="officerbox">
                    <img src="{{ asset('assets/template/images/index/lc.jpg') }}" alt="Image 3">
                    <div>
                        <h2>{{ trans('index.lcname') }}</h2>
                        <div class="arrangedeg">
                            <p>{{ trans('index.lctext') }}</p>
                        </div>
                        <div class="arrangedeg">
                            <p>Email: abocww.board@assam.gov.in</p>
                        </div>
                        {{-- <div  class="arrangedeg">
                        <p>0361-2547406</p>
                    </div> --}}

                    </div>
                </div>
                <div class="officerbox">
                    <img src="../assets/template/images/ishanu.jpg" alt="">
                    <div>
                        <h2>{{ trans('introduction.IshanuShah') }}</h2>
                        <div class="arrangedeg">
                            <p> {{ trans('contactus.ishanushahtext') }}</p>
                        </div>
                        <div class="arrangedeg">
                            <p>Email: abocww.board@assam.gov.in</p>
                        </div>
                        {{-- <div class="arrangedeg">
                            <p> 0361-2547406</p>
                        </div> --}}



                    </div>
                </div>

                {{-- <div class="officerbox">
                    <img src="../assets/template/images/labourinspector.jpg" alt="">
                    <div>
                        <h2> {{ trans('contactus.liname') }}
                        </h2>
                        <div class="arrangedeg">
                            <p> {{ trans('contactus.liaddress') }}

                            </p>
                        </div>
                        <div class="arrangedeg">
                            <p>Email: abocww.board@assam.gov.in</p>
                        </div>




                    </div>
                </div> --}}
            </div>

            <div class="fieldOfficer">
                <div class="div" style="text-align: center;">
                    <h3>List of Offices</h3>
                </div>
                <div class="officer-List">

                    <div style="display: flex; justify-content: flex-end;">
                        <input type="text" id="searchInput" placeholder="Search..." class="form-control my-3"
                            style="width: 200px; font-size: 14px; padding: 5px;" onkeyup="searchTable()">
                    </div>

                    <table class="table table-hover" id="officerTable">



                        <thead>
                            <tr>
                                <th scope="col" class="col-1">S.No</th>
                                <th scope="col" class="col-2">{{ trans('contactus.district') }}</th>
                                <th scope="col" class="col-6">{{ trans('contactus.office') }}</th>
                                <th class="col-3">Address</th>

                            </tr>
                        </thead>
                        <tbody class="box" style="font-family: 'Roboto', sans-serif;font-size:16px;">
                            <tr style=" ">
                                <td scope="row" class="text-center align-middle">1</td>
                                <td class="pl-4 align-middle"> {{ trans('contactus.cachar') }}</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.cachar_office') }}
                                </td>
                                <td>Itakhola, Silchar, Dist:- Cachar, Pin:- 788001
                                </td>

                            </tr>
                            <tr style=" ">
                                <td scope="row" class="text-center align-middle">2</td>
                                <td class="pl-4 align-middle"> {{ trans('contactus.cachar') }}</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.cachar_office2') }}

                                </td>
                                <td>Itakhola, Silchar, Dist:- Cachar, Pin:- 788001</td>

                            </tr>
                            <tr style=" ">
                                <td scope="row" class="text-center align-middle">3</td>
                                <td class="pl-4 align-middle"> {{ trans('contactus.cachar') }}</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.cachar_office3') }}

                                </td>
                                <td>Town-Ward No. 2 (Near the SDO. Office Circle) Pin-788103
                                </td>

                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">4</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.karimganj') }}</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.karimganj_office') }}</td>
                                <td>Main Road, Karimganj, Pin- 788710
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">5</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.karimganj') }}</td>
                                <td class="pl-4 align-middle">{{ trans('contactus.karimganj_office2') }}
                                </td>
                                <td>Main Road, Karimganj, Pin- 788710</td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">6</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hailakandi') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hailakandi_office') }}</td>
                                <td>Pratap Ch. Roy Lane, ( Near head Post office, Hailakandi) P.O. & P.S. Hailakandi, Dist.
                                    Hailakandi. PIN- 788151
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">7</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hailakandi') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.hailakandi_office2') }}
                                </td>
                                <td>Pratap Ch. Roy Lane, ( Near head Post office, Hailakandi) P.O. & P.S. Hailakandi, Dist.
                                    Hailakandi. PIN- 788151</td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">8</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.marigaon') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.morigaon_office') }}
                                </td>
                                <td>Moripachatia, Ward No. 2. Pin 782105
                                </td>


                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">9</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.marigaon') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.morigaon_office2') }}
                                </td>
                                <td>(Jagiroad); Pin 782410
                                </td>


                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">10</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.nagaon') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.nagaon_office') }}</td>
                                <td>Bishnu Nagar, Pin:-782001
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">11</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.nagaon') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.nagaon_office2') }} </td>
                                <td>Dhing Chariali, Dhing, Dist:- Nagaon, Pin:-782123
                                </td>

                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">12</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.kaliabor') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.kaliabor_office') }}</td>
                                <td>P.O.- Kuwaritol, P.S.- Kaliabor, Pin:-782137
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">13</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hojai') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hojai_office') }}
                                </td>
                                <td>Station road, Lanka, 782446, office of the labour officer hojai
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">14</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hojai') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.hojai_office2') }}
                                </td>
                                <td>Station road, Lanka, 782446, office of the labour officer hojai
                                </td>

                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">15</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dimahasao') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dimahasao_office') }}</td>
                                <td>P.O. Haflong, P.S. Haflong. Pin 788819.
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">16</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.karbianglong') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.karbianglong_office') }}</td>
                                <td>Ward No-6, P.O- Bokajan, Dist- Karbi Anglong, Pin- 782480
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">17</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.barpeta') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.barpeta_office') }}
                                </td>
                                <td>Metuakuchi, Sudhakantha Path. opposit Canara Bank. Barpeta PIN 781301
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">18</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.kamruprural') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.kamruprural_office') }}</td>
                                <td>Near APDCL office, PO+PS-Chhaygaon, Dist:- Kamrup, Pin:- 781124
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">19</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.bongaigaon') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.bongaigaon_office') }}</td>
                                <td>P.O. Bongaigaon. Dist. Bongaigaon , PIN-783380

                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">20</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.goalpara') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.goalpara_office') }}</td>
                                <td>J.N. Road, Near Central Bank of India, Opp. Indane Gas agency, P.O. Goalpara, P.S &
                                    Dist. Goalpara, Pin - 783101
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">21</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.goalpara') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.goalpara_office2') }} </td>
                                <td>Rangjuli, Mahajanpara, Pin:- 783130
                                </td>

                            </tr>



                            <tr>
                                <td scope="row" class="text-center align-middle">22</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.nalbari') }}
                                </td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.nalbari_office') }}
                                </td>
                                <td>Chowk Bazar, Nalbari-781334
                                </td>
                            <tr>
                                <td scope="row" class="text-center align-middle">23</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dhubri') }} </td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dhubri_office') }}</td>
                                <td>A.C Das Gupta Road Near Tetultola, P.O+P.S+Dist: Dhubri, Pin Code 783301
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">24</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dhubri') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dhubri_office2') }} </td>
                                <td>2 No. Puber gaon Near Bus Station, P.O.+P.S.-Mancachar, Dist:- South Salmara, Pin-783131
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">25</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dhubri') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dhubri_office3') }}</td>
                                <td>P. O & P. S Bilasipara, Dist. Dhubri (Assam) Pin:- 783348
                                </td>

                            </tr>




                            <tr>
                                <td scope="row" class="text-center align-middle">26</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.kamrupmetro') }} </td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.kamrupmetro_office') }}</td>
                                <td>Shram Bhawan, Dr. B.K. Kakati Road, Ulubari, Guwahati-781007

                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">27</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.rangia') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.rangia_office') }} </td>
                                <td>P.O. Rangia, P.S.-Rangia, Near-Hardutta Birdutta Bhavan, Pin-781354
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">28</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.gossaigaon') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.gossaigaon_office') }}</td>
                                <td>Gossaigaon Tinali, P.O. Gossaigaon, Assam 783360
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">29</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sorbhog') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sorbhog_office') }}</td>
                                <td>Vill: Uttarganakgari, PS & PO: Sorbhog Dist: Barpeta Pin Code: 781317
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">30</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sonitpur') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sonitpur_office') }}</td>
                                <td>W.No. 4, Near Tribani Complex, Kacharigaon, P.O. Tezpur, Dist:- Sonitpur, Pin-784001
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">31</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sonitpur') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.sonitpur_office2') }}
                                </td>
                                <td>Main Road, Near SBI, P.O. Dhekiajuli, Dist:- Sonitpur-Pin-784110
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">32</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.darrang') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.darrang_office') }} </td>
                                <td>Stadium Road, Ward No. 2, P.O. Mangaldoi, Dist:- Darrang, Pin:-784125
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">33</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.udalguri') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.udalguri_office') }}</td>
                                <td>Daily Market Rd, Khoirabari, Assam 784522
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">34</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.lakhimpur') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.lakhimpur_office') }}</td>
                                <td>Ahuchaul Gaon Ward No. 4, P.O:- North Lakhimpur, Pin-787001
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">35</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.lakhimpur') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.lakhimpur_office2') }} </td>
                                <td>Vill- Lothow, P.O- Nowboicha, Pin- 787023
                                </td>

                            </tr>




                            <tr>
                                <td scope="row" class="text-center align-middle">36</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.biswanathchariali') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.biswanathchariali_office') }}</td>
                                <td>Madhupur (Biswanath Ghat Road) P.O.- Biswanath Chariali, Pin-784176, Dist: Biswanath
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">37</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.biswanathchariali') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.biswanathchariali_office2') }} </td>
                                <td>Near SDO(Civil) Office, Gohpur, Vill-Borghuli P.O. Gohpur, Pin:-784168
                                </td>

                            </tr>



                            <tr>
                                <td scope="row" class="text-center align-middle">38</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dibrugarh') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dib_office') }}</td>
                                <td>Jail Road, Near S.P. Office, Dibrugarh, Pin-786001
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">39</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dibrugarh') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dib_office2') }} </td>
                                <td>C/o. AAdieo Music Building, Phatikachowa Abhoipuria, Natun Nagar, Dist:- Dibrugarh,
                                    Pin-785670
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">40</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dibrugarh') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dib_office3') }}</td>
                                <td>Naharkatia, Hazuapathar, Pin-786610, Dist:- Dibrugarh
                                </td>

                            </tr>



                            <tr>
                                <td scope="row" class="text-center align-middle">41</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.jorhat') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.jorhat_office') }}</td>
                                <td>KK Path, Jail Road, Jorhat, Pin-785001
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">42</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.jorhat') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.jorhat_office2') }} </td>
                                <td>Basic Road, Purana Titabor, Titabor, Dist:- Jorhat, Pin:- 785630
                                </td>

                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">43</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.majuli') }} </td>
                                <td class="pl-4  align-middle">{{ trans('contactus.majuli_office') }} </td>
                                <td>Vill:- Garmur, Majuli, Dist:- Jorhat, Pin:- 785104
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">44</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.tinsukia_office') }} </td>
                                <td>Tamulbari Road, Near Truck Stand, Tinkonia, Dist:- Tinsukia, Pin:- 786125

                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">45</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia_office2') }} </td>
                                <td>NH 15, Rupai Siding, Above SBI ATM, Pincode-786153
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">46</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia_office3') }}
                                </td>
                                <td>Jyoti Nagar, Near Buniyadi Prathamik Vidyalaya, Makum, Pin:- 786170
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">47</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.tinsukia_office4') }}
                                </td>
                                <td>Tamulbari Road, Near Truck Stand, Tinkonia, Dist:- Tinsukia, Pin:- 786125

                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">48</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.tinsukia') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.tinsukia_office5') }}
                                </td>
                                <td>Tamulbari Road, Near Truck Stand, Tinkonia, Dist:- Tinsukia, Pin:- 786125</td>

                            </tr>








                            <tr>
                                <td scope="row" class="text-center align-middle">49</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sivasagar') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sivasagar_office') }}</td>
                                <td>Station Chariali, PIN-785640
                                </td>
                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">50</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sivasagar') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.sivasagar_office2') }}</td>
                                <td>Sivasagar, Netai Road, Near O/O Child Dev. Project Officer, Demow. P.O. & P.S. Demow,
                                    Pin- 785662.
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">51</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.sivasagar') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.sivasagar_office3') }}</td>
                                <td>Jaykhamdang , Molagaon Road , P.O. Nazira Dist Sivasagar Pin:-785685.
                                </td>
                            </tr>






                            <tr>
                                <td scope="row" class="text-center align-middle">52</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dhemaji') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dhemaji_office') }}</td>
                                <td>Fire Briged Road, Tulshibari, Ward No. 5, Dhemaji, Pin-787057.
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">53</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.golaghat') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.golaghat_office') }}</td>
                                <td>Citra sen Kakoty Path, Court Road Golaghat, P.O & District Golaghat
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">54</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.charaideo') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.charaideo_office') }}</td>
                                <td>Charaideo Rajadhap P.O. Sonari, District: Charaideo Pin Code: 785690
                                </td>
                            </tr>


                            <tr>
                                <td scope="row" class="text-center align-middle">55</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.lakhimpur') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.lakhimpur_office3') }} </td>
                                <td>Sbi Complex, 1st Floor, Narayanpur, P.O.:- Dikrong, P/S:- Narayanpur, Dist.:- Lakhimpur,
                                    Pin:- 784164
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">56</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.golaghat') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.golaghat_office2') }} </td>
                                <td>Udaynagar, P.O. Bokakhat, District: Golaghat, Pin Code: 785612
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">57</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.karbianglong') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.karbianglong_office2') }} </td>
                                <td>Horilala Basti Road, Rongbin Aklam, Near Rengpoli Hospital, Diphu, P.O. Diphu,
                                    Dist-Karbi-Anglong,Pin-782462
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">58</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.karbianglong') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.karbianglong_office3') }} </td>
                                <td>Horwraghat W.No. -, Near Tearchers Gathering Centre, P.O.Howraghat, Dist:- Karbi
                                    Anglong, Pin-782481
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">59</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.westkarbianglong') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.westkarbianglong_office') }} </td>
                                <td>Dongkamukam P. O, Dongkamukam Dist. West Karbi Anglong Pin-782485
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">60</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.golaghat') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.golaghat_office3') }} </td>
                                <td>Town.- Sarupathar, Padumoni No.1, P.O.- Sarupathar Dist.- Golaghat, Pin.- 785601.
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">61</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dimahasao') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dimahasao_office2') }}</td>
                                <td>P.O. Haflong, P.S. Haflong. Pin 788819.
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">62</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.dimahasao') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.dimahasao_office3') }}</td>
                                <td>P.O. Haflong, P.S. Haflong. Pin 788819.
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">63</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.bajali') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.bajali_office') }}</td>
                                <td>Near Shankardev Sishu Niketan, Bhawanipur- Kayakuchi Road. Bhawanipur. Pin: 781352.
                                    Dist:- Bajali
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">64</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.Kokrajhar') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.Kokrajhar_office') }}
                                </td>
                                <td>Kokrajhar - Monakosha Rd, Kokrajhar Bagicha, Assam 783370
                                </td>

                            </tr>

                            <tr>
                                <td scope="row" class="text-center align-middle">65</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.udalguri') }}</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.udalguri_office2') }}
                                </td>
                                <td>P.O. Mazbat Pin-784507 Dist-Udalguri
                                </td>

                            </tr>
                            <tr>
                                <td scope="row" class="text-center align-middle">66</td>
                                <td class="pl-4  align-middle">{{ trans('contactus.westkarbianglong') }}</td>
                                <td class="pl-4  align-middle"> {{ trans('contactus.westkarbianglong_office2') }}

                                </td>
                                <td>Hamren camp at Rongkhang L. I office, Dongkamukam P. O, Dongkamukam Dist. West Karbi
                                    Anglong Pin-782485
                                </td>

                            </tr>






                        </tbody>
                    </table>
                    <div id="pagination" style="display: flex; justify-content: center; align-items: center; gap: 6px;">
                        <span id="prevPage"
                            style="cursor: pointer; font-size: 14px; font-weight: bold; color: #007bff;">&laquo;
                            Previous</span>
                        <span id="pageNumbers" style="font-size: 14px; font-weight: 500; color: #555;"></span>
                        <span id="nextPage"
                            style="cursor: pointer; font-size: 14px; font-weight: bold; color: #007bff;">Next
                            &raquo;</span>
                    </div>




                </div>
            </div>
        </div>
    </section>
    <!-- end contact us -->



@endsection


@section('footer')
    <script>
        const rowsPerPage = 8; // Number of rows per page
        let currentPage = 1;

        const table = document.getElementById('officerTable');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function displayRows() {
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = 'none';
            }

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            for (let i = start; i < end && i < rows.length; i++) {
                rows[i].style.display = '';
            }

            updatePaginationControls();
        }

        function updatePaginationControls() {
            document.getElementById('pageNumbers').innerText = `Page ${currentPage} of ${totalPages}`;

            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        document.getElementById('prevPage').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                displayRows();
            }
        });

        document.getElementById('nextPage').addEventListener('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                displayRows();
            }
        });

        // Initial display
        displayRows();
    </script>

    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("officerTable");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) { // Skip header row
                let td = tr[i].getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerText.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }
    </script>

@endsection
