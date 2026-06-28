@extends('layouts.user-app')

@section('title', ' SOP & GUIDELINES(Reviewing the Applications)')
@section('style')

    <style>
        body {
            font-family: 'Roboto', Sans-Serif;
        }
    </style>

@endsection


@section('content')
    <div class="container mt-5" id="b-homedb">



        <div class=" mt-4 " style="text-align: justify;">

            <p class="" style="text-align: center;">
                <strong>SoP for reviewing New registration applications</strong>
            </p>
            <ol class="my-2">
                <li>Please check whether the application is submitted to the correct office based on the address
                    provided by worker. If not, please forward the application with necessary comments to the
                    rerouting office.</li>
                <li>After ensuring that the application is made to the correct office, match the name, and DoB of
                    the applicant with the name mentioned in all documents. In case of mismatch, revert the
                    application with necessary comments for providing the correct documents.</li>
                <li>Check whether quality of the uploaded documents is sufficient for verification. If not, please
                    revert the application with necessary comments with name of the documents to be re-
                    uploaded. In such cases, revert the application with necessary comments, and select the
                    concerned error of PFC for reverting.</li>
                <li>Ensure that the concerned documents are uploaded under their own field (Ex: mistake of
                    uploading bank account proof under address proof and vice versa). In such cases, revert the
                    application with necessary comments, and select the concerned error of PFC for reverting.</li>
                <li>Match the current / present address in the application with the address proof uploaded. In case
                    of mismatch, revert the application with necessary comments for providing the correct
                    documents, and select the concerned error of PFC for reverting.</li>
                <li>Match the issuer type and the issuer mentioned in the registration form (online form) with the
                    issuer type and the issuer mentioned on the 90-day experience certificate. If there is a
                    mismatch, revert the application with necessary comments for providing the correct documents,
                    and select the concerned error of PFC for reverting.</li>
                <li>Match the photo of the applicant on the 90-day experience certificate with the photo in the
                    application form. In case of mismatch, revert the application with necessary comments, and
                    select the concerned error of PFC for reverting.</li>
                <li>Check every field of the 90-day experience certificate for correctness and completeness. If it’s
                    found incorrect or incomplete, revert the application with necessary comments for uploading
                    correct certificate.</li>
                <li>Check whether the employment mentioned in the work certificate / workbook is construction
                    related work. If not, revert the application with necessary comments for providing the correct
                    documents.</li>
                <li>Verify the details from the employers (mentioned in the experience certificate) to confirm the
                    authenticity of the construction related work experience of the applicant.</li>
                <li>If the employer phone no is not a valid no, revert the application for providing the experience
                    certificate with updated phone number.</li>
                <li>If the mobile no is found to be not of the employer (as mentioned in the experience certificate),
                    revert the application for providing the experience certificate with updated phone number.</li>
                <li>If the certification is found to be wrong, revert the application with necessary comments for
                    uploading the correct certificate.</li>
                <li>If the 90-day certificate is found to be fake, reject the application with necessary comments /
                    observations.</li>
                <li>In case of any other crucial information found fake regarding the eligibility criteria, reject the
                    application with necessary comments / observations.</li>

            </ol>
<br>
            <p class="" style="text-align: center;">
                <strong>SoP for reviewing Onboarding applications</strong>
            </p>
            <ol class="my-2">
                <li>Match the name and DoB of the applicant with the name and DoB already existing in the
                    database. In case the DoB is matching and the name is not matching, the application can be
                    accepted by updating the name as per Aadhaar data.</li>
                <li>In case both name and DoB are not matching, reject the application with necessary comments.</li>
                <li>Match the name and DoB of the applicant with the name mentioned in all documents. In case of
                    mismatch, revert the application with necessary comments for providing the correct documents.</li>
                <li>Check whether quality of the uploaded documents is sufficient for verification. If not, please
                    revert the application with necessary comments with name of the documents to be re-
                    uploaded. In such cases, revert the application with necessary comments, and select the
                    concerned error of PFC for reverting.</li>
                <li>Ensure that the concerned documents are uploaded under their own field (Ex: mistake of
                    uploading DOB proof under address proof and vice versa). In such cases, revert the application
                    with necessary comments, and select the concerned error of PFC for reverting.</li>
                <li>Match the face of the applicant on the ABOCW ID card with the photo on application form. In
                    case of mismatch, revert the application with necessary comments for correction.</li>
                <li>Match the current / present address in the application with the address proof uploaded. In case
                    of mismatch, revert the application with necessary comments for providing the correct
                    documents.</li>
                <li>Verify the last subscription payment date entered by the applicant with the date mentioned on
                    the subscription payment receipt. If it’s not matching, correct the subscription date as per the
                    date on the subscription receipt.</li>
                <li>Verify the ID card validity date entered by the applicant with the date mentioned on the ABOCW
                    ID card. If it’s not matching, correct the subscription date as per the date on the ABOCW ID card.</li>
                <li>In case of any other crucial information found fake regarding the eligibility criteria, reject the
                    application with necessary comments / observations.</li>
            </ol>
<br>
            <p class="" style="text-align: center;">
                <strong>SoP for reviewing Renewal applications</strong>
            </p>
            <ol class="my-2">
                <li>Match the name and DoB of the applicant with the name mentioned in all documents. In case of
                    mismatch, revert the application with necessary comments for providing the correct documents.</li>
                <li>Check whether quality of the uploaded documents is sufficient for verification. If not, please
                    revert the application with necessary comments with name of the documents to be re-
                    uploaded. In such cases, revert the application with necessary comments, and select the
                    concerned error of PFC for reverting.</li>
                <li>Ensure that the concerned documents are uploaded under their own field (Ex: mistake of
                    uploading DOB proof under address proof and vice versa). In such cases, revert the application
                    with necessary comments, and select the concerned error of PFC for reverting.</li>
                <li>Match the photo of the applicant on the ABOCW ID card with the photo on application form. In
                    case of mismatch, revert the application with necessary comments for correction.</li>
                <li>Match the current / present address in the application with the address proof uploaded. In case
                    of mismatch, revert the application with necessary comments for providing the correct
                    documents.</li>
                <li>Match the photo of the applicant on the workbook (working record book) with the photo in the
                    application form. In case of mismatch, revert the application with necessary comments, and
                    select the concerned error of PFC for reverting.</li>
                <li>Check every field of the workbook for correctness and completeness. If it’s found incorrect or
                    incomplete, revert the application with necessary comments for uploading corrected workbook.</li>
                <li>Check whether the details mentioned in the application for are matching with the uploaded
                    workbook. In case of mismatch, revert the application with necessary comments, and select the
                    concerned error of PFC for reverting.</li>
                <li>Check whether the employment mentioned in the work certificate / workbook is construction
                    related work. If not, revert the application with necessary comments for providing the correct
                    documents.</li>
                <li>If the beneficiary has missed the renewal dates (not renewed the membership for several
                    years), the workbook must have work experience details for these periods to continue as a
                    beneficiary.</li>
                <li>Check whether the employment mentioned in the work certificate / workbook is construction
                    related work. If not, revert the application with necessary comments for providing the correct
                    documents.</li>
                <li>Verify the details from the employers (mentioned in the experience certificate) to confirm the
                    authenticity of the construction related work experience of the applicant.</li>
                <li>If the employer phone no is not a valid no, revert the application for providing the experience
                    certificate with updated phone number.</li>
                <li>If the mobile no is found to be not of the employer (as mentioned in the experience certificate),
                    revert the application for providing the experience certificate with updated phone number.</li>
                <li>If the workbook details are found to be wrong, revert the application with necessary comments
                    for uploading the correct certificate.</li>
                <li>If the workbook details are found to be fake, reject the application with necessary comments /
                    observations.</li>
                <li>In case of any other crucial information found fake regarding the eligibility criteria, reject the
                    application with necessary comments / observations.</li>
            </ol>
           
        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
