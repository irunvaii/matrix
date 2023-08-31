<?php

if (!defined('OK_LOADME')) {
    die('o o p s !');
}

// ----------------------------
// Array of TimeZone
// ----------------------------
$timezones = array('Pacific/Midway' => "(UTC-11) Midway Island", 'US/Samoa' => "(UTC-11) Samoa", 'US/Hawaii' => "(UTC-10) Hawaii", 'US/Alaska' => "(UTC-09) Alaska", 'US/Pacific' => "(UTC-08) Pacific Time (US &amp; Canada)", 'America/Tijuana' => "(UTC-08) Tijuana", 'US/Arizona' => "(UTC-07) Arizona", 'US/Mountain' => "(UTC-07) Mountain Time (US &amp; Canada)", 'America/Chihuahua' => "(UTC-07) Chihuahua", 'America/Mazatlan' => "(UTC-07) Mazatlan", 'America/Mexico_City' => "(UTC-06) Mexico City", 'America/Monterrey' => "(UTC-06) Monterrey", 'Canada/Saskatchewan' => "(UTC-06) Saskatchewan", 'US/Central' => "(UTC-06) Central Time (US &amp; Canada)", 'US/Eastern' => "(UTC-05) Eastern Time (US &amp; Canada)", 'US/East-Indiana' => "(UTC-05) Indiana (East)", 'America/Bogota' => "(UTC-05) Bogota", 'America/Lima' => "(UTC-05) Lima", 'America/Caracas' => "(UTC-04:30) Caracas", 'Canada/Atlantic' => "(UTC-04) Atlantic Time (Canada)", 'America/La_Paz' => "(UTC-04) La Paz", 'America/Santiago' => "(UTC-04) Santiago", 'Canada/Newfoundland' => "(UTC-03:30) Newfoundland", 'America/Buenos_Aires' => "(UTC-03) Buenos Aires", 'Greenland' => "(UTC-03) Greenland", 'Atlantic/Stanley' => "(UTC-02) Stanley", 'Atlantic/Azores' => "(UTC-01) Azores", 'Atlantic/Cape_Verde' => "(UTC-01) Cape Verde Is.", 'UTC' => "(UTC) Coordinated Universal Time", 'Africa/Casablanca' => "(UTC) Casablanca", 'Europe/Dublin' => "(UTC) Dublin", 'Europe/Lisbon' => "(UTC) Lisbon", 'Europe/London' => "(UTC) London", 'Africa/Monrovia' => "(UTC) Monrovia", 'Europe/Amsterdam' => "(UTC+01) Amsterdam", 'Europe/Belgrade' => "(UTC+01) Belgrade", 'Europe/Berlin' => "(UTC+01) Berlin", 'Europe/Bratislava' => "(UTC+01) Bratislava", 'Europe/Brussels' => "(UTC+01) Brussels", 'Europe/Budapest' => "(UTC+01) Budapest", 'Europe/Copenhagen' => "(UTC+01) Copenhagen", 'Europe/Ljubljana' => "(UTC+01) Ljubljana", 'Europe/Madrid' => "(UTC+01) Madrid", 'Europe/Paris' => "(UTC+01) Paris", 'Europe/Prague' => "(UTC+01) Prague", 'Europe/Rome' => "(UTC+01) Rome", 'Europe/Sarajevo' => "(UTC+01) Sarajevo", 'Europe/Skopje' => "(UTC+01) Skopje", 'Europe/Stockholm' => "(UTC+01) Stockholm", 'Europe/Vienna' => "(UTC+01) Vienna", 'Europe/Warsaw' => "(UTC+01) Warsaw", 'Europe/Zagreb' => "(UTC+01) Zagreb", 'Europe/Athens' => "(UTC+02) Athens", 'Europe/Bucharest' => "(UTC+02) Bucharest", 'Africa/Cairo' => "(UTC+02) Cairo", 'Africa/Harare' => "(UTC+02) Harare", 'Europe/Helsinki' => "(UTC+02) Helsinki", 'Europe/Istanbul' => "(UTC+02) Istanbul", 'Asia/Jerusalem' => "(UTC+02) Jerusalem", 'Europe/Kiev' => "(UTC+02) Kyiv", 'Europe/Minsk' => "(UTC+02) Minsk", 'Europe/Riga' => "(UTC+02) Riga", 'Europe/Sofia' => "(UTC+02) Sofia", 'Europe/Tallinn' => "(UTC+02) Tallinn", 'Europe/Vilnius' => "(UTC+02) Vilnius", 'Asia/Baghdad' => "(UTC+03) Baghdad", 'Asia/Kuwait' => "(UTC+03) Kuwait", 'Africa/Nairobi' => "(UTC+03) Nairobi", 'Asia/Riyadh' => "(UTC+03) Riyadh", 'Europe/Moscow' => "(UTC+03) Moscow", 'Asia/Tehran' => "(UTC+03:30) Tehran", 'Asia/Baku' => "(UTC+04) Baku", 'Europe/Volgograd' => "(UTC+04) Volgograd", 'Asia/Muscat' => "(UTC+04) Muscat", 'Asia/Tbilisi' => "(UTC+04) Tbilisi", 'Asia/Yerevan' => "(UTC+04) Yerevan", 'Asia/Kabul' => "(UTC+04:30) Kabul", 'Asia/Karachi' => "(UTC+05) Karachi", 'Asia/Tashkent' => "(UTC+05) Tashkent", 'Asia/Kolkata' => "(UTC+05:30) Kolkata", 'Asia/Kathmandu' => "(UTC+05:45) Kathmandu", 'Asia/Yekaterinburg' => "(UTC+06) Ekaterinburg", 'Asia/Almaty' => "(UTC+06) Almaty", 'Asia/Dhaka' => "(UTC+06) Dhaka", 'Asia/Novosibirsk' => "(UTC+07) Novosibirsk", 'Asia/Bangkok' => "(UTC+07) Bangkok", 'Asia/Jakarta' => "(UTC+07) Jakarta", 'Asia/Krasnoyarsk' => "(UTC+08) Krasnoyarsk", 'Asia/Chongqing' => "(UTC+08) Chongqing", 'Asia/Hong_Kong' => "(UTC+08) Hong Kong", 'Asia/Kuala_Lumpur' => "(UTC+08) Kuala Lumpur", 'Australia/Perth' => "(UTC+08) Perth", 'Asia/Singapore' => "(UTC+08) Singapore", 'Asia/Taipei' => "(UTC+08) Taipei", 'Asia/Ulaanbaatar' => "(UTC+08) Ulaan Bataar", 'Asia/Urumqi' => "(UTC+08) Urumqi", 'Asia/Irkutsk' => "(UTC+09) Irkutsk", 'Asia/Seoul' => "(UTC+09) Seoul", 'Asia/Tokyo' => "(UTC+09) Tokyo", 'Australia/Adelaide' => "(UTC+09:30) Adelaide", 'Australia/Darwin' => "(UTC+09:30) Darwin", 'Asia/Yakutsk' => "(UTC+10) Yakutsk", 'Australia/Brisbane' => "(UTC+10) Brisbane", 'Australia/Canberra' => "(UTC+10) Canberra", 'Pacific/Guam' => "(UTC+10) Guam", 'Australia/Hobart' => "(UTC+10) Hobart", 'Australia/Melbourne' => "(UTC+10) Melbourne", 'Pacific/Port_Moresby' => "(UTC+10) Port Moresby", 'Australia/Sydney' => "(UTC+10) Sydney", 'Asia/Vladivostok' => "(UTC+11) Vladivostok", 'Asia/Magadan' => "(UTC+12) Magadan", 'Pacific/Auckland' => "(UTC+12) Auckland", 'Pacific/Fiji' => "(UTC+12) Fiji",);