<!DOCTYPE html>
<html>
<head>
	<title>Label Pesanan</title>
<style type="text/css">

table {
  border-collapse: collapse;
}

table, th, td {
	border: 1px solid black;
}

body { 
  background: url("{{ URL::to('/').'/layout/assets/img/bgnote.png' }}") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.page-break {
    page-break-after: always;
}

ul {
	padding-left: 8px;
}

hr {
       display: block;
       color: red;
       position: relative;
       padding: 0;
       margin: 8px auto;
       height: 0;
       width: 100%;
       max-height: 0;
       font-size: 1px;
       line-height: 0;
       clear: both;
       border: none;
       border-top: 1px solid #aaaaaa;
       border-bottom: 1px solid #ffffff;
}

</style>

</head>

<body>

    <div style="text-align: justify; font-size: 12px">
        <p style="width:100%"> {!! $setting->formatNoteByName($setting->getSetting()->customer_note, $data->nama_pelanggan)  !!}</p>
    </div>

</body>

</html>