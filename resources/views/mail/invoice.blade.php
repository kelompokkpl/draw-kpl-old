<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 28px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    .label {
      color: white;
      padding: 8px;
      float: right !important;
    }

    .success {background-color: #04AA6D;} /* Green */
    .info {background-color: #2196F3;} /* Blue */
    .warning {background-color: #ff9800;} /* Orange */
    .danger {background-color: #f44336;} /* Red */
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box" style=" max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;">
        <span class="label danger" style="margin-right: 10px">UNPAID</span>
        <br><br>
        <table cellpadding="0" cellspacing="0" style="width: 100%;
        line-height: inherit;
        text-align: left;">
            <tr class="top">
                <td colspan="2" style="padding: 5px;
        vertical-align: top;">
                    <table style="width: 100%;
        line-height: inherit;
        text-align: left;">
                        <tr>
                            <td class="title" style="padding: 5px;
        vertical-align: top; padding-bottom: 20px; font-size: 28px;
        line-height: 45px;
        color: #333;">
                                Invoice #{{$code}} from Draw System
                            </td>
                            
                            <td style="padding: 5px;
        vertical-align: top; text-align: right; padding-bottom: 20px;">
                                Invoice #: {{$code}}<br>
                                Created: {{$date}}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;
        line-height: inherit;
        text-align: left;">
                        <tr>
                            <td style="padding: 5px;
        vertical-align: top; padding-bottom: 40px;"><br>
                                 Event name: <br>{{$event_name}}
                            </td>
                            
                            <td style="padding: 5px;
        vertical-align: top; text-align: right; padding-bottom: 40px;">
                                <b>Invoiced to:</b><br>
                                {{$name}}<br>
                                {{$email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="padding: 5px;
        vertical-align: top; background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;">
                    Item
                </td>
                
                <td style="padding: 5px;
        vertical-align: top; text-align: right; background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;">
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td style="padding: 5px;
        vertical-align: top; border-bottom: 1px solid #eee;">
                    Draw (1 event)
                </td>
                
                <td style="padding: 5px;
        vertical-align: top; text-align: right; border-bottom: 1px solid #eee;">
                    Rp100.000
                </td>
            </tr>
            
            <tr class="total">
                <td style="padding: 5px;
        vertical-align: top;"></td>
                
                <td style="padding: 5px;
        vertical-align: top; text-align: right; border-top: 2px solid #eee;
        font-weight: bold;">
                   Total: Rp100.000
                </td>
            </tr>

            <tr class="item">
                <td style="padding: 5px;
        vertical-align: top; border-bottom: 1px solid #eee;" colspan="2">
                    Transfer to:
                    <br>Draw Eventy - 88222222 (BCA)
                </td>
            </tr>

        </table>
    </div>
</body>
</html>