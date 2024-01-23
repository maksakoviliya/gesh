<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="charset=utf-8"/>
    <style>
        /*
        Import the desired font from Google fonts.
        */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

        @page {
            /*
            This CSS highlights how page sizes, margins, and margin boxes are set.
            https://docraptor.com/documentation/article/1067959-size-dimensions-orientation

            Within the page margin boxes content from running elements is used instead of a
            standard content string. The name which is passed in the element() function can
            be found in the CSS code below in a position property and is defined there by
            the running() function.
            */
            size: A4;
            margin: 8cm 0 3cm 0;

            @top-left {
                content: element(header);
            }

            @bottom-left {
                content: element(footer);
            }
        }

        /*
            The body itself has no margin but a padding top & bottom 1cm and left & right 2cm.
            Additionally the default font family, size and color for the document is defined
            here.
            */
        body {
            margin: 0;
            padding: 1cm 2cm;
            color: black;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
        }

        /*
        The links in the document should not be highlighted by an different color and underline
        instead we use the color value inherit to get the current texts color.
        */
        a {
            color: inherit;
            text-decoration: none;
        }

        /*
        For the dividers in the document we use an HR element with a margin top and bottom
        of 1cm, no height and only a border top of one millimeter.
        */
        hr {
            margin: 0.5cm 0;
            height: 0;
            border: 0;
            border-top: 1mm solid #3581BD;
        }

        /*
        To move the first sections a little down and have more space between the top of
        the document and the logo/company name we give the section a padding top of 5mm.
        */
        .headerSection:first-child {
            padding-top: .5cm;
        }

        /*
        Similar we keep some space at the bottom of the header with the padding-bottom
        property.
        */
        .headerSection:last-child {
            padding-bottom: .5cm;
        }

        /*
        For the logo, where we use an SVG image and the company text we also use flexbox
        to align them correctly.
        */
        .logo {
            width: 170px;
            margin: 0 auto;
            display: block;
        }

        .dates {
            margin-top: 5px;
        }

        /*
        For the logo, where we use an SVG image and the company text we also use flexbox
        to align them correctly.
        */
        .logoAndName {
            display: flex;
            flex-direction: column;
        }

        /*
        The SVG gets set to a fixed size and get 5mm margin right to keep some distance
        to the company name.
        */
        .logoAndName svg {
            width: 1.5cm;
            height: 1.5cm;
            margin-right: .5cm;
        }

        /*
        To ensure the top right section "Invoice #100" starts on the same level as the Logo &
        Name we set a padding top of 1cm for this element.
        */
        .headerSection .invoiceDetails {
            padding-top: .2cm;
        }

        /*
        The H3 element "ISSUED TO" gets another 25mm margin to the right to keep some
        space between this header and the client's address.
        Additionally this header text gets the hightlight color as font color.
        */
        .headerSection h3 {
            margin: 0;
            color: #3581BD;
        }


        /*
        The paragraphs within the header sections DIV elements get a small 2px margin top
        to ensure its in line with the "ISSUED TO" header text.
        */
        .headerSection div p {
            margin-top: 2px;
        }

        /*
        All header elements and paragraphs within the HTML HEADER tag get a margin of 0.
        */
        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        /*
        The invoice details should not be uppercase and also be aligned to the right.
        */
        .invoiceDetails,
        .invoiceDetails h2 {
            text-align: left;
            font-size: 1em;
            text-transform: none;
        }

        /*
        Heading of level 2 and 3 ("DUE DATE", "AMOUNT" and "INVOICE TO") need to be written in
        uppercase, so we use the text-transform property for that.
        */
        .header h3 {
            text-transform: uppercase;
        }

        /*
        Our .main content is all within the HTML MAIN element. In this template this are
        two tables. The one which lists all items and the table which shows us the
        subtotal, tax and total amount.

        Both tables get the full width and collapse the border.
        */
        .main table {
            width: 100%;
            border-collapse: collapse;
        }

        /*
        We put the first tables headers in a THEAD element, this way they repeat on the
        next page if our table overflows to multiple pages.

        The text color gets set to the highlight color.
        */
        .main table thead th {
            height: 1cm;
            color: #3581BD;
        }

        /*
        For the last three columns we set a fixed width of 2.5cm, so if we would change
        the documents size only the first column with the item name and description grows.
        */
        .main table thead th:nth-of-type(2),
        .main table thead th:nth-of-type(3),
        .main table thead th:last-of-type {
            width: 2.5cm;
        }

        /*
        The items itself are all with the TBODY element, each cell gets a padding top
        and bottom of 2mm.
        */
        .main table tbody td {
            padding: 2mm 0;
        }

        /*
        The cells in the last column (in this template the column containing the total)
        get a text align right so the text is at the end of the table.
        */
        .main table thead th:last-of-type,
        .main table tbody td:last-of-type {
            text-align: right;
        }

        /*
        By default text within TH elements is aligned in the center, we do not want that
        so we overwrite it with an left alignment.
        */
        .main table th {
            text-align: left;
        }

        /*
        The summary table, so the table containing the subtotal, tax and total amount
        gets a width of 40% + 2cm. The plus 2cm is added because our body has a 2cm padding
        but we want our highlight color for the total row to go to the edge of the document.

        To move the table to the right side we simply set a margin-left of 60%.
        */
        .main table.summary {
            width: calc(40% + 2cm);
            margin-left: 60%;
            margin-top: .5cm;
        }

        /*
        The row containing the total amount gets its background color set to the highlight
        color and the font weight to bold.
        */
        .main table.summary tr.total {
            font-weight: bold;
            background-color: #60D0E4;
        }

        /*
        The TH elements of the summary table are not on top but the cells on the left side
        these get a padding left of 1cm to give the highlight color some space.
        */
        .main table.summary th {
            padding: 4mm 0 4mm 1cm;
        }

        /*
        As only the highlight background color should go to the edge of the document
        but the text should still have the 2cm distance, we set the padding right to
        2cm.
        */
        .main table.summary td {
            padding: 4mm 2cm 4mm 0;
            border-bottom: 0;
        }

        /*
        The content below the tables is placed in a ASIDE element next to the MAIN element.
        To ensure this element is always at the bottom of the page, just above the page
        footer, we use the Prince custom property "-prince-float" with the value bottom.

        See Page Floats on https://www.princexml.com/howcome/2021/guides/float/.
        */
        aside {
            -prince-float: bottom;
            padding: 0 2cm .5cm 2cm;
        }

        /*
        The content itself is shown in 2 columns we use flexbox for this.
        */
        aside > div {
            display: flex;
            justify-content: space-between;
        }

        /*
        Each "column" has a width of 45% of the document.
        */
        aside > div > div {
            width: 45%;
        }

        /*
        The list with the payment options has no bullet points and no margin.
        */
        aside > div > div ul {
            list-style-type: none;
            margin: 0;
        }

        /*
        The page footer in our document uses the HTML FOOTER element, we define a height
        of 3cm matching the margin bottom of the page (see @page rule) and a padding left
        and right of 2cm. We did not give the page itself a margin of 2cm to ensure that
        the background color goes to the edges of the document.

        As mentioned above in the comment for the @page the position property with the
        value running(footer) makes this HTML element float into the bottom left page margin
        box. This page margin box repeats on every page in case we would have a multi-page
        invoice.

        The content inside the footer is aligned with the help of line-height 3cm and a
        flexbox for the child elements.
        */
        footer {
            height: 3cm;
            line-height: 3cm;
            padding: 0 2cm;
            position: running(footer);
            background-color: #BFC0C3;
            font-size: 8pt;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }

        /*
        The first link in the footer, which points to the company website is highlighted
        in bold.
        */
        footer a:first-child {
            font-weight: bold;
        }

    </style>
    <title></title>
</head>

<body>

<div class="header">
    <img class="logo"
         src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjQuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAyMDAgMjAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAyMDAgMjAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzM1ODFCODt9Cjwvc3R5bGU+CjxnPgoJPGc+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE1LjYsMTQxLjA5Yy0xLjc3LDAtMy40MS0wLjI4LTQuOS0wLjg1Yy0xLjQ5LTAuNTctMi43OS0xLjM3LTMuODgtMi40MmMtMS4wOS0xLjA1LTEuOTQtMi4yNy0yLjU1LTMuNjgKCQkJYy0wLjYxLTEuNDEtMC45MS0yLjk2LTAuOTEtNC42NGMwLTEuNjksMC4zLTMuMjQsMC45MS00LjY0YzAuNjEtMS40MSwxLjQ3LTIuNjQsMi41OC0zLjY4YzEuMTEtMS4wNSwyLjQxLTEuODUsMy45MS0yLjQyCgkJCWMxLjQ5LTAuNTcsMy4xNC0wLjg1LDQuOTMtMC44NWMxLjk5LDAsMy43NywwLjMzLDUuMzcsMC45OWMxLjU5LDAuNjYsMi45MywxLjYyLDQuMDIsMi44OGwtMy4zLDMuMDcKCQkJYy0wLjgzLTAuODgtMS43My0xLjUyLTIuNjktMS45NGMtMC45Ni0wLjQyLTIuMDItMC42Mi0zLjE3LTAuNjJjLTEuMDcsMC0yLjA1LDAuMTgtMi45NSwwLjUzYy0wLjksMC4zNS0xLjY3LDAuODUtMi4zMiwxLjQ5CgkJCWMtMC42NSwwLjY0LTEuMTUsMS40LTEuNTEsMi4yN2MtMC4zNSwwLjg4LTAuNTMsMS44NS0wLjUzLDIuOTFjMCwxLjAyLDAuMTgsMS45OCwwLjUzLDIuODdjMC4zNSwwLjg5LDAuODUsMS42NSwxLjUxLDIuMjkKCQkJYzAuNjUsMC42NCwxLjQyLDEuMTQsMi4zMSwxLjUxYzAuODksMC4zNiwxLjg2LDAuNTQsMi45MywwLjU0YzEuMDIsMCwyLjAyLTAuMTcsMi45OS0wLjUxYzAuOTctMC4zNCwxLjkyLTAuOTEsMi44My0xLjcKCQkJbDIuOTUsMy43NWMtMS4yNCwwLjk0LTIuNjYsMS42NS00LjI2LDIuMTNDMTguOCwxNDAuODUsMTcuMiwxNDEuMDksMTUuNiwxNDEuMDl6IE0xOS45MiwxMzcuNTd2LTguNDJoNC43NHY5LjFMMTkuOTIsMTM3LjU3eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0zNi44NywxNDAuOTZjLTEuOTYsMC0zLjY4LTAuMzgtNS4xNi0xLjE1Yy0xLjQ3LTAuNzctMi42Mi0xLjgyLTMuNDMtMy4xNWMtMC44MS0xLjMzLTEuMjItMi44Ni0xLjIyLTQuNTYKCQkJYzAtMS43MSwwLjM5LTMuMjQsMS4xNy00LjU4YzAuNzgtMS4zNSwxLjg3LTIuNCwzLjI3LTMuMTZjMS40LTAuNzYsMi45Ny0xLjE0LDQuNzItMS4xNGMxLjY5LDAsMy4yMSwwLjM2LDQuNTYsMS4wOQoJCQljMS4zNiwwLjczLDIuNDMsMS43NSwzLjIyLDMuMDhjMC43OSwxLjMyLDEuMTksMi45MSwxLjE5LDQuNzdjMCwwLjE5LTAuMDEsMC40MS0wLjAzLDAuNjZjLTAuMDIsMC4yNS0wLjA0LDAuNDgtMC4wNiwwLjY5aC0xNAoJCQl2LTIuOTJoMTEuMzdsLTEuOTUsMC44NmMwLjAyLTAuOS0wLjE1LTEuNjgtMC41MS0yLjM0Yy0wLjM2LTAuNjYtMC44Ni0xLjE4LTEuNTEtMS41NWMtMC42NC0wLjM3LTEuMzktMC41Ni0yLjI0LTAuNTYKCQkJYy0wLjg1LDAtMS42MSwwLjE5LTIuMjYsMC41NmMtMC42NSwwLjM3LTEuMTYsMC45LTEuNTIsMS41N2MtMC4zNiwwLjY3LTAuNTQsMS40Ny0wLjU0LDIuMzl2MC43N2MwLDAuOTYsMC4yMSwxLjc5LDAuNjQsMi41CgkJCWMwLjQzLDAuNywxLjAxLDEuMjQsMS43NiwxLjYyYzAuNzUsMC4zNywxLjY0LDAuNTYsMi42OSwwLjU2YzAuOSwwLDEuNjktMC4xNCwyLjM5LTAuNDJjMC42OS0wLjI4LDEuMzMtMC42OSwxLjkxLTEuMjVsMi42NiwyLjg4CgkJCWMtMC43OSwwLjktMS43OCwxLjU5LTIuOTgsMi4wN0MzOS44LDE0MC43MiwzOC40MywxNDAuOTYsMzYuODcsMTQwLjk2eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01My41MiwxNDAuOTZjLTEuNDcsMC0yLjg4LTAuMTgtNC4yMy0wLjUzYy0xLjM1LTAuMzUtMi40Mi0wLjgtMy4yNC0xLjMzbDEuNjMtMy41NgoJCQljMC44MSwwLjQ3LDEuNzYsMC44NiwyLjgzLDEuMTdjMS4wOCwwLjMxLDIuMTQsMC40NiwzLjE5LDAuNDZjMS4xNSwwLDEuOTctMC4xNCwyLjQ1LTAuNDJjMC40OC0wLjI4LDAuNzItMC42NiwwLjcyLTEuMTUKCQkJYzAtMC40MS0wLjE5LTAuNzEtMC41Ni0wLjkxYy0wLjM3LTAuMi0wLjg2LTAuMzYtMS40Ny0wLjQ2Yy0wLjYxLTAuMTEtMS4yOS0wLjIxLTIuMDMtMC4zMmMtMC43NS0wLjExLTEuNDktMC4yNi0yLjIzLTAuNDUKCQkJYy0wLjc0LTAuMTktMS40Mi0wLjQ2LTIuMDUtMC44MmMtMC42My0wLjM1LTEuMTMtMC44NC0xLjUxLTEuNDZjLTAuMzctMC42Mi0wLjU2LTEuNDItMC41Ni0yLjRjMC0xLjA5LDAuMzItMi4wNiwwLjk2LTIuOQoJCQljMC42NC0wLjg0LDEuNTUtMS41LDIuNzItMS45N2MxLjE3LTAuNDcsMi41OS0wLjcsNC4yNi0wLjdjMS4yLDAsMi40LDAuMTMsMy42LDAuNGMxLjIxLDAuMjcsMi4yMywwLjY0LDMuMDYsMS4xMWwtMS43LDMuNTYKCQkJYy0wLjgxLTAuNDctMS42NC0wLjgtMi40OC0wLjk5Yy0wLjg0LTAuMTktMS42NS0wLjI5LTIuNDItMC4yOWMtMS4xNSwwLTEuOTksMC4xNS0yLjUsMC40NWMtMC41MSwwLjMtMC43NywwLjY4LTAuNzcsMS4xNQoJCQljMCwwLjQzLDAuMTksMC43NSwwLjU4LDAuOThjMC4zOCwwLjIyLDAuODksMC4zOSwxLjUxLDAuNWMwLjYyLDAuMTEsMS4zLDAuMjEsMi4wNSwwLjMyYzAuNzUsMC4xMSwxLjQ4LDAuMjYsMi4yMSwwLjQ1CgkJCWMwLjczLDAuMTksMS40LDAuNDYsMi4wMywwLjgyYzAuNjMsMC4zNSwxLjEzLDAuODQsMS41MSwxLjQ2YzAuMzcsMC42MiwwLjU2LDEuNDIsMC41NiwyLjRjMCwxLjA1LTAuMzIsMS45OC0wLjk2LDIuOAoJCQljLTAuNjQsMC44Mi0xLjU2LDEuNDctMi43NywxLjk0QzU2LjcyLDE0MC43Myw1NS4yNSwxNDAuOTYsNTMuNTIsMTQwLjk2eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik03NC40MSwxMjMuMjJjMS4zNywwLDIuNTksMC4yNywzLjY3LDAuODJjMS4wOCwwLjU0LDEuOTMsMS4zOCwyLjU1LDIuNWMwLjYyLDEuMTIsMC45MywyLjU2LDAuOTMsNC4zMXY5Ljg3CgkJCWgtNXYtOS4xYzAtMS4zOS0wLjMtMi40MS0wLjkxLTMuMDhjLTAuNjEtMC42Ni0xLjQ3LTAuOTktMi41OC0wLjk5Yy0wLjc5LDAtMS41LDAuMTctMi4xMywwLjUxYy0wLjYzLDAuMzQtMS4xMiwwLjg0LTEuNDcsMS41MQoJCQljLTAuMzUsMC42Ni0wLjUzLDEuNTQtMC41MywyLjYzdjguNTJoLTV2LTIzLjc3aDV2MTEuMzFsLTEuMTItMS40NGMwLjYyLTEuMTUsMS41MS0yLjA0LDIuNjYtMi42NgoJCQlDNzEuNjIsMTIzLjUzLDcyLjkzLDEyMy4yMiw3NC40MSwxMjMuMjJ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTkzLjg4LDE0MC43MXYtMjIuNDJoOS43MWMyLjAxLDAsMy43NCwwLjMzLDUuMTksMC45OGMxLjQ1LDAuNjUsMi41NywxLjU5LDMuMzYsMi44CgkJCWMwLjc5LDEuMjIsMS4xOSwyLjY2LDEuMTksNC4zMmMwLDEuNjktMC40LDMuMTMtMS4xOSw0LjM0Yy0wLjc5LDEuMjEtMS45MSwyLjEzLTMuMzYsMi43NWMtMS40NSwwLjYzLTMuMTgsMC45NC01LjE5LDAuOTRoLTYuODUKCQkJbDIuMzctMi4yNHY4LjUySDkzLjg4eiBNOTkuMSwxMzIuNzZsLTIuMzctMi40N2g2LjU3YzEuNTgsMCwyLjc4LTAuMzQsMy41OS0xLjAyYzAuODEtMC42OCwxLjIyLTEuNjQsMS4yMi0yLjg4CgkJCWMwLTEuMjQtMC40MS0yLjE5LTEuMjItMi44N2MtMC44MS0wLjY3LTIuMDEtMS4wMS0zLjU5LTEuMDFoLTYuNTdsMi4zNy0yLjQ3VjEzMi43NnogTTEwOC4xNywxNDAuNzFsLTUuNjQtOC4xNGg1LjU3bDUuNjQsOC4xNAoJCQlIMTA4LjE3eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xMjQuODIsMTQwLjk2Yy0xLjk2LDAtMy42OC0wLjM4LTUuMTYtMS4xNWMtMS40Ny0wLjc3LTIuNjItMS44Mi0zLjQzLTMuMTVjLTAuODEtMS4zMy0xLjIyLTIuODYtMS4yMi00LjU2CgkJCWMwLTEuNzEsMC4zOS0zLjI0LDEuMTctNC41OGMwLjc4LTEuMzUsMS44Ny0yLjQsMy4yNy0zLjE2YzEuNC0wLjc2LDIuOTctMS4xNCw0LjcyLTEuMTRjMS42OSwwLDMuMjEsMC4zNiw0LjU2LDEuMDkKCQkJYzEuMzYsMC43MywyLjQzLDEuNzUsMy4yMiwzLjA4YzAuNzksMS4zMiwxLjE5LDIuOTEsMS4xOSw0Ljc3YzAsMC4xOS0wLjAxLDAuNDEtMC4wMywwLjY2Yy0wLjAyLDAuMjUtMC4wNCwwLjQ4LTAuMDYsMC42OWgtMTQKCQkJdi0yLjkyaDExLjM3bC0xLjk1LDAuODZjMC4wMi0wLjktMC4xNS0xLjY4LTAuNTEtMi4zNGMtMC4zNi0wLjY2LTAuODYtMS4xOC0xLjUxLTEuNTVjLTAuNjQtMC4zNy0xLjM5LTAuNTYtMi4yNC0wLjU2CgkJCWMtMC44NSwwLTEuNjEsMC4xOS0yLjI2LDAuNTZjLTAuNjUsMC4zNy0xLjE2LDAuOS0xLjUyLDEuNTdjLTAuMzYsMC42Ny0wLjU0LDEuNDctMC41NCwyLjM5djAuNzdjMCwwLjk2LDAuMjEsMS43OSwwLjY0LDIuNQoJCQljMC40MywwLjcsMS4wMSwxLjI0LDEuNzYsMS42MmMwLjc1LDAuMzcsMS42NCwwLjU2LDIuNjksMC41NmMwLjksMCwxLjY5LTAuMTQsMi4zOS0wLjQyYzAuNjktMC4yOCwxLjMzLTAuNjksMS45MS0xLjI1bDIuNjYsMi44OAoJCQljLTAuNzksMC45LTEuNzgsMS41OS0yLjk4LDIuMDdDMTI3Ljc2LDE0MC43MiwxMjYuMzgsMTQwLjk2LDEyNC44MiwxNDAuOTZ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE0MS40OCwxNDAuOTZjLTEuNDcsMC0yLjg4LTAuMTgtNC4yMy0wLjUzYy0xLjM1LTAuMzUtMi40Mi0wLjgtMy4yNC0xLjMzbDEuNjMtMy41NgoJCQljMC44MSwwLjQ3LDEuNzYsMC44NiwyLjgzLDEuMTdjMS4wOCwwLjMxLDIuMTQsMC40NiwzLjE5LDAuNDZjMS4xNSwwLDEuOTctMC4xNCwyLjQ1LTAuNDJjMC40OC0wLjI4LDAuNzItMC42NiwwLjcyLTEuMTUKCQkJYzAtMC40MS0wLjE5LTAuNzEtMC41Ni0wLjkxYy0wLjM3LTAuMi0wLjg2LTAuMzYtMS40Ny0wLjQ2Yy0wLjYxLTAuMTEtMS4yOS0wLjIxLTIuMDMtMC4zMmMtMC43NS0wLjExLTEuNDktMC4yNi0yLjIzLTAuNDUKCQkJYy0wLjc0LTAuMTktMS40Mi0wLjQ2LTIuMDUtMC44MmMtMC42My0wLjM1LTEuMTMtMC44NC0xLjUxLTEuNDZjLTAuMzctMC42Mi0wLjU2LTEuNDItMC41Ni0yLjRjMC0xLjA5LDAuMzItMi4wNiwwLjk2LTIuOQoJCQljMC42NC0wLjg0LDEuNTUtMS41LDIuNzItMS45N2MxLjE3LTAuNDcsMi41OS0wLjcsNC4yNi0wLjdjMS4yLDAsMi40LDAuMTMsMy42LDAuNGMxLjIxLDAuMjcsMi4yMywwLjY0LDMuMDYsMS4xMWwtMS43LDMuNTYKCQkJYy0wLjgxLTAuNDctMS42NC0wLjgtMi40OC0wLjk5Yy0wLjg0LTAuMTktMS42NS0wLjI5LTIuNDItMC4yOWMtMS4xNSwwLTEuOTksMC4xNS0yLjUsMC40NWMtMC41MSwwLjMtMC43NywwLjY4LTAuNzcsMS4xNQoJCQljMCwwLjQzLDAuMTksMC43NSwwLjU4LDAuOThjMC4zOCwwLjIyLDAuODksMC4zOSwxLjUxLDAuNWMwLjYyLDAuMTEsMS4zLDAuMjEsMi4wNSwwLjMyYzAuNzUsMC4xMSwxLjQ4LDAuMjYsMi4yMSwwLjQ1CgkJCWMwLjczLDAuMTksMS40LDAuNDYsMi4wMywwLjgyYzAuNjMsMC4zNSwxLjEzLDAuODQsMS41MSwxLjQ2YzAuMzcsMC42MiwwLjU2LDEuNDIsMC41NiwyLjRjMCwxLjA1LTAuMzIsMS45OC0wLjk2LDIuOAoJCQljLTAuNjQsMC44Mi0xLjU2LDEuNDctMi43NywxLjk0QzE0NC42OCwxNDAuNzMsMTQzLjIxLDE0MC45NiwxNDEuNDgsMTQwLjk2eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNjAuMDYsMTQwLjk2Yy0xLjgyLDAtMy40My0wLjM4LTQuODUtMS4xNWMtMS40Mi0wLjc3LTIuNTQtMS44Mi0zLjM1LTMuMTVjLTAuODEtMS4zMy0xLjIyLTIuODYtMS4yMi00LjU2CgkJCWMwLTEuNzMsMC40MS0zLjI2LDEuMjItNC42YzAuODEtMS4zMywxLjkzLTIuMzgsMy4zNS0zLjE0YzEuNDItMC43NiwzLjA0LTEuMTQsNC44NS0xLjE0YzEuODQsMCwzLjQ3LDAuMzgsNC45LDEuMTQKCQkJYzEuNDMsMC43NiwyLjU1LDEuOCwzLjM2LDMuMTRjMC44MSwxLjMzLDEuMjIsMi44NywxLjIyLDQuNmMwLDEuNzMtMC40MSwzLjI2LTEuMjIsNC41OGMtMC44MSwxLjMyLTEuOTMsMi4zNy0zLjM2LDMuMTQKCQkJQzE2My41MywxNDAuNTgsMTYxLjg5LDE0MC45NiwxNjAuMDYsMTQwLjk2eiBNMTYwLjA2LDEzNi44NmMwLjg1LDAsMS42MS0wLjE5LDIuMjYtMC41NmMwLjY1LTAuMzcsMS4xNy0wLjkyLDEuNTctMS42NQoJCQljMC4zOS0wLjczLDAuNTktMS41OCwwLjU5LTIuNTZjMC0xLTAuMi0xLjg2LTAuNTktMi41NmMtMC40LTAuNy0wLjkyLTEuMjQtMS41Ny0xLjYyYy0wLjY1LTAuMzctMS4zOS0wLjU2LTIuMjMtMC41NgoJCQljLTAuODMsMC0xLjU4LDAuMTktMi4yNCwwLjU2Yy0wLjY2LDAuMzctMS4xOSwwLjkxLTEuNTksMS42MmMtMC40LDAuNy0wLjU5LDEuNTYtMC41OSwyLjU2YzAsMC45OCwwLjIsMS44NCwwLjU5LDIuNTYKCQkJYzAuMzksMC43MywwLjkyLDEuMjgsMS41OSwxLjY1QzE1OC41MSwxMzYuNjgsMTU5LjI0LDEzNi44NiwxNjAuMDYsMTM2Ljg2eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNzIuMDcsMTQwLjcxdi0xNy4yM2g0Ljc3djQuOWwtMC42Ny0xLjQ0YzAuNTEtMS4yMiwxLjMzLTIuMTQsMi40Ny0yLjc3YzEuMTMtMC42MywyLjUxLTAuOTQsNC4xMy0wLjk0CgkJCXY0LjY0Yy0wLjE5LTAuMDQtMC4zOC0wLjA3LTAuNTYtMC4xYy0wLjE4LTAuMDItMC4zNi0wLjAzLTAuNTMtMC4wM2MtMS40MSwwLTIuNTMsMC40LTMuMzYsMS4xOWMtMC44MywwLjc5LTEuMjUsMi4wMS0xLjI1LDMuNjUKCQkJdjguMTRIMTcyLjA3eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xODMuNSwxMjcuN3YtMy44NGgxMS45NXYzLjg0SDE4My41eiBNMTkyLjYsMTQwLjk2Yy0yLjAzLDAtMy42MS0wLjUyLTQuNzQtMS41NQoJCQljLTEuMTMtMS4wNC0xLjctMi41OC0xLjctNC42M3YtMTUuMTJoNS4wM3YxNS4wMmMwLDAuNzMsMC4xOSwxLjI5LDAuNTYsMS43YzAuMzcsMC40MSwwLjg4LDAuNjEsMS41MiwwLjYxCgkJCWMwLjgxLDAsMS40OS0wLjIxLDIuMDUtMC42NGwxLjMxLDMuNTJjLTAuNDksMC4zNi0xLjA5LDAuNjQtMS44MSwwLjgyQzE5NC4xMSwxNDAuODcsMTkzLjM3LDE0MC45NiwxOTIuNiwxNDAuOTZ6Ii8+Cgk8L2c+Cgk8Zz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMzkuMDcsMTUwLjI0bC0xLjU4LTQuNzNoMC43bDEuNDUsNC4zNmgtMC4zNWwxLjUxLTQuMzZoMC42MmwxLjQ3LDQuMzZoLTAuMzRsMS40Ny00LjM2aDAuNjRsLTEuNTgsNC43MwoJCQloLTAuNzFsLTEuMzgtNC4wNGgwLjE4bC0xLjM4LDQuMDRIMzkuMDd6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTQ5LjAzLDE1MC4yNGwtMS41OC00LjczaDAuN2wxLjQ1LDQuMzZoLTAuMzVsMS41MS00LjM2aDAuNjJsMS40Nyw0LjM2aC0wLjM0bDEuNDctNC4zNmgwLjY0bC0xLjU4LDQuNzMKCQkJaC0wLjcxbC0xLjM4LTQuMDRoMC4xOGwtMS4zOCw0LjA0SDQ5LjAzeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01OC45OSwxNTAuMjRsLTEuNTgtNC43M2gwLjdsMS40NSw0LjM2aC0wLjM1bDEuNTEtNC4zNmgwLjYybDEuNDcsNC4zNmgtMC4zNGwxLjQ3LTQuMzZoMC42NEw2MywxNTAuMjRINjIuMwoJCQlsLTEuMzgtNC4wNGgwLjE4bC0xLjM4LDQuMDRINTguOTl6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTY3LjY5LDE1MC4yOGMtMC4xMywwLTAuMjMtMC4wNC0wLjMyLTAuMTNjLTAuMDktMC4wOS0wLjE0LTAuMi0wLjE0LTAuMzNjMC0wLjEzLDAuMDUtMC4yNCwwLjE0LTAuMzMKCQkJYzAuMDktMC4wOSwwLjItMC4xMywwLjMyLTAuMTNjMC4xMiwwLDAuMjMsMC4wNCwwLjMxLDAuMTNjMC4wOSwwLjA5LDAuMTMsMC4yLDAuMTMsMC4zM2MwLDAuMTQtMC4wNCwwLjI1LTAuMTMsMC4zMwoJCQlDNjcuOTIsMTUwLjI0LDY3LjgxLDE1MC4yOCw2Ny42OSwxNTAuMjh6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTczLjUyLDE1MC4zYy0wLjM2LDAtMC43LTAuMDYtMS4wMS0wLjE4Yy0wLjMxLTAuMTItMC41Ny0wLjI5LTAuOC0wLjUxYy0wLjIzLTAuMjItMC40LTAuNDctMC41My0wLjc3CgkJCWMtMC4xMy0wLjI5LTAuMTktMC42MS0wLjE5LTAuOTdjMC0wLjM1LDAuMDYtMC42NywwLjE5LTAuOTdjMC4xMy0wLjI5LDAuMy0wLjU1LDAuNTMtMC43N2MwLjIzLTAuMjIsMC40OS0wLjM5LDAuOC0wLjUxCgkJCWMwLjMxLTAuMTIsMC42NC0wLjE4LDEuMDEtMC4xOGMwLjM3LDAsMC43MiwwLjA2LDEuMDMsMC4xOGMwLjMxLDAuMTIsMC41NywwLjMsMC43OSwwLjU1bC0wLjQyLDAuNDIKCQkJYy0wLjE5LTAuMTktMC40LTAuMzMtMC42My0wLjQyYy0wLjIzLTAuMDktMC40Ny0wLjEzLTAuNzQtMC4xM2MtMC4yNywwLTAuNTIsMC4wNS0wLjc1LDAuMTRjLTAuMjMsMC4wOS0wLjQzLDAuMjItMC42LDAuMzgKCQkJYy0wLjE3LDAuMTYtMC4zLDAuMzUtMC4zOSwwLjU4Yy0wLjA5LDAuMjItMC4xNCwwLjQ2LTAuMTQsMC43M2MwLDAuMjYsMC4wNSwwLjUsMC4xNCwwLjcyYzAuMDksMC4yMiwwLjIyLDAuNDIsMC4zOSwwLjU4CgkJCWMwLjE3LDAuMTYsMC4zNywwLjI5LDAuNiwwLjM4YzAuMjMsMC4wOSwwLjQ4LDAuMTMsMC43NSwwLjEzYzAuMjUsMCwwLjQ5LTAuMDQsMC43My0wLjEyYzAuMjMtMC4wOCwwLjQ1LTAuMjEsMC42NC0wLjM5CgkJCWwwLjM4LDAuNTFjLTAuMjMsMC4yLTAuNTEsMC4zNS0wLjgyLDAuNDVDNzQuMTgsMTUwLjI1LDczLjg1LDE1MC4zLDczLjUyLDE1MC4zeiBNNzQuNjYsMTQ5LjYxdi0xLjc2aDAuNjV2MS44NEw3NC42NiwxNDkuNjF6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTc5LjY0LDE0OS42NmgyLjc1djAuNTloLTMuNDN2LTQuNzNoMy4zM3YwLjU5aC0yLjY2VjE0OS42NnogTTc5LjU4LDE0Ny41NmgyLjQzdjAuNTdoLTIuNDNWMTQ3LjU2eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04Ny4yMiwxNTAuM2MtMC4zNiwwLTAuNy0wLjA2LTEuMDMtMC4xN2MtMC4zMy0wLjExLTAuNTktMC4yNS0wLjc4LTAuNDNsMC4yNS0wLjUzCgkJCWMwLjE4LDAuMTYsMC40MSwwLjI5LDAuNjksMC4zOWMwLjI4LDAuMSwwLjU3LDAuMTYsMC44NywwLjE2YzAuMjcsMCwwLjUtMC4wMywwLjY3LTAuMDljMC4xNy0wLjA2LDAuMy0wLjE1LDAuMzgtMC4yNgoJCQljMC4wOC0wLjExLDAuMTItMC4yNCwwLjEyLTAuMzdjMC0wLjE2LTAuMDUtMC4yOS0wLjE2LTAuMzljLTAuMTEtMC4xLTAuMjQtMC4xOC0wLjQxLTAuMjRjLTAuMTctMC4wNi0wLjM1LTAuMTEtMC41Ni0wLjE2CgkJCWMtMC4yLTAuMDQtMC40MS0wLjEtMC42MS0wLjE2Yy0wLjItMC4wNi0wLjM5LTAuMTQtMC41Ni0wLjIzYy0wLjE3LTAuMDktMC4zLTAuMjItMC40MS0wLjM4Yy0wLjEtMC4xNi0wLjE2LTAuMzctMC4xNi0wLjYyCgkJCWMwLTAuMjQsMC4wNi0wLjQ3LDAuMTktMC42N2MwLjEzLTAuMiwwLjMzLTAuMzcsMC41OS0wLjQ5YzAuMjctMC4xMiwwLjYxLTAuMTksMS4wMi0wLjE5YzAuMjcsMCwwLjU1LDAuMDQsMC44MiwwLjExCgkJCWMwLjI3LDAuMDcsMC41LDAuMTgsMC43LDAuMzFsLTAuMjIsMC41NGMtMC4yLTAuMTQtMC40Mi0wLjIzLTAuNjQtMC4yOWMtMC4yMi0wLjA2LTAuNDQtMC4wOS0wLjY1LTAuMDkKCQkJYy0wLjI3LDAtMC40OCwwLjAzLTAuNjUsMC4xYy0wLjE3LDAuMDctMC4zLDAuMTYtMC4zNywwLjI3Yy0wLjA4LDAuMTEtMC4xMiwwLjI0LTAuMTIsMC4zOGMwLDAuMTcsMC4wNSwwLjMsMC4xNiwwLjQKCQkJYzAuMTEsMC4xLDAuMjQsMC4xOCwwLjQxLDAuMjRjMC4xNywwLjA2LDAuMzUsMC4xMSwwLjU2LDAuMTZjMC4yLDAuMDUsMC40MSwwLjEsMC42MSwwLjE2YzAuMiwwLjA2LDAuMzksMC4xNCwwLjU2LDAuMjMKCQkJYzAuMTcsMC4wOSwwLjMsMC4yMiwwLjQxLDAuMzhjMC4xLDAuMTYsMC4xNiwwLjM2LDAuMTYsMC42MWMwLDAuMjQtMC4wNywwLjQ2LTAuMiwwLjY3Yy0wLjEzLDAuMi0wLjMzLDAuMzctMC42LDAuNDkKCQkJQzg3Ljk4LDE1MC4yNCw4Ny42NCwxNTAuMyw4Ny4yMiwxNTAuM3oiLz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOTMuMDgsMTUwLjI0SDkyLjR2LTQuNzNoMC42OFYxNTAuMjR6IE05NS44NSwxNDguMTRoLTIuODR2LTAuNTloMi44NFYxNDguMTR6IE05NS43OSwxNDUuNTJoMC42OHY0LjczCgkJCWgtMC42OFYxNDUuNTJ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTk5Ljk5LDE0OC4xNHYtMC41NmgxLjgydjAuNTZIOTkuOTl6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEwNS4zMywxNTAuMjR2LTQuNzNoMS44NGMwLjQxLDAsMC43NywwLjA3LDEuMDYsMC4yYzAuMjksMC4xMywwLjUyLDAuMzIsMC42NywwLjU3CgkJCWMwLjE2LDAuMjUsMC4yNCwwLjU0LDAuMjQsMC44OHMtMC4wOCwwLjY0LTAuMjQsMC44OGMtMC4xNiwwLjI1LTAuMzgsMC40My0wLjY3LDAuNTZjLTAuMjksMC4xMy0wLjY1LDAuMi0xLjA2LDAuMmgtMS40NwoJCQlsMC4zLTAuMzF2MS43NUgxMDUuMzN6IE0xMDYsMTQ4LjU2bC0wLjMtMC4zM2gxLjQ1YzAuNDMsMCwwLjc2LTAuMDksMC45OC0wLjI4czAuMzMtMC40NSwwLjMzLTAuNzlzLTAuMTEtMC42LTAuMzMtMC43OAoJCQljLTAuMjItMC4xOC0wLjU1LTAuMjgtMC45OC0wLjI4aC0xLjQ1bDAuMy0wLjM0VjE0OC41NnogTTEwOC40OSwxNTAuMjRsLTEuMi0xLjcxaDAuNzJsMS4yMiwxLjcxSDEwOC40OXoiLz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTEzLjI3LDE0OS42NmgyLjc1djAuNTloLTMuNDN2LTQuNzNoMy4zM3YwLjU5aC0yLjY2VjE0OS42NnogTTExMy4yMSwxNDcuNTZoMi40M3YwLjU3aC0yLjQzVjE0Ny41NnoiLz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTIwLjg2LDE1MC4zYy0wLjM2LDAtMC43LTAuMDYtMS4wMy0wLjE3Yy0wLjMzLTAuMTEtMC41OS0wLjI1LTAuNzgtMC40M2wwLjI1LTAuNTMKCQkJYzAuMTgsMC4xNiwwLjQxLDAuMjksMC42OSwwLjM5YzAuMjgsMC4xLDAuNTcsMC4xNiwwLjg3LDAuMTZjMC4yNywwLDAuNS0wLjAzLDAuNjctMC4wOWMwLjE3LTAuMDYsMC4zLTAuMTUsMC4zOC0wLjI2CgkJCWMwLjA4LTAuMTEsMC4xMi0wLjI0LDAuMTItMC4zN2MwLTAuMTYtMC4wNS0wLjI5LTAuMTYtMC4zOWMtMC4xMS0wLjEtMC4yNC0wLjE4LTAuNDEtMC4yNGMtMC4xNy0wLjA2LTAuMzUtMC4xMS0wLjU2LTAuMTYKCQkJYy0wLjItMC4wNC0wLjQxLTAuMS0wLjYxLTAuMTZjLTAuMi0wLjA2LTAuMzktMC4xNC0wLjU2LTAuMjNjLTAuMTctMC4wOS0wLjMtMC4yMi0wLjQxLTAuMzhjLTAuMS0wLjE2LTAuMTYtMC4zNy0wLjE2LTAuNjIKCQkJYzAtMC4yNCwwLjA2LTAuNDcsMC4xOS0wLjY3czAuMzMtMC4zNywwLjU5LTAuNDljMC4yNy0wLjEyLDAuNjEtMC4xOSwxLjAyLTAuMTljMC4yNywwLDAuNTUsMC4wNCwwLjgyLDAuMTEKCQkJYzAuMjcsMC4wNywwLjUsMC4xOCwwLjcsMC4zMWwtMC4yMiwwLjU0Yy0wLjItMC4xNC0wLjQyLTAuMjMtMC42NC0wLjI5Yy0wLjIyLTAuMDYtMC40NC0wLjA5LTAuNjUtMC4wOQoJCQljLTAuMjcsMC0wLjQ4LDAuMDMtMC42NSwwLjFjLTAuMTcsMC4wNy0wLjMsMC4xNi0wLjM3LDAuMjdzLTAuMTIsMC4yNC0wLjEyLDAuMzhjMCwwLjE3LDAuMDUsMC4zLDAuMTYsMC40CgkJCWMwLjExLDAuMSwwLjI0LDAuMTgsMC40MSwwLjI0YzAuMTcsMC4wNiwwLjM1LDAuMTEsMC41NiwwLjE2YzAuMiwwLjA1LDAuNDEsMC4xLDAuNjEsMC4xNmMwLjIsMC4wNiwwLjM5LDAuMTQsMC41NiwwLjIzCgkJCWMwLjE3LDAuMDksMC4zLDAuMjIsMC40MSwwLjM4YzAuMSwwLjE2LDAuMTYsMC4zNiwwLjE2LDAuNjFjMCwwLjI0LTAuMDcsMC40Ni0wLjIsMC42N2MtMC4xMywwLjItMC4zMywwLjM3LTAuNiwwLjQ5CgkJCUMxMjEuNjIsMTUwLjI0LDEyMS4yOCwxNTAuMywxMjAuODYsMTUwLjN6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEyOC4xNywxNTAuM2MtMC4zNiwwLTAuNjktMC4wNi0xLTAuMThjLTAuMzEtMC4xMi0wLjU3LTAuMjktMC44LTAuNTFjLTAuMjMtMC4yMi0wLjQtMC40Ny0wLjUzLTAuNzcKCQkJYy0wLjEzLTAuMjktMC4xOS0wLjYxLTAuMTktMC45NmMwLTAuMzUsMC4wNi0wLjY3LDAuMTktMC45NmMwLjEzLTAuMjksMC4zLTAuNTUsMC41My0wLjc3YzAuMjItMC4yMiwwLjQ5LTAuMzksMC44LTAuNTEKCQkJYzAuMzEtMC4xMiwwLjY0LTAuMTgsMS4wMS0wLjE4YzAuMzYsMCwwLjY5LDAuMDYsMSwwLjE4YzAuMzEsMC4xMiwwLjU3LDAuMjksMC44LDAuNTFjMC4yMiwwLjIyLDAuNCwwLjQ3LDAuNTIsMC43NwoJCQljMC4xMiwwLjMsMC4xOSwwLjYyLDAuMTksMC45NmMwLDAuMzUtMC4wNiwwLjY3LTAuMTksMC45N2MtMC4xMiwwLjI5LTAuMywwLjU1LTAuNTIsMC43N2MtMC4yMywwLjIyLTAuNDksMC4zOS0wLjgsMC41MQoJCQlDMTI4Ljg3LDE1MC4yNCwxMjguNTMsMTUwLjMsMTI4LjE3LDE1MC4zeiBNMTI4LjE3LDE0OS43YzAuMjcsMCwwLjUxLTAuMDQsMC43My0wLjEzYzAuMjItMC4wOSwwLjQyLTAuMjIsMC41OC0wLjM4CgkJCWMwLjE2LTAuMTYsMC4yOS0wLjM2LDAuMzgtMC41OGMwLjA5LTAuMjIsMC4xNC0wLjQ2LDAuMTQtMC43MmMwLTAuMjYtMC4wNS0wLjUtMC4xNC0wLjcyYy0wLjA5LTAuMjItMC4yMi0wLjQxLTAuMzgtMC41OAoJCQljLTAuMTYtMC4xNy0wLjM2LTAuMjktMC41OC0wLjM4Yy0wLjIyLTAuMDktMC40Ny0wLjE0LTAuNzMtMC4xNGMtMC4yNiwwLTAuNSwwLjA1LTAuNzMsMC4xNGMtMC4yMiwwLjA5LTAuNDIsMC4yMi0wLjU4LDAuMzgKCQkJYy0wLjE3LDAuMTctMC4zLDAuMzYtMC4zOSwwLjU4Yy0wLjA5LDAuMjItMC4xNCwwLjQ2LTAuMTQsMC43MmMwLDAuMjYsMC4wNSwwLjUsMC4xNCwwLjcyYzAuMDksMC4yMiwwLjIyLDAuNDEsMC4zOSwwLjU4CgkJCWMwLjE3LDAuMTYsMC4zNiwwLjI5LDAuNTgsMC4zOEMxMjcuNjYsMTQ5LjY1LDEyNy45MSwxNDkuNywxMjguMTcsMTQ5Ljd6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEzNC4wNywxNTAuMjR2LTQuNzNoMS44NGMwLjQxLDAsMC43NywwLjA3LDEuMDYsMC4yYzAuMjksMC4xMywwLjUyLDAuMzIsMC42NywwLjU3CgkJCWMwLjE2LDAuMjUsMC4yNCwwLjU0LDAuMjQsMC44OHMtMC4wOCwwLjY0LTAuMjQsMC44OHMtMC4zOCwwLjQzLTAuNjcsMC41NmMtMC4yOSwwLjEzLTAuNjUsMC4yLTEuMDYsMC4yaC0xLjQ3bDAuMy0wLjMxdjEuNzUKCQkJSDEzNC4wN3ogTTEzNC43NSwxNDguNTZsLTAuMy0wLjMzaDEuNDVjMC40MywwLDAuNzYtMC4wOSwwLjk4LTAuMjhjMC4yMi0wLjE5LDAuMzMtMC40NSwwLjMzLTAuNzlzLTAuMTEtMC42LTAuMzMtMC43OAoJCQljLTAuMjItMC4xOC0wLjU1LTAuMjgtMC45OC0wLjI4aC0xLjQ1bDAuMy0wLjM0VjE0OC41NnogTTEzNy4yMywxNTAuMjRsLTEuMi0xLjcxaDAuNzJsMS4yMiwxLjcxSDEzNy4yM3oiLz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTQyLjIxLDE1MC4yNHYtNC4xNGgtMS42MnYtMC41OWgzLjkxdjAuNTloLTEuNjJ2NC4xNEgxNDIuMjF6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE0Ny40NSwxNTAuMjhjLTAuMTMsMC0wLjIzLTAuMDQtMC4zMi0wLjEzYy0wLjA5LTAuMDktMC4xNC0wLjItMC4xNC0wLjMzYzAtMC4xMywwLjA1LTAuMjQsMC4xNC0wLjMzCgkJCWMwLjA5LTAuMDksMC4yLTAuMTMsMC4zMi0wLjEzYzAuMTIsMCwwLjIzLDAuMDQsMC4zMSwwLjEzYzAuMDksMC4wOSwwLjEzLDAuMiwwLjEzLDAuMzNjMCwwLjE0LTAuMDQsMC4yNS0wLjEzLDAuMzMKCQkJQzE0Ny42OCwxNTAuMjQsMTQ3LjU3LDE1MC4yOCwxNDcuNDUsMTUwLjI4eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNTEuMjksMTUwLjI0di00LjczaDEuODRjMC40MSwwLDAuNzcsMC4wNywxLjA2LDAuMmMwLjI5LDAuMTMsMC41MiwwLjMyLDAuNjcsMC41NwoJCQljMC4xNiwwLjI1LDAuMjQsMC41NCwwLjI0LDAuODhzLTAuMDgsMC42NC0wLjI0LDAuODhzLTAuMzgsMC40My0wLjY3LDAuNTZjLTAuMjksMC4xMy0wLjY1LDAuMi0xLjA2LDAuMmgtMS40N2wwLjMtMC4zMXYxLjc1CgkJCUgxNTEuMjl6IE0xNTEuOTYsMTQ4LjU2bC0wLjMtMC4zM2gxLjQ1YzAuNDMsMCwwLjc2LTAuMDksMC45OC0wLjI4YzAuMjItMC4xOSwwLjMzLTAuNDUsMC4zMy0wLjc5cy0wLjExLTAuNi0wLjMzLTAuNzgKCQkJYy0wLjIyLTAuMTgtMC41NS0wLjI4LTAuOTgtMC4yOGgtMS40NWwwLjMtMC4zNFYxNDguNTZ6IE0xNTQuNDUsMTUwLjI0bC0xLjItMS43MWgwLjcybDEuMjIsMS43MUgxNTQuNDV6Ii8+CgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE2MC41MSwxNTAuM2MtMC42MiwwLTEuMTEtMC4xOC0xLjQ2LTAuNTNjLTAuMzYtMC4zNi0wLjUzLTAuODgtMC41My0xLjU2di0yLjY5aDAuNjh2Mi42NgoJCQljMCwwLjUzLDAuMTIsMC45MSwwLjM1LDEuMTVjMC4yMywwLjI0LDAuNTYsMC4zNiwwLjk4LDAuMzZjMC40MywwLDAuNzYtMC4xMiwwLjk5LTAuMzZjMC4yMy0wLjI0LDAuMzUtMC42MywwLjM1LTEuMTV2LTIuNjZoMC42NQoJCQl2Mi42OWMwLDAuNjgtMC4xOCwxLjItMC41MywxLjU2QzE2MS42MywxNTAuMTIsMTYxLjE0LDE1MC4zLDE2MC41MSwxNTAuM3oiLz4KCTwvZz4KCTxnPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNjMuODcsMTE3LjEyYy0xLjE5LTEuMzItMi4zNy0yLjY0LTMuNTUtMy45N2wtMy41My0zLjk4bC03LjAyLThsMS41OC0wLjQ1bC0wLjQzLDQuNzdsLTAuMjIsMi40MgoJCQlsLTEuNjMtMS44OWwtNi4wMS02Ljk5Yy0yLjAxLTIuMzItMy45OS00LjY3LTUuOTktNy4wMWwyLjc0LTAuNDVsLTIuMDcsNi4yMWwtMi4wOCw2LjIxbC0xLjU3LDQuNjhsLTIuMTItNC41NwoJCQljLTEuNjctMy42Mi0zLjMzLTcuMjUtNC45Ny0xMC44NmMtMS42My0zLjYxLTMuMzItNy4xOC01LjAzLTEwLjc2bDQuNDktMC4wNmMtMC42NiwxLjU3LTEuMjMsMy4xNC0xLjc5LDQuNzlsLTIuMTIsNi4xOAoJCQlsLTIuNi02LjA3bC01LjQ2LTEyLjcyYy0xLjgzLTQuMjQtMy42My04LjUtNS40LTEyLjc4bDQuODgsMC40OWwtNC43OSw3LjI0bC0zLjA3LDQuNjRsLTEuOTItNS4yNAoJCQljLTAuNjktMS44OC0xLjU3LTMuNzYtMi41MS01LjY4Yy0wLjk0LTEuOTItMS45NC0zLjg4LTIuODYtNS45N2w1LjEsMC4yMmMtMC4xMSwwLjIxLTAuMjMsMC40Mi0wLjMyLDAuNjFsLTAuMTEsMC4yNAoJCQljLTAuMDEsMC4wMi0wLjAyLDAuMDUtMC4wMSwwLjAxYzAuMDEtMC4wMiwwLjAyLTAuMDUsMC4wNi0wLjE5bDAuMDItMC4wN2wwLjAyLTAuMWwwLjAyLTAuMTRsMC4wMS0wLjEyCgkJCWMwLTAuMDUsMC4wMS0wLjEsMC4wMS0wLjE2YzAtMC4wNiwwLTAuMSwwLTAuMTdjMC0wLjEzLTAuMDItMC4yNy0wLjA0LTAuNGMtMC4wMS0wLjA3LTAuMDMtMC4xMy0wLjA0LTAuMmwtMC4wMy0wLjFsLTAuMDMtMC4wOQoJCQlsLTAuMDQtMC4xM2MtMC4xMy0wLjM0LTAuMzQtMC42OC0wLjU4LTAuOTNsLTAuMS0wLjFjLTAuMDUtMC4wNS0wLjEtMC4wOS0wLjE1LTAuMTNjLTAuMS0wLjA5LTAuMjItMC4xNy0wLjM0LTAuMjUKCQkJYy0wLjI1LTAuMTUtMC41Mi0wLjI3LTAuNzktMC4zM2MtMC4wNy0wLjAyLTAuMTQtMC4wMy0wLjItMC4wNGMtMC4wNi0wLjAxLTAuMTUtMC4wMi0wLjE3LTAuMDJjLTAuMDctMC4wMS0wLjE1LTAuMDEtMC4yMi0wLjAyCgkJCWMtMC4xNSwwLTAuMzEsMC0wLjQ2LDAuMDJjLTAuMTUsMC4wMi0wLjMsMC4wNS0wLjQ0LDAuMWwtMC4xMiwwLjA0bC0wLjA4LDAuMDNjLTAuMTEsMC4wNC0wLjIxLDAuMDktMC4zMSwwLjE0bC0wLjEzLDAuMDgKCQkJbC0wLjA2LDAuMDRsLTAuMTIsMC4wOGwtMC4xLDAuMDhsLTAuMDYsMC4wNWwtMC4xLDAuMDlsLTAuMDYsMC4wNWwtMC4wOCwwLjA4bC0wLjA0LDAuMDVsLTAuMDcsMC4wOGMtMC4wMiwwLjAyLTAuMDEsMC4wMSwwLDAKCQkJYzAuMDItMC4wMiwwLjA0LTAuMDcsMC4wNi0wLjFjMC4wMS0wLjAzLDAuMDItMC4wNS0wLjAxLDAuMDNjLTAuMDEsMC4wNC0wLjA0LDAuMTEtMC4wNywwLjI4Yy0wLjAxLDAuMDktMC4wMywwLjIxLTAuMDIsMC40MgoJCQljMC4wMSwwLjIxLDAuMDIsMC41MSwwLjI0LDAuOTlsNS4wOCwwLjE4Yy0yLjMxLDQuMjItNC41Nyw4LjQ4LTYuODcsMTIuNzVjLTEuMTUsMi4xMy0yLjMzLDQuMjYtMy41MSw2LjM4CgkJCWMtMS4xOSwyLjEyLTIuNCw0LjI0LTMuNjQsNi4zNGwtNS4xOSw4LjhsMC4wOC0xMC4xOGwwLjA4LTkuNWw0Ljk4LDEuM0M4OC41OCw3NS42Miw4Ny4zLDc3LjgxLDg2LDgwbC0zLjkzLDYuNTJsLTMuOTIsNi40OQoJCQljLTEuMzEsMi4xNi0yLjYsNC4zMi0zLjg3LDYuNDlsLTMuMjEsNS40OWwtMC45OS02LjJjLTAuMDUtMC4zMy0wLjEtMC42Ny0wLjE0LTEuMDVjLTAuMDItMC4xOS0wLjAzLTAuMzktMC4wNC0wLjY1CgkJCWMwLTAuMTQsMC0wLjI3LDAuMDItMC41MmMwLjAyLTAuMTMsMC4wMi0wLjI2LDAuMTQtMC42MWMwLjAxLTAuMDMsMC4wNC0wLjExLDAuMDYtMC4xNmwwLjA0LTAuMDlsMC4wNS0wLjEKCQkJYzAuMDUtMC4wOSwwLjExLTAuMTgsMC4xNy0wLjI3YzAuMDItMC4wMywwLjA5LTAuMTIsMC4xNS0wLjE4YzAuMDYtMC4wNywwLjEyLTAuMTMsMC4xOS0wLjE5YzAuMDQtMC4wMywwLjA2LTAuMDUsMC4xMS0wLjA5CgkJCWMwLjA1LTAuMDQsMC4xMS0wLjA4LDAuMTYtMC4xMmMwLjExLTAuMDcsMC4yNC0wLjE0LDAuMzYtMC4xOWMwLjI1LTAuMTEsMC42MS0wLjE4LDAuOTEtMC4xN2MwLjEzLDAsMC4yNywwLjAyLDAuNCwwLjA0CgkJCWMwLjA3LDAuMDEsMC4xMywwLjAzLDAuMiwwLjA1YzAuMDcsMC4wMiwwLjEzLDAuMDQsMC4xNiwwLjA1YzAuMTYsMC4wNiwwLjM0LDAuMTUsMC40NiwwLjIzYzAuMDksMC4wNiwwLjE4LDAuMTMsMC4yNiwwLjIKCQkJYzAuMDcsMC4wNiwwLjExLDAuMSwwLjE2LDAuMTZsMC4wNywwLjA4bDAuMDUsMC4wNWwwLjA5LDAuMTFjMC4wNCwwLjA2LDAuMDgsMC4xMSwwLjExLDAuMTdsMC4wNywwLjEzCgkJCWMwLjA4LDAuMTYsMC4xMiwwLjI3LDAuMTYsMC4zN2MwLjA3LDAuMiwwLjExLDAuMzUsMC4xNSwwLjUxYzAuMDcsMC4zLDAuMSwwLjU3LDAuMTEsMC44N2MwLjAxLDAuMjktMC4wMSwwLjYtMC4wNywwLjk0CgkJCWMtMC4wNywwLjM0LTAuMTgsMC43My0wLjQyLDEuMTRsLTIuODQsNC44OGwtMS4yMS01LjQ4Yy0wLjQ2LTIuMDctMC42NS00LjA5LTAuODctNmMtMC4yMS0xLjkyLTAuNDUtMy43NC0wLjkyLTUuNDVsMy40MywwLjY1CgkJCWMtMC4xMSwwLjE0LTAuMjMsMC4yOC0wLjMyLDAuNDFsLTAuMTIsMC4xNmMtMC4wMSwwLjAyLTAuMDIsMC4wMy0wLjAxLDBjMC4wMS0wLjAyLDAuMDItMC4wMywwLjA3LTAuMTQKCQkJYzAuMDItMC4wNiwwLjA3LTAuMTMsMC4xMS0wLjQ0YzAuMDEtMC4wNywwLjAxLTAuMTMsMC4wMi0wLjJsMC0wLjFsLTAuMDEtMC4xMmMtMC4wMS0wLjE2LTAuMDUtMC4zMy0wLjExLTAuNDhsLTAuMDUtMC4xMQoJCQlsLTAuMDMtMC4wNmwtMC4wNC0wLjA3Yy0wLjA3LTAuMTMtMC4xNi0wLjI2LTAuMjYtMC4zOGMtMC4xLTAuMTItMC4yMi0wLjIyLTAuMzUtMC4zMWMtMC4xMy0wLjA5LTAuMjItMC4xNC0wLjM0LTAuMTkKCQkJYy0wLjIyLTAuMS0wLjUtMC4xNS0wLjctMC4xNWMtMC4xMSwwLTAuMjIsMC0wLjMzLDAuMDJjLTAuMTEsMC4wMS0wLjI0LDAuMDUtMC4yNiwwLjA2Yy0wLjA5LDAuMDItMC4xOSwwLjA3LTAuMjUsMC4wOQoJCQljLTAuMDQsMC4wMi0wLjA4LDAuMDQtMC4xMiwwLjA2Yy0wLjA3LDAuMDQtMC4xLDAuMDYtMC4xNCwwLjA4bC0wLjA3LDAuMDVsLTAuMDQsMC4wM2MtMC4wNCwwLjAzLTAuMDUsMC4wNC0wLjA2LDAuMDUKCQkJYy0wLjAxLDAuMDEtMC4wMSwwLjAxLDAsMGMwLjAyLTAuMDEsMC4wNC0wLjA0LDAuMDYtMC4wNmMwLjAxLTAuMDIsMC4wMi0wLjAzLDAsMC4wMmMtMC4wMSwwLjAzLTAuMDMsMC4wNy0wLjA2LDAuMTgKCQkJYy0wLjAxLDAuMDUtMC4wMywwLjEzLTAuMDQsMC4yM2MtMC4wMSwwLjEyLTAuMDIsMC4yNywwLjAyLDAuNDhsMy40MiwwLjhjLTEuMTMsMS40NS0yLjI4LDIuODYtMy40NCw0LjI1CgkJCWMtMS4xNywxLjM5LTIuMzMsMi43Ny0zLjUxLDQuMTNjLTIuMzUsMi43My00LjY0LDUuNDctNi44MSw4LjI4bC0xLjgzLDIuMzhsLTAuNTYtMi44NWwtMS4yOC02LjQ5bDEuODYsMC41NwoJCQljLTEuNzEsMS41LTMuMzksMy4wNS01LjA1LDQuNjJjLTEuNjcsMS41Ni0zLjMyLDMuMTUtNC45Nyw0Ljc1Yy0xLjY1LDEuNTktMy4yOSwzLjItNC45Nyw0Ljc3Yy0xLjY4LDEuNTctMy4zNywzLjEzLTUuMTEsNC42MwoJCQljMS41Ny0xLjY4LDMuMTEtMy4zNyw0LjYzLTUuMDlsNC41NS01LjE2YzEuNTItMS43MiwzLjA0LTMuNDQsNC41OS01LjE1YzEuNTYtMS42OSwzLjE1LTMuMzYsNC43OS01bDEuMzUtMS4zNWwwLjUxLDEuOTEKCQkJbDEuNyw2LjM5bC0yLjM5LTAuNDhjMi4wMi0zLjA1LDQuMjQtNS45NCw2LjQzLTguODFjMi4xOS0yLjg3LDQuNC01LjY5LDYuNDQtOC41OUw3MS4zNiw4MmwwLjc5LDQuNTUKCQkJYzAuMDUsMC4yNiwwLjA0LDAuNDYsMC4wMiwwLjYzYy0wLjAyLDAuMTUtMC4wNSwwLjI4LTAuMDcsMC4zOGMtMC4wNiwwLjItMC4xMiwwLjM0LTAuMTcsMC40NWMtMC4xMSwwLjIzLTAuMjEsMC4zOC0wLjMxLDAuNTMKCQkJYy0wLjEsMC4xNC0wLjIsMC4yNy0wLjMxLDAuNGMtMC4wNiwwLjA3LTAuMTIsMC4xNC0wLjIxLDAuMjJjLTAuMDUsMC4wNC0wLjA5LDAuMDktMC4xNywwLjE1bC0wLjA3LDAuMDVsLTAuMSwwLjA3CgkJCWMtMC4wNSwwLjAzLTAuMDksMC4wNi0wLjE3LDAuMWMtMC4wNSwwLjAzLTAuMDksMC4wNS0wLjE0LDAuMDdjLTAuMDcsMC4wMy0wLjE4LDAuMDgtMC4yNywwLjFjLTAuMDIsMC4wMS0wLjE1LDAuMDQtMC4yNywwLjA2CgkJCWMtMC4xMSwwLjAyLTAuMjMsMC4wMi0wLjM0LDAuMDJjLTAuMiwwLTAuNDktMC4wNi0wLjcxLTAuMTZjLTAuMTItMC4wNS0wLjIxLTAuMS0wLjM0LTAuMTljLTAuMTItMC4wOS0wLjI1LTAuMTktMC4zNS0wLjMxCgkJCWMtMC4xMS0wLjEyLTAuMTktMC4yNS0wLjI2LTAuMzhsLTAuMDQtMC4wN2wtMC4wMy0wLjA2bC0wLjA1LTAuMTJjLTAuMDYtMC4xNi0wLjEtMC4zMy0wLjExLTAuNDlsLTAuMDEtMC4wOGwwLTAuMDVsMC0wLjEKCQkJYzAtMC4wNywwLjAxLTAuMTQsMC4wMi0wLjIxYzAuMDUtMC4zMywwLjExLTAuNDMsMC4xMy0wLjUxYzAuMDctMC4xNiwwLjEtMC4yMSwwLjEzLTAuMjhjMC4wNi0wLjExLDAuMTEtMC4xOCwwLjE1LTAuMjUKCQkJYzAuMDgtMC4xMywwLjE1LTAuMjMsMC4yMi0wLjMzYzAuMTQtMC4xOSwwLjI2LTAuMzcsMC4zOS0wLjU0bDIuMjYtMy4wMmwxLjE3LDMuNjZjMC42NSwyLjA0LDAuOTksNC4wOCwxLjI5LDYuMDMKCQkJYzAuMywxLjk1LDAuNTcsMy44MSwxLjAyLDUuNTRsLTQuMDUtMC41OWMtMC4xNiwwLjMtMC4xMSwwLjMzLTAuMTMsMC4zYzAtMC4wMS0wLjAxLTAuMDQtMC4wMS0wLjA0YzAsMCwwLDAuMDEsMC4wMiwwLjA3CgkJCWMwLjAxLDAuMDMsMC4wMiwwLjA3LDAuMDcsMC4xNmwwLjA1LDAuMDhjMC4wMiwwLjA0LDAuMDUsMC4wOCwwLjA4LDAuMTJsMC4wNywwLjA5bDAuMDQsMC4wNGwwLjA2LDAuMDcKCQkJYzAuMDUsMC4wNSwwLjA3LDAuMDgsMC4xNCwwLjE0YzAuMDcsMC4wNywwLjE2LDAuMTMsMC4yNCwwLjE4YzAuMTEsMC4wNywwLjI4LDAuMTcsMC40MywwLjIyYzAuMDMsMC4wMSwwLjA5LDAuMDMsMC4xNSwwLjA1CgkJCWMwLjA2LDAuMDIsMC4xMiwwLjAzLDAuMTksMC4wNWMwLjEzLDAuMDMsMC4yNiwwLjA0LDAuMzgsMC4wNGMwLjI5LDAuMDEsMC42NC0wLjA2LDAuODgtMC4xN2MwLjEyLTAuMDUsMC4yNC0wLjExLDAuMzUtMC4xOAoJCQljMC4wNS0wLjA0LDAuMTEtMC4wNywwLjE2LTAuMTFsMC4xLTAuMDhjMC4wNi0wLjA1LDAuMTItMC4xMSwwLjE4LTAuMThjMC4wNS0wLjA1LDAuMTItMC4xNSwwLjE0LTAuMTcKCQkJYzAuMDYtMC4wOCwwLjExLTAuMTYsMC4xNS0wLjI0bDAuMDUtMC4wOWwwLjAzLTAuMDdjMC4wMi0wLjA0LDAuMDUtMC4xMiwwLjA1LTAuMTRjMC4wOS0wLjI3LDAuMDgtMC4zMywwLjA5LTAuMzgKCQkJYzAuMDEtMC4wOSwwLjAxLTAuMDgsMC4wMS0wLjA2YzAsMC4wNCwwLjAxLDAuMTUsMC4wMywwLjI2YzAuMDMsMC4yMywwLjA4LDAuNDksMC4xMywwLjc2bC00LjItMC43MQoJCQljMi40Mi00LjQ4LDQuOTMtOC45LDcuNDQtMTMuMjlsMy43NC02LjU5YzEuMjQtMi4xOSwyLjQ3LTQuMzksMy42OC02LjU5bDQuOS04Ljk3bDAuMDksMTAuMjdsMC4wOCw5LjVsLTUuMTEtMS4zOAoJCQljMS4xOS0yLjA3LDIuMzYtNC4xNywzLjUxLTYuMjdjMS4xNS0yLjExLDIuMjgtNC4yMywzLjQyLTYuMzVjMi4yNy00LjI1LDQuNTMtOC41Myw2Ljg0LTEyLjhsMi43Ni01LjFsMi4zMiw1LjI4CgkJCWMwLjI0LDAuNTQsMC4yNiwwLjkxLDAuMjgsMS4xOGMwLjAxLDAuMjgtMC4wMSwwLjQ2LTAuMDQsMC42MmMtMC4wNSwwLjMxLTAuMTEsMC41LTAuMTYsMC42NmMtMC4xMSwwLjMyLTAuMjEsMC41NC0wLjMxLDAuNzQKCQkJYy0wLjEsMC4yLTAuMjEsMC4zOS0wLjMzLDAuNThjLTAuMDYsMC4xLTAuMTMsMC4yLTAuMjIsMC4zMmMtMC4wNSwwLjA2LTAuMSwwLjEzLTAuMTksMC4yNGwtMC4wOCwwLjA5bC0wLjExLDAuMTJsLTAuMDcsMC4wNwoJCQlsLTAuMTIsMC4xMWwtMC4wNiwwLjA1bC0wLjExLDAuMDlsLTAuMTMsMC4wOWwtMC4wNywwLjA0bC0wLjE0LDAuMDhjLTAuMSwwLjA2LTAuMjEsMC4xMS0wLjMzLDAuMTVsLTAuMDgsMC4wM2wtMC4xMiwwLjA0CgkJCWMtMC4xNCwwLjA0LTAuMywwLjA4LTAuNDUsMC4xYy0wLjE1LDAuMDItMC4zMSwwLjAzLTAuNDYsMC4wMmMtMC4wOCwwLTAuMTUtMC4wMS0wLjIzLTAuMDJjLTAuMDIsMC0wLjEyLTAuMDEtMC4xOC0wLjAzCgkJCWMtMC4wNy0wLjAxLTAuMTMtMC4wMy0wLjItMC4wNGMtMC4yNy0wLjA3LTAuNTUtMC4xOC0wLjgtMC4zM2MtMC4xMi0wLjA4LTAuMjQtMC4xNi0wLjM0LTAuMjVjLTAuMDUtMC4wNC0wLjEtMC4wOS0wLjE1LTAuMTMKCQkJbC0wLjEtMC4xYy0wLjI1LTAuMjYtMC40Ni0wLjYtMC41OS0wLjk1bC0wLjA1LTAuMTNsLTAuMDMtMC4wOWwtMC4wMy0wLjFjLTAuMDItMC4wNy0wLjAzLTAuMTQtMC4wNC0wLjIxCgkJCWMtMC4wMi0wLjE0LTAuMDQtMC4yOC0wLjA0LTAuNDJjMC0wLjA3LDAtMC4xMiwwLTAuMThsMC4wMS0wLjE3bDAuMDEtMC4xM2wwLjAzLTAuMTZMOTgsNTYuODVsMC4wMi0wLjA5CgkJCWMwLjA1LTAuMiwwLjA5LTAuMywwLjEyLTAuMzdjMC4wNi0wLjE2LDAuMS0wLjI1LDAuMTUtMC4zNWMwLjA4LTAuMTgsMC4xNS0wLjMyLDAuMjItMC40NmMwLjE0LTAuMjgsMC4yNy0wLjUzLDAuNDEtMC43NwoJCQlsMi43OS01LjFsMi4zMSw1LjMyYzEuNjQsMy43OCwzLjg2LDcuNjEsNS40NiwxMmwtNC45OS0wLjZsNC44Ni03LjE5bDIuOTItNC4zM2wxLjk2LDQuODJsNS4yLDEyLjgxCgkJCWMxLjc0LDQuMjgsMy41LDguNTUsNS4xOSwxMi44NmwtNC43MiwwLjExYzAuNjItMS42NiwxLjI5LTMuMzcsMi4wNC01LjAybDIuMjgtNS4wNmwyLjIyLDVjMC44MSwxLjgzLDEuNjIsMy42NiwyLjM5LDUuNQoJCQljMC43OCwxLjg0LDEuNTUsMy42OSwyLjMsNS41NGw0LjQ4LDExLjA2bC0zLjY5LDAuMTFsMi40My02LjA4bDIuNDUtNi4wN2wxLjA3LTIuNjRsMS42NywyLjE5YzEuODYsMi40NCwzLjc0LDQuODgsNS41OSw3LjMzCgkJCWw1LjU2LDcuMzVsLTEuODUsMC41M2wwLjc0LTQuNzNsMC4zMy0yLjExbDEuMjUsMS42Nmw2LjM5LDguNTFsMy4xNyw0LjI3QzE2MS43NywxMTQuMjYsMTYyLjgyLDExNS42OCwxNjMuODcsMTE3LjEyeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik05MC4yMiw5NC4xMmMwLjE0LTAuNDEsMC4zMi0wLjgsMC40OS0xLjJjMC4xNy0wLjQsMC4zNS0wLjc5LDAuNTItMS4xOGMwLjM1LTAuNzgsMC43MS0xLjU3LDEuMDktMi4zNAoJCQljMC43NC0xLjU1LDEuNS0zLjA5LDIuMjktNC42MWMxLjU3LTMuMDUsMy4yLTYuMDYsNC44OC05LjA0bDEuMjEtMi4xNWwxLjE1LDIuMjVjMC43MiwxLjQxLDEuNCwyLjgyLDIuMTEsNC4yNGwyLjA3LDQuMjUKCQkJbC0yLjQ5LTAuMTVjMC44Ni0xLjMyLDEuNy0yLjY1LDIuNTctMy45NmMwLjg2LTEuMzIsMS43NC0yLjYyLDIuNjItMy45M2wxLjM3LTIuMDNsMC45MSwyLjE5YzEuMDEsMi40MSwxLjk3LDQuODUsMi44Nyw3LjMxCgkJCWwwLjY3LDEuODVsMC42MywxLjg3YzAuNDIsMS4yNSwwLjgxLDIuNSwxLjE3LDMuNzhjLTAuNzMtMS4xLTEuNDMtMi4yMi0yLjEtMy4zNWwtMS0xLjdsLTAuOTctMS43MQoJCQljLTEuMjctMi4yOS0yLjQ4LTQuNjEtMy42NS02Ljk1bDIuMjksMC4xNmMtMC44MiwxLjM1LTEuNjQsMi42OS0yLjQ3LDQuMDNjLTAuODIsMS4zNC0xLjY4LDIuNjYtMi41Miw0bC0xLjM4LDIuMThsLTEuMTEtMi4zNAoJCQlsLTIuMDMtNC4yN2MtMC42Ni0xLjQzLTEuMzQtMi44NS0xLjk5LTQuMjlsMi4zNiwwLjExYy0xLjgyLDIuOS0zLjY4LDUuNzctNS42LDguNjFjLTAuOTYsMS40Mi0xLjk0LDIuODItMi45NCw0LjIyCgkJCUM5Mi4yOCw5MS4zNiw5MS4yMyw5Mi43Myw5MC4yMiw5NC4xMnoiLz4KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNTkuMSwxMDcuNDdjMC41OS0wLjg5LDEuMTgtMS43NywxLjc4LTIuNjRjMC42LTAuODgsMS4yMS0xLjc1LDEuODItMi42MmMwLjYtMC44NywxLjIzLTEuNzMsMS44NS0yLjYKCQkJYzAuNjItMC44NywxLjI0LTEuNzMsMS44Ni0yLjU4bDAuNzItMC45OGwwLjMyLDEuMjFjMC4zMSwxLjE4LDAuNjQsMi4zNywwLjk0LDMuNTVjMC4zMSwxLjE5LDAuNiwyLjM4LDAuODksMy41NgoJCQljMC4yOSwxLjE5LDAuNTgsMi4zOCwwLjg1LDMuNTdjMC4yOCwxLjE5LDAuNTUsMi4zOSwwLjgyLDMuNThsLTEuNDUtMC4yNGMwLjgzLTEuMzEsMS42Ni0yLjYxLDIuNS0zLjkxCgkJCWMwLjg0LTEuMywxLjctMi41OCwyLjU3LTMuODdjMC40My0wLjY1LDAuODctMS4yOCwxLjMxLTEuOTJjMC40NC0wLjY0LDAuODgtMS4yOCwxLjMzLTEuOTFjMC44OS0xLjI3LDEuOC0yLjUyLDIuNzQtMy43NgoJCQljLTAuNjgsMS4zOS0xLjQxLDIuNzctMi4xNCw0LjEzYy0wLjM2LDAuNjktMC43NCwxLjM2LTEuMTEsMi4wNGMtMC4zNywwLjY4LTAuNzUsMS4zNi0xLjEzLDIuMDNjLTAuNzcsMS4zNC0xLjUzLDIuNjktMi4zMiw0LjAyCgkJCWMtMC43OSwxLjMzLTEuNTgsMi42Ni0yLjM4LDMuOThsLTEuMDEsMS42NmwtMC40NC0xLjljLTAuMjgtMS4xOS0wLjU2LTIuMzgtMC44My0zLjU4Yy0wLjI3LTEuMTktMC41NC0yLjM5LTAuOC0zLjU5CgkJCWMtMC4yNi0xLjItMC41MS0yLjM5LTAuNzYtMy42Yy0wLjI1LTEuMi0wLjQ4LTIuNC0wLjcxLTMuNjFsMS4wNCwwLjIzYy0wLjY3LDAuODMtMS4zNCwxLjY0LTIuMDMsMi40NgoJCQljLTAuNjgsMC44MS0xLjM1LDEuNjQtMi4wNSwyLjQ0Yy0wLjY5LDAuODEtMS4zNywxLjYyLTIuMDcsMi40MkM2MC41MSwxMDUuODcsNTkuODEsMTA2LjY3LDU5LjEsMTA3LjQ3eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xMjUuNjUsMTAyLjIzYzAuODIsMS4xNiwxLjYzLDIuMzQsMi40MywzLjUyYzAuNzksMS4xOSwxLjU5LDIuMzcsMi4zNywzLjU3YzAuNzksMS4xOSwxLjU2LDIuNCwyLjMyLDMuNjEKCQkJbDEuMTUsMS44MWwxLjEzLDEuODNsLTEuMywwLjE2YzAuNDEtMS40NSwwLjgxLTIuOSwxLjI0LTQuMzRsMS4yNy00LjMzbDEuMzItNC4zMWMwLjQzLTEuNDQsMC45LTIuODcsMS4zNS00LjNsMC4zOS0xLjIyCgkJCWwwLjgzLDAuOTRjMC45NSwxLjA4LDEuOTEsMi4xNiwyLjg0LDMuMjVjMC45NCwxLjA5LDEuODgsMi4xOCwyLjgxLDMuMjljMC45MywxLjEsMS44NSwyLjIxLDIuNzcsMy4zMgoJCQljMC45MSwxLjExLDEuODIsMi4yNCwyLjcsMy4zOGMtMS4wNS0wLjk5LTIuMDktMS45OS0zLjEyLTNjLTEuMDMtMS4wMS0yLjA1LTIuMDMtMy4wNi0zLjA1Yy0xLjAyLTEuMDItMi4wMi0yLjA2LTMuMDItMy4wOQoJCQljLTEuMDEtMS4wMy0yLTIuMDctMi45OC0zLjEybDEuMjItMC4yOGMtMC40MSwxLjQ1LTAuODEsMi45LTEuMjQsNC4zNGwtMS4yNyw0LjMzbC0xLjMyLDQuMzFjLTAuNDMsMS40NC0wLjksMi44Ny0xLjM2LDQuMwoJCQlsLTAuNSwxLjU3bC0wLjgxLTEuNGwtMS4wNi0xLjg1bC0xLjA0LTEuODZjLTAuNy0xLjI0LTEuMzktMi40OS0yLjA3LTMuNzRjLTAuNjktMS4yNS0xLjM2LTIuNTEtMi4wMy0zLjc4CgkJCUMxMjYuOTUsMTA0LjgsMTI2LjMsMTAzLjUyLDEyNS42NSwxMDIuMjN6Ii8+Cgk8L2c+CjwvZz4KPC9zdmc+Cg=="
         alt="">
    <div class="headerSection">
        <div class="invoiceDetails">
            <h2>Бронирование #{{ \Arr::get($data, 'id') }}</h2>
            <div>
                {{ \Arr::get($data, 'date') }}
            </div>
        </div>
    </div>
    <!-- The two header rows are divided by an blue line, we use the HR element for this. -->
    <hr/>
    <div class="headerSection">
        <div>
            <h3>Жилье</h3>
            <div>
                <b>{{Arr::get($data, 'apartment.address')}}</b>
            </div>
            <p>
                <b>Владелец: {{ Arr::get($data, 'apartment.user.name') }}</b>
                <br/>
                @if($email = Arr::get($data, 'apartment.user.email'))
                    {{$email}}
                @endif
                <br/>
                @if($phone = Arr::get($data, 'apartment.user.phone'))
                    {{$phone}}
                @endif
            </p>
        </div>
        <br>
        <div class="dates">
            <h3>Гость</h3>
            <p>
                <b>{{ Arr::get($data, 'user.name') }}</b>
                <br/>
                @if($email = Arr::get($data, 'user.email'))
                    {{$email}}
                @endif
                <br/>
                @if($phone = Arr::get($data, 'user.phone'))
                    {{$phone}}
                @endif
            </p>
            <br>
            <p>
                Гостей: {{Arr::get($data, 'guests.total_guests')}}@if($children = Arr::get($data, 'guests.children'))
                    , Взрослые: {{Arr::get($data, 'guests.guests')}}, Дети: {{$children}}
                @endif
            </p>
        </div>
        <br>
        <div class="dates">
            <h3>Даты</h3>
            <p>
                <b>{{Arr::get($data, 'dates')}}</b>
            </p>
            <p>
                {{Arr::get($data, 'range')}}
            </p>
        </div>
    </div>
</div>

<!-- In the .main section the table for the separate items is added. Also we add another table for the summary, so subtotal, tax and total amount. -->
<div class="main">
    <table>
        <!-- A THEAD element is used to ensure the header of the table is repeated if it consumes more than one page. -->
        <thead>
        <tr>
            <th>Описание</th>
            <th>Цена</th>
        </tr>
        </thead>
        <!-- The single invoice items are all within the TBODY of the table. -->
        <tbody>
        <tr>
            <td>
                <b>Оплата проживания</b>
                <br/>
                {{Arr::get($data, 'range')}}
            </td>
            <td>
                {{Arr::get($data, 'price')}}
            </td>
        </tr>
        <tr>
            <td>
                <b>Предоплата</b>
                <br/>
                Уже внесено вами
            </td>
            <td>
                {{Arr::get($data, 'first_payment')}}
            </td>
        </tr>
        <tr>
            <td>
                <b>Остаток</b>
                <br/>
                Необходимо оплатить при заселении
            </td>
            <td>
                {{Arr::get($data, 'remainder')}}
            </td>
        </tr>
        </tbody>
    </table>
</div>
<hr/>
<div>
    <div>
        В случае возникновения каких-либо вопросов - обращайтесь к администрации сайта <b>©{{ config('app.name') }}</b>.
    </div>
</div>

</body>
</html>
