<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('frontend/mail/style.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <table class="container" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td class="content">
                    <img src="{{ asset('frontend/mail/images/logo1.png') }}" alt="Logo">
                    <h2>Welcome Mighty Eagle!!</h2>
                    <p>Dear {{ $name }}</p>
                    <p>Thank you for completing the registration process on our portal. Your account is now active and
                        ready to use.</p>
                    <p>If you have any questions or need further assistance, please don't hesitate to contact our
                        support team. </p>
                </td>
            </tr>
        </table>
    </div>
    <script>
        setTimeout(function() {
            var content = document.querySelector('.content');
            content.classList.add('show-content');
        }, 500);
    </script>
</body>

</html>
