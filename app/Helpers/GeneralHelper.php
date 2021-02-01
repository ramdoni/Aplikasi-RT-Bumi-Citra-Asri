<?php

function cek_iuran($id,$bulan){
    $iuran = \App\Models\Iuran::where('warga_id',$id)->where('tahun',date('Y'))->where('bulan',$bulan)->first();

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

function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}


function umur($tanggal_lahir){
    $birthDate = new \DateTime($tanggal_lahir);
	$today = new \DateTime("today");
	if ($birthDate > $today) { 
	    return 0;
    }

    $tahun = $today->diff($birthDate)->y;
    return $tahun;
}

function month()
{
    $month = [1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"];

    return $month;
}
function replace_idr($nominal)
{
    if($nominal == "") return 0;

    $nominal = str_replace('Rp. ', '', $nominal);
    $nominal = str_replace(' ', '', $nominal);
    $nominal = str_replace('.', '', $nominal);
    $nominal = str_replace(',', '', $nominal);
    $nominal = str_replace('-', '', $nominal);
    $nominal = str_replace('(', '', $nominal);
    $nominal = str_replace(')', '', $nominal);

    return (int)$nominal;
}
function get_group_cashflow($key="")
{
    $data = [1=>'Operation Activities',2=>'Investment Activities',3=>'Financing Activities'];
    if($key!="") return @$data[$key];
    
    return $data;
}

function generate_no_voucher_konven_underwriting($coa_id)
{
    $coa = \App\Models\Coa::find($coa_id);
    $count = \App\Models\KonvenUnderwriting::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    
    if($coa) return $coa->code_voucher.'-'.str_pad($count,3, '0', STR_PAD_LEFT).'/'.date('m').'/'.date('Y');

    return '';
}
function generate_no_voucher($coa_id="",$count="")
{
    $coa = \App\Models\Coa::find($coa_id);
    if(empty($count)) 
        $count = \App\Models\Journal::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    if($coa) 
        return $coa->code_voucher.'-'.str_pad($count,3, '0', STR_PAD_LEFT).'/'.date('m').'/'.date('Y');

    return '';
}
function format_idr($number)
{
    if(empty($number)) return 0;
    $number = (int) $number;
    return number_format($number,0,0,'.');
}
function get_setting($key)
{
    $setting = \App\Models\Settings::where('key',$key)->first();

    if($setting)
    {
        if($key=='logo' || $key=='favicon' ){
            return  asset("storage/{$setting->value}");
        }

        return $setting->value;
    }
}
function update_setting($key,$value)
{
    $setting = \App\Models\Settings::where('key',$key)->first();
    if($setting){
        $setting->value = $value;
        $setting->save();
    }else{
        $setting = new \App\Models\Settings();
        $setting->key = $key;
        $setting->value = $value;
        $setting->save();
    }
}