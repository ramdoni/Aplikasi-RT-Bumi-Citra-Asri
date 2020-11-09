<?php

function cek_iuran($id,$bulan){
    $iuran = \App\Iuran::where('warga_id',$id)->where('tahun',date('Y'))->where('bulan',$bulan)->first();

    if($iuran) 
        return "Lunas ( ".date('d F Y', strtotime($iuran->created_at))." )";
    else
        return "Belum";
}

function wa($param){
    $message = strip_tags($param['m']);
    $message = $message;
    $number = str_replace_first('0','62', $param['p']);
    $number = str_replace('-', '', $number);
    
    $curl = curl_init(); 
    $token = env('TOKEN_WA');
    $data = [
        'phone' => $number,
        'message' => $message,
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Authorization: ". $token,
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://console.wablas.com/api/send-message");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);
}

function format_idr($number){
    return number_format($number,0,0,'.');
}

function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}