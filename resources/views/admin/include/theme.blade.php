<script>
    function layout_change() {
        var tname = "{{ Auth::check() ? Auth::user()->theme : 'light' }}";
        var control = document.querySelector('.pct-offcanvas');
        var btn_control = document.querySelector('.theme-layout .btn[data-value="default"]');
        if (btn_control) {
            btn_control.classList.remove('active');
        }
        if (tname == 'dark') {
            dark_flag = true;
            if (document.querySelector('.pc-sidebar .m-header .logo-lg')) {
                document.querySelector('.pc-sidebar .m-header .logo-lg').setAttribute('src', '../assets/images/logo-white.svg');
            }
            if (document.querySelector('.navbar-brand .logo-lg')) {
                document.querySelector('.navbar-brand .logo-lg').setAttribute('src', '../assets/images/logo-white.svg');
            }
            if (document.querySelector('.auth-main.v1 .auth-sidefooter')) {
                document.querySelector('.auth-main.v1 .auth-sidefooter img').setAttribute('src', '../assets/images/logo-white.svg');
            }
            if (document.querySelector('.footer-top .footer-logo')) {
                document.querySelector('.footer-top .footer-logo').setAttribute('src', '../assets/images/logo-white.svg');
            }
            var control = document.querySelector('.theme-layout .btn.active');
            if (control) {
                document.querySelector('.theme-layout .btn.active').classList.remove('active');
                document.querySelector(".theme-layout .btn[data-value='false']").classList.add('active');
            }
        } else {
            dark_flag = false;
            if (document.querySelector('.pc-sidebar .m-header .logo-lg')) {
                document.querySelector('.pc-sidebar .m-header .logo-lg').setAttribute('src', '../assets/images/logo-dark.svg');
            }
            if (document.querySelector('.navbar-brand .logo-lg')) {
                document.querySelector('.navbar-brand .logo-lg').setAttribute('src', '../assets/images/logo-dark.svg');
            }
            if (document.querySelector('.auth-main.v1 .auth-sidefooter')) {
                document.querySelector('.auth-main.v1 .auth-sidefooter img').setAttribute('src', '../assets/images/logo-dark.svg');
            }
            if (document.querySelector('.footer-top .footer-logo')) {
                document.querySelector('.footer-top .footer-logo').setAttribute('src', '../assets/images/logo-dark.svg');
            }
            var control = document.querySelector('.theme-layout .btn.active');
            if (control) {
                document.querySelector('.theme-layout .btn.active').classList.remove('active');
                document.querySelector(".theme-layout .btn[data-value='true']").classList.add('active');
            }
        }
    }
    $('.theme-mode').on('click', function() {
        var themeData = $(this).attr('data-value');
        if (themeData == 'true') {
            $('html').attr('data-pc-theme', 'light');
            $(this).addClass('active');
            var themeMode = 'light';
            updateTheme(themeMode);
        } else {
            $('html').attr('data-pc-theme', 'dark');
            $(this).addClass('active');
            var themeMode = 'dark';
            updateTheme(themeMode);
        }
        $('.theme-mode').not(this).removeClass('active');
        function updateTheme(themeMode) {
            $.ajax({
                url: '/admin/update/theme/' + themeMode,
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
            });
        }
    });
    $('.themeColor').on('click', function() {
        var themeData = $(this).attr('data-value');
        $.ajax({
            url: '/admin/update/theme-color/' + themeData,
            type: 'GET',
            beforeSend: function() {
                $('.top-loader').show();
            },
            complete: function() {
                $('.top-loader').hide();
            },
        });
        // $('body').data-pc-preset(themeData);
    });
</script>
