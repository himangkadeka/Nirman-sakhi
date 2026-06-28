<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aadhar Consent</title>
    <style>
        .audio-player {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        .play-btn {
            background-color: #f05545;
            border-radius: 50%;
            height: 50px;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .play-btn:hover {
            background-color: #d94c3c;
        }

        .play-btn i {
            color: white;
            font-size: 20px;
        }

        .audio-wrapper {
            flex-grow: 1;
            margin-left: 15px;
        }

        .player-controls {
            display: flex;
            align-items: center;
            width: 100%;
            flex-direction: column;
        }

        .seek {
            width: 100%;
            margin: 10px 0;
            -webkit-appearance: none;
            background: linear-gradient(to right, #f05545, #e0e0e0);
            height: 5px;
            border-radius: 5px;
        }

        .seek::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: #f05545;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        }

        .seek::-moz-range-thumb {
            width: 15px;
            height: 15px;
            background: #f05545;
            border-radius: 50%;
            cursor: pointer;
        }

        .time-display {
            display: flex;
            justify-content: space-between;
            width: 100%;
            color: #333;
            font-size: 14px;
        }

        .start-time,
        .end-time {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Aadhaar Terms &
                        Conditions</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="english-tab" data-bs-toggle="tab"
                                data-bs-target="#english" type="button" role="tab" aria-controls="english"
                                aria-selected="true">English</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="assamese-tab" data-bs-toggle="tab" data-bs-target="#assamese"
                                type="button" role="tab" aria-controls="assamese"
                                aria-selected="false">অসমীয়া</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="english" role="tabpanel"
                            aria-labelledby="english-tab">
                            <p>
                            <h6>Click on the play button to hear audio consent</h6>
                            <div class="audio-player">
                                <div id="play-btn" class="play-btn">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </div>
                                <div class="audio-wrapper" id="player-container">
                                    <audio id="player" preload="none" ontimeupdate="updateProgressBar()">
                                        <source
                                            src="{{ URL::asset('assets/template/audioconsent/aadhaar_consent_audio.mp3') }}"
                                            type="audio/mp3">
                                    </audio>
                                </div>
                                <div class="player-controls">
                                    <input id="seekObj" type="range" min="0" step="0.25" value="0"
                                        onchange="seekAudio()" oninput="seekAudio()" class="seek">
                                    <div class="time-display">
                                        <small class="start-time"></small>
                                        <small class="end-time" onclick="toggleRemaining()"></small>
                                    </div>
                                </div>
                            </div>
                            <ol>

                                <li>I understand that my Aadhaar number, biometric
                                    information and/or One-Time Password (OTP) and
                                    demographic information, as understood under the
                                    Aadhaar (Targeted Delivery of Financial and Other
                                    Subsidies, Benefits and Services) Act, 2016 and
                                    regulations framed thereunder, is being collected by
                                    the Assam Building and Other Construction Workers
                                    Welfare Board(ABOCWWB) for the following purposes:
                                </li>
                                <ol type="a">
                                    <li>Authenticating my identity by way of the Aadhaar
                                        number authentication system</li>
                                    <li>Registering on the Nirman Sakhi Portal for Assam
                                        Building and Other Construction Worker’s ID and
                                        for availing benefits under the Building and
                                        Other Construction Workers Act 1996;</li>
                                    <li>Seeding of Aadhaar number with my bank account;
                                    </li>
                                    <li>Assessing my status of “Unorganised” worker and
                                        eligibility across Government programmes run by
                                        the Assam Building and Other Construction
                                        Workers’ Welfare Board under the Building and
                                        Other Construction Workers Act 1996, or other
                                        similar welfare programmes run by other
                                        Departments/Ministries of the Central Government
                                        and State Governments;</li>
                                    <li>Delivering the benefits of various schemes of
                                        Departments/Ministries of Union and State
                                        Governments framed for welfare of citizens;</li>
                                    <li>Sharing of my Aadhaar number and demographic
                                        information with other Departments/Ministries of
                                        the Central Government, State Governments and
                                        local bodies for formulation or implementation
                                        of suitable welfare scheme(s);</li>
                                    <li>Cross-verifying the collected Aadhaar number and
                                        associated identity information with the
                                        Aadhaar-seeded database of other
                                        Departments/Ministries of the Central Government
                                        and State Governments associated with the
                                        welfare scheme(s);</li>
                                    <li>Measuring trends related to disbursement and
                                        effectiveness of social welfare benefits and
                                        services and improving the quality of such
                                        benefits and services;</li>
                                    <li>Resolving security or technical issues
                                        associated with disbursement of social welfare
                                        benefits and services;</li>
                                    <li>Strengthening digital platforms to ensure good
                                        governance and preventing dissipation of social
                                        welfare benefits;</li>
                                    <li>Detecting, preventing, and otherwise addressing
                                        malpractices and harmful conduct associated with
                                        disbursement of social welfare benefits and
                                        services; and</li>
                                    <li>All such purposes incidental thereto.</li>
                                </ol>
                                <li>I understand that the Assam Building and Other
                                    Construction Workers’ Welfare Board shall create an
                                    Aadhaar-seeded database containing my Aadhaar
                                    number, biometric and/or One-Time Password (OTP) and
                                    demographic information for all or any of the
                                    purposes enlisted in paragraphs 1 (a)-(l) of this
                                    consent form, that the Assam Building and Other
                                    Construction Workers’ Welfare Board shall ensure
                                    that requisite mechanisms have been put in place to
                                    ensure safety, security and privacy of such
                                    information in accordance with applicable laws and
                                    regulations and the Assam Building and Other
                                    Construction Workers’ Welfare Board shall not share
                                    my biometric information with anyone for any reason
                                    whatsoever, or use it for any purpose other than
                                    authentication.</li>
                                <li>I understand that in case of failure to authenticate
                                    due to illness, injury or infirmity owing to old age
                                    or otherwise or any technical reasons, the Assam
                                    Building and Other Construction Workers’ Welfare
                                    Board shall allow the following alternate means of
                                    identification for availing benefits under the BOCW
                                    act 1996:
                                    <ol type="a">
                                        <li>Voter ID card;</li>
                                        <li>Ration card;</li>
                                        <li>Passport;</li>
                                        <li>Driving License;</li>
                                        <li>Any Photo Identity Card issued by the
                                            Central Government, State Governments, or
                                            Union Territory Administrations; Certificate
                                            of identity with photograph issued by a
                                            Gazetted Officer on an official letterhead.
                                        </li>
                                    </ol>
                                </li>
                                <li>I have no objection to authenticating myself with
                                    Aadhaar based authentication system and give my
                                    consent to provide my Aadhaar Number, biometric
                                    information and/ or One- Time password (OTP) and
                                    demographic information for Aadhaar based
                                    authentication for the purposes enlisted in
                                    paragraphs 1 (a)-(l) of this consent form and for
                                    creation of an Aadhaar-seeded database as described
                                    in Paragraph 2 of this consent form.</li>
                            </ol>
                            </p>
                        </div>

                        <div class="tab-pane fade" id="assamese" role="tabpanel" aria-labelledby="assamese-tab">
                            <p>
                            <ol>
                                <li>মই বুজি পাইছো যে মোৰ আধাৰ নম্বৰ, বায়’মেট্ৰিক তথ্য আৰু/ অথবা এককালীন পাছৱৰ্ড (অ’ টি পি) আৰু জনগাঁথনিগত তথ্য যিসমূহ আধাৰ (লক্ষ্য নিৰ্ধাৰিত বিত্তীয় আৰু অন্যান্য ৰাজসাহায্য লাভালাভ আৰু সেৱা প্ৰদান) আইন, ২০১৬ আৰু ইয়াৰ অধীনত যুগুতোৱা অধিনিয়মৰ অধীনত অসম গৃহ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদৰ দ্বাৰা নিন্মোক্ত উদ্দেশ্যৰ বাবে সংগ্ৰহ কৰিছে।
                                </li>
                                <ol type="a">
                                    <li>আধাৰ নম্বৰৰ প্ৰামাণিক ব্যৱস্থাৰ দ্বাৰা মোৰ পৰিচয় প্ৰামাণিকৰণ।</li>
                                    <li>অসম গৃহ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিকৰ আই ডি আৰু গৃহ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক আইন, ১৯৯৬ৰ অধীনত সেৱা উপলব্ধৰ বাবে নিৰ্মাণ সখী প’ৰ্টেলত পঞ্জীয়ন।</li>
                                    <li>মোৰ বেংক একাউণ্টৰ সৈতে আধাৰ নম্বৰ সংযোগকৰণ।
                                    </li>
                                    <li>অসংগঠিত শ্ৰমিক হিচাপে মোৰ স্থিতি আৰু গৃহ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক আইন, ১৯৯৬ৰ অধীনত অসম গৃহ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদৰ দ্বাৰা পৰিচালিত চৰকাৰী কাৰ্যসূচী বা কেন্দ্ৰীয় চৰকাৰ বা ৰাজ্য চৰকাৰৰ দ্বাৰা পৰিচালিত একে ধৰণৰ অন্যান্য কল্যাণমূলক কাৰ্যসূচীৰ বাবে যোগ্যত পৰীক্ষা কৰাৰ বাবে;</li>
                                    <li>নাগৰিকৰ কল্যাণৰ উদ্দেশ্যে কেন্দ্ৰীয় আৰু ৰাজ্য চৰকাৰৰ অধীনৰ বিভাগ/মন্ত্ৰালয়ে গ্ৰহণ কৰা বিভিন্ন আঁচনিৰ লাভালাভ আগবঢ়োৱাৰ বাবে;</li>
                                    <li>উপযুক্ত কল্যামমূলক আঁচনি/আঁচনিসমূহ প্ৰস্তুত বা ৰূপায়ণ কৰাৰ উদ্দেশ্যে কেন্দ্ৰীয় চৰকাৰ, ৰাজ্য চৰকাৰ আৰু স্থানীয় নিকায়ৰ অন্যান্য বিভাগ/মন্ত্ৰালয়ক মোৰ আধাৰ নম্বৰ আৰু জনগাঁথনি সম্পৰ্কীয় তথ্য জনোৱাৰ বাবে;</li>
                                    <li>কল্যাণমূলক আঁচনিসমূহৰ সৈতে জড়িত কেন্দ্ৰীয় চৰকাৰ আৰু ৰাজ্য চৰকাৰৰ অন্যান্য বিভাগ/মন্ত্ৰালয়সমূহৰ আধাৰসংলগ্ন ডাটাবেছৰ সৈতে সংগ্ৰহ কৰা আধাৰ নম্বৰ আৰু সংশ্লিষ্ট পৰিচয়ৰ তথ্য তন্ন তন্নকৈ পৰীক্ষা কৰাৰ বাবে;</li>
                                    <li>সমাজ কল্যাণমূলক লাভালাভ আৰু সেৱাসমূহৰ বিতৰণ আৰু ফলপ্ৰসূতাৰ সৈতে জড়িত ধাৰাসমূহ অনুধাৱন কৰা আৰু এনে সুবিধা আৰু সেৱাসমূহৰ মান উন্নত কৰাৰ বাবে;</li>
                                    <li>সমাজ কল্যাণমূলক সুবিধা আৰু সেৱাসমূহৰ বিতৰণৰ সৈতে জড়িত সুৰক্ষা বা কাৰিকৰী সমস্যাসমূহ সমাধান কৰাৰ বাবে;</li>
                                    <li>সুশাসন নিশ্চিত কৰিবলৈ আৰু সমাজ কল্যাণৰ সুবিধাসমূহৰ অসৎ ব্যৱহাৰ ৰোধ কৰিবলৈ ডিজিটেল প্লেটফৰ্মসমূহ শক্তিশালী কৰাৰ বাবে;</li>
                                    <li>সমাজ কল্যাণমূলক সুবিধা আৰু সেৱাসমূহৰ বিতৰণৰ সৈতে জড়িত অসৎ আচৰণ আৰু ক্ষতিকাৰক আচৰণ ধৰা পেলোৱা, প্ৰতিৰোধ কৰা আৰু অন্যথা সমাধান কৰাৰ বাবে; আৰু</li>
                                    <li>ইয়াৰ লগত জড়িত এনে সকলো উদ্দেশ্য।</li>
                                </ol>
                                <li>মই বুজি পাইছো যে অসম গৃহ নিৰ্মাণ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদে এই সন্মতি প্ৰ-পত্ৰৰ দফা ১(ক)-(I)ত তালিকাভুক্ত সকলো বা যিকোনো উদ্দেশ্যৰ বাবে মোৰ আধাৰ নম্বৰ, বায়’মেট্ৰিক আৰু/বা এককালীন পাছৱৰ্ড (অ’ টি পি) আৰু জনগাঁথনিগত তথ্য থকা আধাৰ সংযুক্ত ডাটাবেছ সৃষ্টি কৰিব লাগিব, যে অসম গৃহ নিৰ্মাণ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদে প্ৰযোজ্য হৈ থকা বিধি আৰু নিয়মাৱলী অনুসৰি এনে ধৰণৰ তথ্যৰ সুৰক্ষা আৰু গোপনীয়তা সুনিশ্চিত কৰিবলৈ প্ৰয়োজনীয় ব্যৱস্থা গ্ৰহণ কৰা হৈছে বুলি নিশ্চিত কৰিব লাগিব। লগতে অসম গৃহ নিৰ্মাণ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদে কোনো কাৰণতে কোনো ব্যক্তিক মোৰ বায়’মেট্ৰিক তথ্যখিনি প্ৰদান নকৰাটো নাইবা ব্যৱহাৰ নকৰাটোও নিশ্চিত কৰিব লাগিব। অৱশ্যে প্ৰমাণীকৰণৰ ক্ষেত্ৰত ই ব্যতিক্ৰম হ’ব।</li>
                                <li>মই বুজি পাইছো যে বাৰ্ধক্য বা অন্য কোনো কাৰণত বা কোনো কাৰিকৰী কাৰণত অসুস্থতা, আঘাত বা অলৰ-অচৰ অৱস্থাৰ বাবে প্ৰমাণীকৰণত ব্যৰ্থ হ’লে অসম গৃহ নিৰ্মাণ আৰু অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ পৰিষদে Bocw আইন, ১৯৯৬ৰ অধীনত সুবিধা লাভৰ বাবে চিনাক্তকৰণৰ ক্ষেত্ৰত নিম্নলিখিত বিকল্প উপায়সমূহত অনুমতি প্ৰদান কৰিব :
                                    <ol type="a">
                                        <li> ভোটাৰ পৰিচয়-পত্ৰ</li>
                                        <li>ৰেচন কাৰ্ড</li>
                                        <li>পাছপ’ৰ্ট</li>
                                        <li>ড্ৰাইভিং লাইচেঞ্চ</li>
                                        <li>কেন্দ্ৰীয় চৰকাৰ, ৰাজ্য চৰকাৰ বা কেন্দ্ৰীয় শাসিত অঞ্চল প্ৰশাসনে প্ৰদান কৰা যিকোনো ফটো পৰিচয়-পত্ৰ; চৰকাৰী লেটাৰ হেডত ৰাজপত্ৰিত বিষয়া এগৰাকীয়ে প্ৰদান কৰা ফটো সম্বলিত পৰিচয় প্ৰমাণ-পত্ৰ।
                                        </li>
                                    </ol>
                                </li>
                                <li>আধাৰভিত্তিক প্ৰমাণীকৰণ ব্যৱস্থাৰে মোৰ তথ্য পৰীক্ষণৰ ক্ষেত্ৰত মোৰ কোনো আপত্তি নাই আৰু এই সন্মতি প্ৰ-পত্ৰৰ দফা ১ (ক)-(I)ত তালিকাভুক্ত উদ্দেশ্যৰ বাবে আধাৰভিত্তিক প্ৰমাণীকৰণৰ অৰ্থে মোৰ আধাৰ নম্বৰ, বায়’মেট্ৰিক তথ্য আৰু/নাইবা এককালীন পাছৱৰ্ড (অ’ টি পি) আৰু জনগাঁথনিগত তথ্য প্ৰদান কৰিবলৈ মই সন্মতি প্ৰদান কৰিলো আৰু লগতে এই সন্মতি প্ৰ-পত্ৰৰ দফা ২ ত উল্লেখ কৰা আধাৰ সংযুক্ত ডাটাবেছ সৃষ্টিৰ বাবেও সন্মতি প্ৰদান কৰিলো।</li>
                            </ol>
                            </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="understand" type="button" class="btn btn-primary" data-bs-dismiss="modal">I agree | মই
                        মানি লওঁ</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var player = document.getElementById("player");
        var seek = document.getElementById("seekObj");
        var isSeeking = false;

        document.getElementById("play-btn").addEventListener("click", function() {
            if (player.paused) {
                player.play();
                this.querySelector('i').classList.replace("fa-play", "fa-pause");
            } else {
                player.pause();
                this.querySelector('i').classList.replace("fa-pause", "fa-play");
            }
        });

        function seekAudio() {
            player.currentTime = seek.value;
        }

        function updateProgressBar() {
            if (!isSeeking) {
                seek.max = player.duration;
                seek.value = player.currentTime;
            }

            document.querySelector(".start-time").textContent = formatTime(player.currentTime);
            document.querySelector(".end-time").textContent = formatTime(player.duration);
        }

        function formatTime(seconds) {
            var minutes = Math.floor(seconds / 60);
            var sec = Math.floor(seconds % 60);
            return (minutes < 10 ? "0" : "") + minutes + ":" + (sec < 10 ? "0" : "") + sec;
        }

        function toggleRemaining() {
            this.classList.toggle("end-time");
            this.classList.toggle("rem-time");
        }

        player.addEventListener("ended", function() {
            var playBtn = document.getElementById("play-btn");
            playBtn.querySelector('i').classList.replace("fa-pause", "fa-play");
        });

        $('#termsModal').on('hidden.bs.modal', function () {
            player.pause();
            player.currentTime = 0;
            var playBtn = document.getElementById("play-btn");
            playBtn.querySelector('i').classList.replace("fa-pause", "fa-play");
        });

        player.addEventListener("timeupdate", updateProgressBar);
    </script>
</body>

</html>
