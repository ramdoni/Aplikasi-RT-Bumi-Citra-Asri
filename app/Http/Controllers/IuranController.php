<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Warga;
use App\Iuran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Style\Protection;
use \PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use \PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class IuranController extends Controller
{
    public function index()
    {
        $data = new \stdClass;
        $param = Warga::orderBy('nama');

        if(@$_GET['search']!="") $param = $param->where('nama','LIKE',"%".$_GET['search']."%");

        $param = $param->get();

        foreach($param as $k => $i){
            $data->$k = new \stdClass(); 
            
            $data->$k->id = $i->id;
            $data->$k->nama = $i->nama;
            $data->$k->januari = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',1)->count();
            $data->$k->februari = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',2)->count();
            $data->$k->maret = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',3)->count();
            $data->$k->april = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',4)->count();
            $data->$k->mei = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',5)->count();
            $data->$k->juni = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',6)->count();
            $data->$k->juli = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',7)->count();
            $data->$k->agustus = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',8)->count();
            $data->$k->september = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',9)->count();
            $data->$k->oktober = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',10)->count();
            $data->$k->november = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',11)->count();
            $data->$k->desember = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',12)->count();
        }

        return Inertia::render('Iuran/Index', [
            'filters' => Request::all('search', 'trashed'),
            'iurans' => $data,
            'wargas'=>Warga::orderBy('nama')->get()
        ]);
    }

    public function downloadExcel()
    {
        
        // Create new PHPExcel object
        $objPHPExcel = new Spreadsheet();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Stalavista System")
                                     ->setLastModifiedBy("Stalavista System")
                                     ->setTitle("Office 2007 XLSX Product Database")
                                     ->setSubject("Iuran Database")
                                     ->setDescription("Iuran Database.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Iuran");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Iuran RT 01/12 Bumi Citra Asri');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',date('d F Y'));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(false);
        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'No')
                    ->setCellValue('B3', 'Nama')
                    ->setCellValue('C3', 'Januari')
                    ->setCellValue('D3', 'Februari')
                    ->setCellValue('E3', 'Maret')
                    ->setCellValue('F3', 'April')
                    ->setCellValue('G3', 'Mei')
                    ->setCellValue('H3', 'Juni')
                    ->setCellValue('I3', 'Juli')
                    ->setCellValue('J3', 'Agustus')
                    ->setCellValue('K3', 'September')
                    ->setCellValue('L3', 'Oktober')
                    ->setCellValue('M3', 'November')
                    ->setCellValue('N3', 'Desember')
                    ;

        $objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('e2efd9');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

        $param = Warga::orderBy('nama');
        if(@$_GET['search']!="") $param = $param->where('nama','LIKE',"%".$_GET['search']."%");

        $param = $param->get();
        $num=4;
        foreach($param as $k => $i){
            
            $januari = $this->cek_iuran($i,1,date('Y'));
            $februari = $this->cek_iuran($i,2,date('Y'));
            $maret = $this->cek_iuran($i,3,date('Y'));
            $april = $this->cek_iuran($i,4,date('Y'));
            $mei = $this->cek_iuran($i,5,date('Y'));
            $juni = $this->cek_iuran($i,6,date('Y'));
            $juli = $this->cek_iuran($i,7,date('Y'));
            $agustus = $this->cek_iuran($i,8,date('Y'));
            $september = $this->cek_iuran($i,9,date('Y'));
            $oktober = $this->cek_iuran($i,10,date('Y'));
            $november = $this->cek_iuran($i,11,date('Y'));
            $desember = $this->cek_iuran($i,11,date('Y'));

            $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$num, $k+1)
                  ->setCellValue('B'.$num, $i->nama)
                  ->setCellValue('C'.$num, ($januari?date('d/m/Y',strtotime($januari->created_at)):'-') )
                  ->setCellValue('D'.$num, ($februari?date('d/m/Y',strtotime($februari->created_at)):'-') )
                  ->setCellValue('E'.$num, ($maret?date('d/m/Y',strtotime($maret->created_at)):'-') )
                  ->setCellValue('F'.$num, ($april?date('d/m/Y',strtotime($april->created_at)):'-') )
                  ->setCellValue('G'.$num, ($mei?date('d/m/Y',strtotime($mei->created_at)):'-') )
                  ->setCellValue('H'.$num, ($juni?date('d/m/Y',strtotime($juni->created_at)):'-') )
                  ->setCellValue('I'.$num, ($juli?date('d/m/Y',strtotime($juli->created_at)):'-') )
                  ->setCellValue('J'.$num, ($agustus?date('d/m/Y',strtotime($agustus->created_at)):'-') )
                  ->setCellValue('K'.$num, ($september?date('d/m/Y',strtotime($september->created_at)):'-') )
                  ->setCellValue('L'.$num, ($oktober?date('d/m/Y',strtotime($oktober->created_at)):'-') )
                  ->setCellValue('M'.$num, ($november?date('d/m/Y',strtotime($november->created_at)):'-') )
                  ->setCellValue('N'.$num, ($desember?date('d/m/Y',strtotime($desember->created_at)):'-') )
                  ;
            $num++;
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Iuran-'. date('d-M-Y'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Iuran-' .date('d-M-Y') .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        //header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        return $writer->save('php://output');
    }

    public function cek_iuran($user,$month,$year)
    {
        $iuran = Iuran::where('warga_id',$user->id)->where('tahun',$year)->where('bulan',$month)->first();

        return $iuran;
    }

    public function storeFormIuran()
    {
        $data = new Iuran();
        $data->warga_id = Request::get('warga_id');
        $data->tahun = date('Y');
        $data->bulan = Request::get('bulan');
        $data->created_at = date('Y-m-d H:i:s',strtotime(Request::get('tanggal')));
        $data->save();

        $id = $data->id;
        $warga = Warga::where('id',Request::get('warga_id'))->first();
            
        $monthName = date("F", mktime(0, 0, 0,Request::get('bulan') , 10));
        $minimal_iuran = 50000;

        $kwitansi = "E/".date('dmy')."/".$warga->blok_rumah .'-'. $warga->nomor."/IU/".$id;
        Iuran::where('id',$id)->update(['admin_user_id'=>\Auth::user()->id,'kwitansi'=>$kwitansi]);

        $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : Bp. ".$warga->nama." Blok ".$warga->blok_rumah .'-'. $warga->nomor." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
        $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
        $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";
 
        wa(['p'=>$warga->no_telepon,'m'=>$msg]);
        wa(['p'=>'081284884586','m'=>$msg]);

        return Redirect::back()->with('success', 'Iuran berhasil dibayarkan.');    
    }

    public function bayar(){
        $id = Iuran::create(
            Request::validate([
                    'warga_id' => ['required'],
                    'bulan' => ['required'],
                    'tahun' => ['required'],
                ]))->id;

        $warga = Warga::where('id',Request::get('warga_id'))->first();
            
        $monthName = date("F", mktime(0, 0, 0,Request::get('bulan') , 10));
        $minimal_iuran = 50000;

        $kwitansi = "E/".date('dmy')."/".$warga->blok_rumah .'-'. $warga->nomor."/IU/".$id;
        Iuran::where('id',$id)->update(['admin_user_id'=>\Auth::user()->id,'kwitansi'=>$kwitansi]);

        $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : Bp. ".$warga->nama." Blok ".$warga->blok_rumah .'-'. $warga->nomor." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
        $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
        $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";

        wa(['p'=>$warga->no_telepon,'m'=>$msg]);
        wa(['p'=>'081284884586','m'=>$msg]);

        return 200;
        return Redirect::back()->with('success', 'Iuran berhasil dibayarkan.');    
    }
}