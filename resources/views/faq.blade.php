@extends('layouts.user-app')

@section('title', 'FAQs')

@section('style')
    <style>
        /*@import url(https://fonts.googleapis.com/css?family=Raleway);*/

        body {
            color: #333;
            background: #fcfcfc;
            font-family: 'Roboto', Sans-Serif;
            overflow-x: hidden;

        }

        .faq-header {
            font-size: 20px;
            border-bottom: 1px dotted #ccc;
            padding: 24px;
            text-align: center;
            font-family: 'Roboto', Sans-Serif;
        }

        .faq-content {
            margin: 0 auto;
            max-width: 1500px;
            font-family: 'Roboto', Sans-Serif;

        }

        .faq-question {
            padding: 10px 100px;
            /* Reduced padding */
            border-bottom: 1px dotted #ccc;
            position: relative;
            font-family: 'Roboto', Sans-Serif;

        }


        .panel-title {
            font-size: 20px;
            /* Adjusted font size */
            width: 100%;
            position: relative;
            padding: 5px 10px 0 48px;
            font-family: 'Roboto', Sans-Serif;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .panel-content {
            font-size: 16px;
            /* Adjusted font size */
            padding: 0 10px;
            font-family: 'Roboto', Sans-Serif;
            margin: 0 40px;
            height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .panel:checked+.panel-title+.panel-content {
            height: auto;
            opacity: 1;
            padding: 10px;
            /* Adjusted padding */
        }

        .plus {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            font-size: 24px;
            /* Adjusted font size */
            line-height: 100%;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s ease;
        }

        .panel:checked+.panel-title .plus {
            transform: rotate(45deg);
        }

        .panel-title,
        .panel-content {
            font-size: 15px;
            font-family: 'Roboto', Sans-Serif;
        }

        .panel {
            position: absolute;
            left: 0;
            opacity: 0;
            z-index: -1;
        }

        .faq-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Center the image vertically */
        }

        .faq-image {
            height: 300px;
            /* Set height to 300px */
            max-width: none;
            /* Remove max-width to avoid restriction */
            margin-left: 20px;
        }
    </style>
@endsection

@section('content')

    <div class="faq-header" style="font-family:'Roboto',Sans-Serif">{{ trans('faq.faq') }} <div
            style="display: flex; align-items: center; justify-content: center;" class="mt-3"><img
                src="{{ asset('assets/template/images/faq/faq.png') }}" alt="FAQ Image" class="faq-image" style="height: 150px">
        </div>
    </div>
    <div class="faq-container">
        <div class="faq-content">
            <div class="faq-question ">
                <input id="q1" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q1" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question" style="font-family:'Roboto',Sans-Serif">1. {{ trans('faq.q1') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a1') }}</div>
            </div>

            <div class="faq-question">
                <input id="q2" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q2" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">2.{{ trans('faq.q2') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a2-1') }}
                    <a href = "https://www.abocwwb.assam.gov.in" class="text-primary">www.abocwwb.assam.gov.in</a>
                    {{ trans('faq.a2-2') }}
                </div>
            </div>

            <div class="faq-question">
                <input id="q3" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q3" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">3. {{ trans('faq.q3') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a3-1') }} <a href = "https://www.abocwwb.assam.gov.in"
                        class="text-primary"> www.abocwwb.assam.gov.in</a>
                    {{ trans('faq.a3-2') }}
                    <a href = "https://www.abocwwb.assam.gov.in" class="text-primary">
                        www.abocwwb.assam.gov.in</a>
                    {{-- {{ trans('faq.a3-3') }} --}}
                </div>
            </div>
            <div class="faq-question">
                <input id="q4" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q4" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">4.
                        {{ trans('faq.q4') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a4') }}</div>
            </div>
            <div class="faq-question">
                <input id="q5" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q5" class="panel-title">
                    <div class="plus">+</div>5.
                    {{ trans('faq.q5') }}
                </label>
                <div class="panel-content">{{ trans('faq.a5') }}</div>
            </div>
            <div class="faq-question">
                <input id="q6" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q6" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">6.
                        {{ trans('faq.q6') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a6') }}</div>
            </div>
            <div class="faq-question">
                <input id="q7" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q7" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">7.
                        {{ trans('faq.q7') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a7') }}</div>
            </div>
            <div class="faq-question">
                <input id="q8" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q8" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">8.
                        {{ trans('faq.q8') }}</p>
                </label>
                <div class="panel-content">
                    <p>{{ trans('faq.a8-1') }}<a href="https://www.ABOCWWB.assam.gov.in/en/about/pfcdetails " class="text-primary">www.abocwwb.assam.gov.in {{ trans('faq.fullstop') }}</a> </p>

                    <p>{{ trans('faq.a8-2') }}<a href=" https://sewasetu.assam.gov.in/site" class="text-primary"> sewasetu.assam.gov.in</a>
                        {{ trans('faq.a8-3') }}</p>
                </div>
            </div>
            <div class="faq-question">
                <input id="q9" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q9" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">9.
                        {{ trans('faq.q9') }}</p>
                </label>
                <div class="panel-content"><p class="panel-content">
                    <ul>
                        <li> {{ trans('faq.a9-2') }}</li>
                    </ul>
                    </p>
                    <p class="panel-content">
                    <ul>
                        <li>{{ trans('faq.a9-3') }}</li>
                    </ul>
                    </p>
                    <p class="panel-content">
                    <ul>
                        <li>{{ trans('faq.a9-4') }}</li>
                    </ul>
                    </p>
                </div>

            </div>
            <div class="faq-question">
                <input id="q10" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q10" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">10.
                        {{ trans('faq.q10') }}
                    </p>
                </label>
                <div class="panel-content"> {!! __('faq.a10') !!}</div>
            </div>

            <div class="faq-question">
                <input id="q11" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q11" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">11.
                        {{ trans('faq.q11') }}</p>
                </label>
                <div class="panel-content">{{ trans('faq.a11') }}
                    <a href = "https://www.ABOCWWB.assam.gov.in/en/downloads " class="text-primary">www.abocwwb.assam.gov.in {{ trans('faq.fullstop') }} </a>
                </div>
            </div>
            <div class="faq-question">
                <input id="q12" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q12" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">12.
                        {{ trans('faq.q12') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a12') }}</div>
            </div>
            <div class="faq-question">
                <input id="q13" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q13" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">13.
                       {{ trans('faq.q13') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a13') }}</div>
            </div>
            <div class="faq-question">
                <input id="q14" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q14" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">14.
                        {{ trans('faq.q14') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a14') }}</div>
            </div>
            <div class="faq-question">
                <input id="q15" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q15" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">15.
                        {{ trans('faq.q15') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a15') }}</div>
            </div>
            <div class="faq-question">
                <input id="q16" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q16" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">16.
                       {{ trans('faq.q16') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a16') }}</div>
            </div>
            <div class="faq-question">
                <input id="q17" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q17" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">17.
                       {{ trans('faq.q17') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a17') }}</div>
            </div>
            <div class="faq-question">
                <input id="q18" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q18" class="panel-title">
                    <div class="plus">+</div>
                    <p class="question">18.
                        {{ trans('faq.q18') }}
                    </p>
                </label>
                <div class="panel-content">{{ trans('faq.a18') }}</div>
            </div>
            <div class="faq-question">
                <input id="q19" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q19" class="panel-title">
                    <div class="plus">+</div>19.
                    {{ trans('faq.q19') }}
                </label>
                <div class="panel-content">{{ trans('faq.a19') }}</div>
            </div>
            <div class="faq-question">
                <input id="q20" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q20" class="panel-title">
                    <div class="plus">+</div>20.
                   {{ trans('faq.q20') }}
                </label>
                <div class="panel-content">{{ trans('faq.a20') }}</div>
            </div>
            <div class="faq-question">
                <input id="q21" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q21" class="panel-title">
                    <div class="plus">+</div>21.
                    {{ trans('faq.q21') }}
                </label>
                <div class="panel-content">{{ trans('faq.a21') }}</div>
            </div>
            <div class="faq-question">
                <input id="q22" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q22" class="panel-title">
                    <div class="plus">+</div>22.
                    {{ trans('faq.q22') }}
                </label>
                <div class="panel-content">{{ trans('faq.a22') }} <a href = "https://eshram.gov.in/ "
                        class="text-primary">eshram.gov.in {{ trans('faq.fullstop') }} </a>
                </div>
            </div>
            <div class="faq-question">
                <input id="q23" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q23" class="panel-title">
                    <div class="plus">+</div>23.
                    {{ trans('faq.q23') }}
                </label>
                <div class="panel-content">{{ trans('faq.a23') }}
                    <a href = "https://eshram.gov.in/" class="text-primary">eshram.gov.in {{ trans('faq.fullstop') }} </a>
                </div>
            </div>
            <div class="faq-question">
                <input id="q24" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q24" class="panel-title">
                    <div class="plus">+</div>24.
                   {{ trans('faq.q24') }}
                </label>
                <div class="panel-content">{{ trans('faq.a24') }}</div>
            </div>

            <div class="faq-question">
                <input id="q25" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q25" class="panel-title">
                    <div class="plus">+</div>25.
                    {{ trans('faq.q25') }}
                </label>
                <div class="panel-content">{{ trans('faq.a25') }}</div>
            </div>
            <div class="faq-question">
                <input id="q26" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q26" class="panel-title">
                    <div class="plus">+</div>26.
                    {{ trans('faq.q26') }}
                </label>
                <div class="panel-content"> {!! __('faq.a26-1') !!}
                    <a href = "https://www.ABOCWWB.assam.gov.in" class="text-primary">
                        www.abocwwb.assam.gov.in {{ trans('faq.fullstop') }} </a>
                    {!! __('faq.a26-2') !!}
                </div>
            </div>
            <div class="faq-question">
                <input id="q27" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q27" class="panel-title">
                    <div class="plus">+</div>27.
                    {{ trans('faq.q27') }}
                </label>
                <div class="panel-content">{!! __('faq.a27') !!}</div>
            </div>
            <div class="faq-question">
                <input id="q28" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q28" class="panel-title">
                    <div class="plus">+</div>28.
                    {{ trans('faq.q28') }}
                </label>
                <div class="panel-content">{{ trans('faq.a28-1') }}
                    <a href = "https://www.ABOCWWB.assam.gov.in" class="text-primary"> https://www.ABOCWWB.assam.gov.in  {{ trans('faq.fullstop') }}</a>
                      {!! __('faq.a28-2') !!}

                </div>
            </div>
            <div class="faq-question">
                <input id="q29" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q29" class="panel-title">
                    <div class="plus">+</div>
                    29. {{ trans('faq.q29') }}
                </label>
                <div class="panel-content">{{ trans('faq.a29') }}</div>
            </div>

            <div class="faq-question">
                <input id="q30" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q30" class="panel-title">
                    <div class="plus">+</div>30.
                    {{ trans('faq.q30') }}
                </label>
                <div class="panel-content"> {!! __('faq.a30') !!}</div>
            </div>
            <div class="faq-question">
                <input id="q31" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q31" class="panel-title">
                    <div class="plus">+</div>31.
                    {{ trans('faq.q31') }}
                </label>
                <div class="panel-content">{!! __('faq.a31') !!}</div>
            </div>
            <div class="faq-question">
                <input id="q32" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q32" class="panel-title">
                    <div class="plus">+</div>32.
                  {{ trans('faq.q32') }}
                </label>
                <div class="panel-content">{{ trans('faq.a32') }}</div>
            </div>
            <div class="faq-question">
                <input id="q33" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q33" class="panel-title">
                    <div class="plus">+</div>
                    33.  {!! __('faq.q33') !!}
                </label>
                <div class="panel-content"> {!! __('faq.a33') !!}</div>
            </div>
            <div class="faq-question">
                <input id="q34" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q34" class="panel-title">
                    <div class="plus">+</div>
                    34. {!! __('faq.q34') !!}
                </label>
                <div class="panel-content">{!! __('faq.a34') !!}</div>
            </div>
            {{-- <div class="faq-question">
                <input id="q35" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q35" class="panel-title">
                    <div class="plus">+</div>35.
                   {{ trans('faq.q35') }}
                </label>
                <div class="panel-content">{{ trans('faq.a35') }}</div>
            </div> --}}
            <div class="faq-question">
                <input id="q35" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q35" class="panel-title">
                    <div class="plus">+</div>35.
                  {{ trans('faq.q35') }}
                </label>
                <div class="panel-content">{{ trans('faq.a35') }}</div>
            </div>
            <div class="faq-question">
                <input id="q36" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q36" class="panel-title">
                    <div class="plus">+</div>36.
                    {{ trans('faq.q36') }}
                </label>
                <div class="panel-content"> {!! __('faq.a36') !!} </div>
            </div>


            <div class="faq-question">
                <input id="q37" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q37" class="panel-title">
                    <div class="plus">+</div>37.
                   {{ trans('faq.q37') }}
                </label>
                <div class="panel-content">{{ trans('faq.a37') }}</div>
            </div>
            <div class="faq-question">
                <input id="q38" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q38" class="panel-title">
                    <div class="plus">+</div>38.
                   {{ trans('faq.q38') }}
                </label>
                <div class="panel-content">{{ trans('faq.a38') }}</div>
            </div>
            <div class="faq-question">
                <input id="q39" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q39" class="panel-title">
                    <div class="plus">+</div>39.
                    {{ trans('faq.q39') }}
                </label>
                <div class="panel-content">{{ trans('faq.a39') }}</div>
            </div>
            <div class="faq-question">
                <input id="q40" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q40" class="panel-title">
                    <div class="plus">+</div>40.
                    {{ trans('faq.q40') }}
                </label>
                <div class="panel-content">{{ trans('faq.a40') }}</div>
            </div>
            <div class="faq-question">
                <input id="q41" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q41" class="panel-title">
                    <div class="plus">+</div>41.
                    {{ trans('faq.q41') }}
                </label>
                <div class="panel-content">{{ trans('faq.a41') }}</div>
            </div>
            <div class="faq-question">
                <input id="q42" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q42" class="panel-title">
                    <div class="plus">+</div>42.
                    {{ trans('faq.q42') }}
                </label>
                <div class="panel-content">{{ trans('faq.a42') }}</div>
            </div>
            <div class="faq-question">
                <input id="q43" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q43" class="panel-title">
                    <div class="plus">+</div>43.
                    {{ trans('faq.q43') }}
                </label>
                <div class="panel-content">{{ trans('faq.a43') }}</div>
            </div>

            <div class="faq-question">
                <input id="q44" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q44" class="panel-title">
                    <div class="plus">+</div>44.
                    {{ trans('faq.q44') }}
                </label>
                <div class="panel-content">{{ trans('faq.a44') }}</div>
            </div>
            <div class="faq-question">
                <input id="q45" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q45" class="panel-title">
                    <div class="plus">+</div>45.
                    {{ trans('faq.q45') }}
                </label>
                <div class="panel-content">{{ trans('faq.a45') }}</div>
            </div>
            <div class="faq-question">
                <input id="q46" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q46" class="panel-title">
                    <div class="plus">+</div>46.
                    {{ trans('faq.q46') }}
                </label>
                <div class="panel-content">{{ trans('faq.a46') }}</div>
            </div>
            <div class="faq-question">
                <input id="q47" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q47" class="panel-title">
                    <div class="plus">+</div>47.
                   {{ trans('faq.q47') }}
                </label>
                <div class="panel-content">{{ trans('faq.a47') }}</div>
            </div>

            <div class="faq-question">
                <input id="q48" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q48" class="panel-title">
                    <div class="plus">+</div>48.
                    {{ trans('faq.q48') }}
                </label>
                <div class="panel-content">{{ trans('faq.a48') }} <a href="https://www.ABOCWWB.assam.gov.in" class="text-primary">https://www.ABOCWWB.assam.gov.in {{ trans('faq.fullstop') }} </a>  </div>
            </div>
            <div class="faq-question">
                <input id="q49" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q49" class="panel-title">
                    <div class="plus">+</div>49.
                   {{ trans('faq.q49') }}
                </label>
                <div class="panel-content">{{ trans('faq.a49') }}</div>
            </div>
            <div class="faq-question">
                <input id="q50" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q50" class="panel-title">
                    <div class="plus">+</div>50.
                    {{ trans('faq.q50') }}
                </label>
                <div class="panel-content">{{ trans('faq.a50') }}</div>
            </div>
            <div class="faq-question">
                <input id="q51" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q51" class="panel-title">
                    <div class="plus">+</div>51.
                   {{ trans('faq.q51') }}
                </label>
                <div class="panel-content">{{ trans('faq.a51') }}</div>
            </div>
            <div class="faq-question">
                <input id="q52" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q52" class="panel-title">
                    <div class="plus">+</div>52.
                   {{ trans('faq.q52') }}
                </label>
                <div class="panel-content">{{ trans('faq.a52') }}</div>
            </div>
            <div class="faq-question">
                <input id="q53" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q53" class="panel-title">
                    <div class="plus">+</div>53.
                   {{ trans('faq.q53') }}
                </label>
                <div class="panel-content">{{ trans('faq.a53') }}
                    <a href = "https://www.ABOCWWB.assam.gov.in/en/benefits " class="text-primary">www.abocwwb.assam.gov.in {{ trans('faq.fullstop') }} </a>
                </div>
            </div>
            <div class="faq-question">
                <input id="q54" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q54" class="panel-title">
                    <div class="plus">+</div>54.
                    {{ trans('faq.q54') }}
                </label>
                <div class="panel-content"> {!! __('faq.a54')!!}</div>

            </div>
            <div class="faq-question">
                <input id="q55" type="checkbox" class="panel" onclick="togglePanel(this)">
                <label for="q55" class="panel-title">
                    <div class="plus">+</div>55.
                    {{ trans('faq.q55') }}
                </label>
                <div class="panel-content">{{ trans('faq.a55') }}</div>
            </div>

        </div>


    </div>

    <script>
        function togglePanel(currentCheckbox) {
            // Get all checkboxes
            const panels = document.querySelectorAll('.panel');

            // Loop through all checkboxes to close them except the current one
            panels.forEach(panel => {
                if (panel !== currentCheckbox) {
                    panel.checked = false; // Uncheck the other checkboxes
                }
            });
        }
    </script>
@endsection

@section('footer')
@endsection
