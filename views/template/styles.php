<style>
        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
            **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
            text-align: justify;
            margin-top: 4.5cm;
            margin-left: 3cm;
            margin-right: 2.5cm;
            margin-bottom: 2.25cm;
        }

        body .resolucion{
            margin-left: 1cm;
        }
        body .coactiva{
            margin-left: 0cm !important;
        }
        small {
            font-size: 80%;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            margin: 0 auto;
            text-align: center;
            width: 85%;
            left: 50%;
            margin-left: -37.5%;
        }        

        /** Define the footer rules **/
        footer {

            position: fixed;
            left: 3cm;
            right: 2.5cm;
            height: 2.5cm;
            bottom: 0;
            width: 100%;
        }

        .center {
            text-align: center;
        }

        #logoMin {
            color: #FFFFFF;
        }

        #logoCaption {
            color: #515151;
            text-align: center;
            font-size: 10px;
        }

        .minText p {
            font-size: 9pt;
            font-weight: 700;
            padding-left: 7px;
            padding-right: 7px;
        }

        h1 {
            font-size: 11pt;
            text-align: center;
            text-decoration: underline;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.75cm;
        }

        .asesor {
            font-size: 8pt;
            text-align: center;
            text-decoration: overline;
            text-transform: uppercase;
            width: auto;
            margin: 0 auto;
            line-height: 1rem;
        }

        .cargo {
            font-size: 8pt;
            text-align: center;
        }

        .left-align {
            text-align: left;
        }

        .no-underline {
            text-decoration: none;
            border-bottom: none;
        }

        h2 {
            font-size: 11pt;
            margin: 0;
            text-align: left;
        }

        .subtitle {
            text-align: left;
        }

        .subtitle h3 {
            font-size: 11pt;
        }

        .item   {
            text-align: left;
            width: 90px;
            vertical-align: text-top;
        }

        .desc {
            text-align: left;
            vertical-align: text-top;
        }

        .desc p {
            margin: 0;
        }

        .glosa {
            width:100%;
            padding-bottom: 10px;
            border-bottom: 1px solid #515151;
            margin-bottom: 2px;
        }

        .glosa.oficio, .glosa.carta, .glosa.diplomatica, .glosa.resolucion, .glosa.resolucion.coactiva, .glosa.nota.circular {
            border-bottom: 1px solid transparent!important;
        }


        .glosa.oficio .fecha {
            margin-bottom: 40px;
        }
        .fechaDerecha{
            text-align: right;
        }

        .glosa.oficio h1 {
            margin-bottom: 2px;
        }

        .glosa.oficio .overlined {
            font-size: 85%;
            padding: 0.25rem 0;
        }

        .glosa dl {
            display: flex;
            margin-bottom: 0;
            margin-top: 0;
        }

        .glosa dl .item {
            position: relative;
        }

        .glosa dl .desc::before {
            position: absolute;
            content: ' : ';
            left: -10px;
            top: 0;
        }

        .glosa dl .desc {
            position: relative;
            margin-left: 90px;
        }

        .glosa dl.destinatario .desc p {
            margin-bottom: 1rem;
        }

        .glosa dl.destinatario .desc p:last-child {
            margin-bottom: 0;
        }

        .dots {
            width: 10px;
            vertical-align: text-top;
        }

        .overlined {
            border-bottom: 1px solid #000000;
            border-top: 1px solid #000000;
            width: auto;
            max-width: 50%;
            white-space: normal;
        }

        .pre-footer {
            font-size: 9px !important;
            margin-top: 3rem;
        }

        .pre-footer span {
            display: block;
            padding-top: 1rem;
        }

        .pre-footer span.siglas,
        .pre-footer span.cud {
            padding-top: 0;
        }
        
        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }
        
        .upperCase {
            text-transform: uppercase;
        }

        main .resolucion {
            padding-top: 120px;
        }
        main .resolucion.coactiva {
            padding-top: 0px !important;
        }
        .formatoEntrega .dl-custom {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .formatoEntrega .dl-custom > dt {
            font-weight: 700;
        }

        .formatoEntrega .dl-custom > dd {
            margin-bottom: 0.75rem;
            margin-left: 0;
        }

        .formatoEntrega .dl-custom .table {
            margin-top: 0.5rem;
        }

        .formatoEntrega .table {
            width: 100%;
            border-collapse: collapse;
        }

        .formatoEntrega .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #999999;
        }

        .formatoEntrega .table td, .table th {
            border: 1px solid #999999;
            padding: 0.35rem;
        }

        .formatoEntrega .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.10);
        }

        .formatoEntrega .row {
            display: block;
            margin-right: -15px;
            margin-left: -15px;
        }

        .formatoEntrega .row > .col {
            display: block;
            float: left;
            width: 50%;
        }

        .formatoEntrega .row > .col .firma {
            position: relative;
            overflow: hidden;
            text-align: center;
            margin-top: 5rem;
        }

        .formatoEntrega .row > .col .firma::before {
            content:"";
            display: inline-block;
            height: 0.5em;
            vertical-align: bottom;
            width: 50%;
            margin-right: -50%;
            margin-left: 10px;
            border-top: 1px solid black;
            margin: 0 auto;
        }

        .formatoEntrega .row > .col h4 {
            margin-bottom: 0;
            margin-top: 0;
        }

    </style>