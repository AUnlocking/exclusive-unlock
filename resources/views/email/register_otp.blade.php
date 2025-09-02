<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{$site_title}} - Account Activation</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body
    style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    "
  >
    <div
      style="
        max-width: 680px;
        margin: 20px auto;
        padding: 45px 30px 60px;
        background: rgb(244,247,255);
        background: linear-gradient(0deg, rgba(244,247,255,1) 0%, rgba(244,247,255,1) 50%, rgba(52,58,64,1) 50%, rgba(52,58,64,1) 100%);
        background-repeat: no-repeat;
        background-position: top center;
        font-size: 14px;
        border-radius: 10px;
      "
    >
      <header>
        <div style="font-size: 30px; text-align: center; font-weight: 500; color:#ffffff; text-transform:uppercase">
            {{$site_title}}
        </div>
      </header>

      <main>
        <div
          style="
            margin: 0;
            margin-top: 50px;
            padding: 92px 30px 115px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
          "
        >
          <div style="width: 100%; max-width: 489px; margin: 0 auto;">
            <h1
              style="
                margin: 0;
                font-size: 24px;
                font-weight: 500;
                color: #1f1f1f;
              "
            >
            Account Activation
            </h1>
            <p
              style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                letter-spacing: 0.56px;
              "
            >
            Use the following OTP to activate your account. The OTP will expire in 5 minutes. If the OTP expires, please submit a new registe request.
            </p>
            <p style="font-size: 20px; font-weight:500;">
                {{$otp}}
            </p>
          </div>
        </div>

        <p
          style="
            max-width: 400px;
            margin: 0 auto;
            margin: 60px auto 45px auto;
            text-align: center;
            font-weight: 500;
            color: #8c8c8c;
          "
        >
        Need help? Reach out to us on the following social media platforms:
        </p>
      </main>

      <footer
        style="
        width: 100%;
        max-width: 490px;
        margin: 20px auto 0;
        padding-top: 20px;
        text-align: center;
        border-top: 1px solid #e6ebf1;
        "
      >
        <p style="margin: 0; margin-top: 16px; color: #434343;">
          © {{date('Y')}} {{$site_title}}.
        </p>
        <p style="margin: 0; color: #434343; font-size: 11px;">
          Powered by GSM Theme
        </p>
      </footer>
    </div>
  </body>
</html>
