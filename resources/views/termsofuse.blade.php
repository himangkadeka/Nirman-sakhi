@extends('layouts.user-app')

@section('title', ' Terms of Use')
@section('style')

    <style>
        body {
            font-family: 'Roboto', Sans-Serif;
            font-size:16px;
        }
    </style>

@endsection


@section('content')
    <div class="container mt-3" id="b-homedb">

        <h3 style="text-align: center; font-family:'Roboto', Sans-Serif; ">
            {{ trans('termsofuse.termsofuse') }}
        </h3>


        <div class=" mt-4 " style="text-align: justify;">
            {!! __('termsofuse.termsofusebody') !!}
            {{-- <p class="" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                <strong>Disclaimer </strong>
            </p>
            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                This web portal is designed, developed, and hosted by Assam Building and Construction
                Worker Welfare Board (ABOCWWB) and maintained by National Informatic Center (NIC),
                Government of India. The contents of this website are for information purpose only,
                enabling workers and public to have an easy access to information and services provided.
            </p>
            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                Though all efforts have been made to ensure the accuracy and currency of the content on
                this Portal, the same should not be construed as a statement of law or used for any legal
                purposes. ABOCWWB accepts no responsibility in relation to the accuracy, completeness,
                usefulness or otherwise, of the contents and does not take responsibility on how this
                information is used or the consequence of its use. In case of any inconsistency/ confusion,
                Users are advised to verify/check any information with the concerned section officer of
                ABOCWWB and relevant Government department(s) and/or other source(s), and to obtain
                any appropriate professional advice and clarification before acting on the information
                provided in the Portal.
            </p>
            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                In no event will the Government or NIC be liable for any expense, loss or damage including,
                without limitation, indirect or consequential loss or damage, or any expense, loss or damage
                whatsoever arising from use, or loss of use, of data, arising out of or in connection with the
                use of this Portal. Links to other websites that have been included on this Portal are
                provided for public convenience only. NIC is not responsible for the contents or reliability of
                linked websites and does not necessarily endorse the view expressed within them. We do
                not always guarantee the availability of such linked pages.
            </p>
            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                Material featured on this Portal may be reproduced free of charge after taking proper
                permission by sending a mail to us. However, the material has to be reproduced accurately
                and not to be used in a derogatory manner or in a misleading context. Wherever the
                material is being published or issued to others, the source must be prominently
                acknowledged. However, the permission to reproduce this material shall not extend to any
                material which is identified as being copyright of a third party. Authorisation to reproduce
                such material must be obtained from the departments/copyright holders concerned.
            </p>
            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                These terms and conditions shall be governed by and construed in accordance with the
                Indian Laws. Any dispute arising under these terms and conditions shall be subject to the
                exclusive jurisdiction of the courts of India/ Assam.
            </p>

            <p class="mt-3" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                <strong>Privacy Policy </strong>
            </p>
            <p class="" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                This Portal does not automatically capture any specific personal information from you, (like
                name, phone number or e-mail address), that allows us to identify you individually. If the
                Portal requests you to provide personal information, you will be informed for the purposes
                for which the information is collected, and adequate security measures will be taken to
                protect your personal information. Any information provided to this Portal will be protected
                from loss, misuse, unauthorized access or disclosure, alteration, or destruction. We gather
                certain information about the user, such as Internet protocol (IP) addresses, domain name,
                browser type, operating system, the date and time of the visit and the pages visited. We
                make no attempt to link these addresses with the identity of individuals visiting our site
                unless an attempt to damage the site has been detected.
            </p>

            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                <strong>Linking Policy </strong>
            </p>
            <p style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                Links to external websites/portals
            </p>
            <div class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                At many places in this Portal, you shall find links to other websites/portals. This links has
                been placed for your convenience. ABOCWWB is not responsible for the contents and
                reliability of the linked websites and does not necessarily endorse the views expressed in
                them. Mere presence of the link or its listing on this Portal should not be assumed as
                endorsement of any kind. We cannot guarantee that these links will work all the time and
                we have no control over availability of linked pages.
            </div>

            <p class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                <strong>Links to this Portal by other websites </strong>
            </p>
            <p class="" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                We do not object to you linking directly to the information that is hosted on this Portal and
                no prior permission is required for the same. However, we would like you to inform us about
                any links provided to this Portal so that you can be informed of any changes or update
                therein. Also, we do not permit our pages to be loaded into frames on your site. The pages
                belonging to this Portal must load into a newly opened browser window of the User.
            </p>

            <div class="my-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                <strong>Suggestions and Queries</strong>
            </div>
            <p class="" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                We welcome your suggestions to improve our site and request that any inconsistency / error
                found may kindly be brought to our notice at 'email ID'.
            </p> --}}

        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
