<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style type="text/css">
        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        #outlook a {
            padding: 0;
        }

        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background-color: #ffffff;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
        }

        table table table {
            table-layout: auto;
        }

        table td {
            border-collapse: collapse;
        }

        table p {
            margin: 0;
        }

        img {
            height: auto !important;
            line-height: 100%;
            outline: none;
            text-decoration: none !important;
            -ms-interpolation-mode: bicubic;
        }

        br,
        strong br,
        b br,
        em br,
        i br {
            line-height: 100%;
        }

        div,
        p,
        a,
        li,
        td {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            line-height: 100% !important;
            -webkit-font-smoothing: antialiased;
        }

        span a,
        a {
            text-decoration: none !important;
        }

        .yshortcuts,
        .yshortcuts a,
        .yshortcuts a:link,
        .yshortcuts a:visited,
        .yshortcuts a:hover,
        .yshortcuts a span {
            text-decoration: none !important;
            border-bottom: none !important;
        }

        /*mailChimp class*/
        .default-edit-image {
            height: 20px;
        }

        ul {
            padding-left: 10px;
            margin: 0;
        }

        .tpl-repeatblock {
            padding: 0px !important;
            border: 1px dotted rgba(0, 0, 0, 0.2);
        }

        .tpl-content {
            padding: 0px !important;
        }


        @media only screen and (max-width:640px) {

            .full-width,
            .container {
                width: 95% !important;
                float: none !important;
                min-width: 95% !important;
                max-width: 95% !important;
                margin: 0 auto !important;
                padding-left: 15px;
                padding-right: 15px;
                text-align: center !important;
                clear: both;
            }

            #mainStructure,
            #mainStructure .full-width .full-width,
            table .full-width .full-width,
            .container .full-width {
                width: 100% !important;
                float: none !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin: 0 auto !important;
                clear: both;
                padding-left: 0;
                padding-right: 0;
            }

            .no-pad {
                padding: 0 !important;
            }

            .full-block {
                display: block !important;
            }

            .image-full-width,
            .image-full-width img {
                width: 100% !important;
                height: auto !important;
                max-width: 100% !important;
            }

            .full-width.fix-800 {
                min-width: auto !important;
            }

            .remove-block {
                display: none !important;
            }

            .pad-lr-20 {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }

        @media only screen and (max-width:480px) {

            .full-width,
            .container {
                width: 95% !important;
                float: none !important;
                min-width: 95% !important;
                max-width: 95% !important;
                margin: 0 auto !important;
                padding-left: 15px;
                padding-right: 15px;
                text-align: center !important;
                clear: both;
            }

            #mainStructure,
            #mainStructure .full-width .full-width,
            table .full-width .full-width,
            .container .full-width {
                width: 100% !important;
                float: none !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin: 0 auto !important;
                clear: both;
                padding-left: 0;
                padding-right: 0;
            }

            .no-pad {
                padding: 0 !important;
            }

            .full-block {
                display: block !important;
            }

            .image-full-width,
            .image-full-width img {
                width: 100% !important;
                height: auto !important;
                max-width: 100% !important;
            }

            .full-width.fix-800 {
                min-width: auto !important;
            }

            .remove-block {
                display: none !important;
            }

            .pad-lr-20 {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }

        td ul {
            list-style: initial;
            margin: 0;
            padding-left: 20px;
        }

        body {
            background-color: #ffffff;
            margin: 0 auto !important;
        }

        .default-edit-image {
            height: 20px;
        }

        tr.tpl-repeatblock,
        tr.tpl-repeatblock>td {
            display: block !important;
        }

        .tpl-repeatblock {
            padding: 0px !important;
            border: 1px dotted rgba(0, 0, 0, 0.2);
        }

        @media only screen and (max-width: 640px) {
            .row {
                display: table-row !important;
            }

            .image-100-percent {
                width: 100% !important;
                height: auto !important;
                max-width: 100% !important;
                min-width: 124px !important;
            }
        }

        @media only screen and (max-width: 480px) {
            .row {
                display: table-row !important;
            }
        }

        *[x-apple-data-detectors],
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .im {
            color: inherit !important;
        }

        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        img.g-img+div {
            display: none !important;
        }

        a img {
            border: 0 !important;
        }

        a:active {
            color: initial
        }

        a:visited {
            color: initial
        }

        span a {
            color: inherit;
        }

        .tpl-content {
            padding: 0 !important;
        }

        table td,
        table th {
            border-collapse: collapse;
            display: table-cell !important;
        }

        table,
        td,
        th,
        img {
            min-width: 0 !important;
        }

        #mainStructure {
            padding: 0 !important;
        }

        span,
        p {
            display: inline !important;
        }

        .row {
            display: flex;
        }
    </style>
</head>
<body>
    <!-- <h3>{{$title}}</h3> -->
    <div style="margin: 10px;">{!! $themessage !!}</div>
    <!-- <div>Click <span style="color: blue;"><a href="{{$link}}">here</a></span> to verifiy your account</div> -->
</body>
</html>

