
<table style="width: 700px; margin: 0 auto; text-align: center; font-family: 'Robot', 'Arial', sans-serif; padding: 0px 60px 60px; background: #FFFFFF; border-radius: 5px; color: #464646;">

    <tr style="">
        <td style="text-align: center; padding: 60px 0 0">
            <!-- <img style="width: 100px; margin: 0 auto;" src="{{ URL::to('/') }}/images/email-logo.png"> -->
            <br />
            <h3 style="text-align: center; margin-top: 15px; font-size: 32px;">Hello!</h3>
        </td>
    </tr>

    <tr>
        <td style="text-align: left; font-size: 18px">
            <p style="line-height: 1.5">
                You have requested a password reset, please follow the link below to reset your password.
            </p><br>
            <center><a href="{{$url}}" class="button" style="display: block; height: 20px; width: auto;">Reset Password</a></center>
            <p>
                Please ignore this email if you did not request a password change.
            </p><br><br>

            <p>Regards,<br>
               (App Name Here)</p>
        </td>
    </tr>

    <tr>
        <td style="text-align: left; font-size: 12px">
            <p style="line-height: 1.5;">
                
            If you’re having trouble clicking the "Reset Password" link, copy and paste the URL below into your web browser: <p>{{$url}}</p>
            </p>
        </td>
    </tr>

</table>