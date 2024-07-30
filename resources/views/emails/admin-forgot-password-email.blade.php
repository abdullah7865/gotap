@extends('emails.layout')

@section('content')
    {{-- @include('emails.partials.header') --}}
    <tbody>
        <tr>
            <td style="height:35px;"></td>
        </tr>
        <tr>
            <td style="font-size:20px; font-weight:800; text-align:center"> Hello! </td>
        </tr>
        <tr>
            <td style="height:10px;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                <p style="font-size:14px;margin:0 0 10px 0;">
                <h2 style="font-weight:normal;margin:0">
                    You are receiving this email because we received a password reset request for your account.
                </h2>
                </p>
            </td>
        </tr>
        <tr>
            <td style="height:35px;"></td>
        </tr>
        <tr>
            <td style="font-size:20px; font-weight:800; text-align: center">
                <a href="{{ request()->getSchemeAndHttpHost() . '/reset-password/' . $url }}"
                    style="
                    background-color: #3f79d0; border: none;
                    color: white; padding: 15px 32px; text-align: center;
                    text-decoration: none; display: inline-block;
                    font-size: 16px;  margin: 4px 2px; cursor: pointer;">
                    Reset Password
                </a>
            </td>
        </tr>
    </tbody>

    {{-- @include('mail.partials.table_footer') --}}
@endsection
