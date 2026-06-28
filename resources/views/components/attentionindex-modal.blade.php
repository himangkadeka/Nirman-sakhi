<div class="modal fade" id="attentionindex-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header"style="background:#ffc107">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: 500"><i
                        class="fa fa-exclamation-circle"></i> {{ trans('index.attentionhead') }}</h5>

            </div>
            <!-- Modal body -->
            <div class="modal-body bg-light p-4">

                <!-- Tab panes -->

                {{-- <p><strong>Free</strong> online Registration, Onboarding and renewal services are available through <strong>Public Facilitation Centres (PFCs)</strong> till <strong>30 April 2025.</strong></p> --}}
                <p><strong>Free</strong> services ( from <strong>23-11-2025</strong> till <strong>30-06-2026</strong> ) include <strong>online form fill-up</strong>, <strong>scanning</strong> of documents, and <strong>printing</strong> of acknowledgement slip and BOCW ID card when availing CSC services through SewaSetu.</p>


                {{-- <p><strong>বিনামূলীয়া</strong> অনলাইন পঞ্জীয়ন, অনবৰ্ডিং আৰু নবীকৰণ সেৱাসমূহৰ জৰিয়তে উপলব্ধ --}}
                    {{-- <strong>ৰাজহুৱা সুবিধা কেন্দ্ৰ (পিএফচি)</strong> <strong> ৩০ এপ্ৰিল ২০২৫ লৈকে।</strong></p> --}}
                    <p><strong>বিনামূলীয়া</strong> সেৱাসমূহৰ ভিতৰত ( <strong>২৩-১১-২০২৫</strong> তাৰিখৰ পৰা <strong>৩০-০৬-২০২৬</strong> তাৰিখলৈকে ) <strong>অনলাইন ফৰ্ম পূৰণ</strong>, নথিপত্ৰসমূহৰ <strong>স্কেনিং</strong>, আৰু সেৱাসেতুৰ জৰিয়তে চি এছ চি সেৱাসমূহ লাভ কৰাৰ সময়ত স্বীকৃতি স্লিপ আৰু বিঅ'চিডব্লিউ আইডি কাৰ্ডৰ <strong>প্ৰিণ্টিং</strong> অন্তৰ্ভুক্ত কৰা হৈছে ।</p>

                {{-- <p> {!! __('index.attention1') !!}</p>
                                <p>{!! __('index.attention2') !!}</p> --}}

                <div class="text-center">
                    <a class="@if (Route::is('home.pfcs.cscdetails')) active @endif" href="{{ route('home.pfcs.cscdetails') }}"
                        style="color: #4874b6; text-decoration: none;  font-size: 16px;"
                        onmouseover="this.style.color='red'; this.style.textShadow='none';"
                        onmouseout="this.style.color='#0c3e89'; this.style.textShadow='none';">
                        {{ trans('index.attentionclick') }}
                    </a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning"
                    onclick="$('#attentionindex-modal').modal('hide');"><i class="fa fa-times-circle"></i>
                    Close</button>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#attentionindex-modal').modal({
            keyboard: true,
            show: false
        });
    });
</script>
