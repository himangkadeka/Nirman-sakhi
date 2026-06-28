@extends('layouts.user-app')

@section('title', " About Us | Who's who")
@section('style')

    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/members_of_the_board.css') }}" />




@endsection


@section('content')
    <div id="b-homedb">

        <div class="container">
            {{-- <div class="row mt-4">
                <div class="col text-center">
                    <h2>Who’s Who of the Board</h2>
                </div>
            </div> --}}




            <div class="container mt-3 text-center">

                <div class="heading">
                    <h2>{{ trans('members_of_the_board.head1') }}</h2>
                    <div class="centerHeading"></div>
                </div>



            </div>





            <div class="row m-3">
                <div class="table-responsive custom-table">
                    <table class="table shadow-lg">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans('members_of_the_board.name') }}</th>
                                <th scope="col" class="text-center">{{ trans('members_of_the_board.role') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="member-info">
                                        <span class="member-name">{{ trans('members_of_the_board.ministername') }}</span>
                                        <span
                                            class="member-position">{{ trans('members_of_the_board.ministertext') }}</span>
                                    </div>
                                </td>
                                <td class="text-center"><span
                                        class="role-badge chairman">{{ trans('members_of_the_board.chairman') }}</span></td>
                            </tr>
                            <tr class="">
                                <td class="col-10">
                                    {{ trans('introduction.csname') }}, {{ trans('introduction.cstext') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('index.lcname') }},
                                    {{ trans('index.lctext') }}</td>
                                <td class="text-center">{{ trans('members_of_the_board.MemberSecretary') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.seniorsecretaryfinance') }}</td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.seniorsecretaryLegislative') }} </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.seniorsecretaryPWD') }} </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.DeputyChiefLabourCommissioner') }}</td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="row mt-4">
                <div class="col text-center">
                    <h2>Employer’s Representatives

                    </h2>
                </div>
            </div> --}}

            <div class="container mt-3">
                <div class="heading">
                    <h2>{{ trans('members_of_the_board.head2') }}

                    </h2>
                    <div class="centerHeading"></div>
                </div>
            </div>





            <div class="row m-3">
                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans('members_of_the_board.name') }}</th>
                                <th scope="col" class="text-center">{{ trans('members_of_the_board.role') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td> {{ trans('members_of_the_board.CommissionerGMC') }} </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }} </td>
                            </tr>
                            <tr class="2">
                                <td> {{ trans('members_of_the_board.ChiefEngineerPWD') }} </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.ChiefEngineerMetropolitan') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="2">
                                <td class="col-10">{{ trans('members_of_the_board.arieda') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.BhanitaMedhi') }},
                                    {{ trans('members_of_the_board.SocialWorker') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="row mt-4">
                <div class="col text-center">
                    <h2>Employee’s Representatives

                    </h2>
                </div>
            </div> --}}

            <div class="container mt-3">
                <div class="heading">
                    <h2>{{ trans('members_of_the_board.head3') }}</h2>
                    <div class="centerHeading"></div>

                </div>

            </div>


            <div class="row m-3 pb-2">
                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"class="text-center" style="font-family:'Roboto',Sans-Serif;">
                                    {{ trans('members_of_the_board.name') }}</th>
                                <th scope="col" class="text-center" style="font-family:'Roboto',Sans-Serif;">
                                    {{ trans('members_of_the_board.role') }}</th>
                            </tr>
                        </thead>
                        <tbody style="font-family: 'Roboto', sans-serif;">
                            <tr class="">
                                <td>{{ trans('members_of_the_board.SadouAsomNirmanSramikUnion') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.INTUC') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.president_aacwu') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td class="col-10">{{ trans('members_of_the_board.president_asc&awu') }}
                                </td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }}</td>
                            </tr>
                            <tr class="">
                                <td>{{ trans('members_of_the_board.PresidentBhartiyaMazdoorSangha') }}</td>
                                <td class="text-center">{{ trans('members_of_the_board.member') }} </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')
@endsection

<style>
    .custom-table {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin: 25px 0;
    }

    .custom-table table {
        margin-bottom: 0;
    }

    .custom-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .custom-table thead th {
        color: #fff;
        font-weight: 600;
        padding: 18px 25px;
        border: none;
        font-family: 'Roboto', Sans-Serif;
        font-size: 1.1rem;
    }

    .custom-table tbody tr {
        transition: all 0.3s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f8f9ff;
        transform: translateY(-2px);
    }

    .custom-table tbody td {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
        font-family: 'Roboto', sans-serif;
    }

    .member-info {
        display: flex;
        flex-direction: column;
    }

    .member-name {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .member-position {
        color: #666;
        font-size: 0.9rem;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .role-badge.chairman {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .role-badge.member {
        background-color: rgba(118, 75, 162, 0.1);
        color: #764ba2;
    }

    @media (max-width: 768px) {
        .custom-table {
            border-radius: 10px;
            margin: 15px 0;
        }

        .custom-table thead th,
        .custom-table tbody td {
            padding: 15px;
        }

        .member-name {
            font-size: 0.95rem;
        }

        .member-position {
            font-size: 0.85rem;
        }
    }
</style>
