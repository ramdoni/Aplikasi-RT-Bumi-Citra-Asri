<?php

namespace App\Http\Livewire\Iuran;

use Livewire\Component;
use \App\Models\Iuran;
use \App\Models\Warga;
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

class Index extends Component
{
    public $keyword,$tahun;
    protected $listeners = ['submit-bayar-iuran'=>'submitBayarIuran','refresh-page'=>'$refresh'];
    public function render()
    {
        $param = Warga::orderBy('nama','ASC');
        if($this->keyword) $param = $param->where('nama','LIKE',"%{$this->keyword}%");
        $param = $param->get();
        $data = [];
        foreach($param as $k => $i){
            $data[$k]['id'] = $i->id;
            $data[$k]['nama'] = $i->nama;
            $data[$k]['blok_rumah'] = $i->blok_rumah;
            $data[$k]['nomor'] = $i->nomor;
            $data[$k]['januari'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',1)->count();
            $data[$k]['februari'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',2)->count();
            $data[$k]['maret'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',3)->count();
            $data[$k]['april'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',4)->count();
            $data[$k]['mei'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',5)->count();
            $data[$k]['juni'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',6)->count();
            $data[$k]['juli'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',7)->count();
            $data[$k]['agustus'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',8)->count();
            $data[$k]['september'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',9)->count();
            $data[$k]['oktober'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',10)->count();
            $data[$k]['november'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',11)->count();
            $data[$k]['desember'] = Iuran::where('warga_id',$i->id)->where('tahun',$this->tahun)->where('bulan',12)->count();
        }

        return view('livewire.iuran.index')->with(['data'=>$data]);
    }
    public function mount()
    {
        $this->tahun = date('Y');
    }
    public function submitBayarIuran($data)
    {
        $iuran = new Iuran();
        $iuran->warga_id = $data['id'];
        $iuran->bulan = $data['month'];
        $iuran->tahun = $this->tahun;
        $iuran->save();

        $warga = Warga::find($data['id']);
            
        $monthName = $data['bulan'];
        $minimal_iuran = 50000;

        $kwitansi = "E/".date('dmy')."/".$warga->blok_rumah .'-'. $warga->nomor."/IU/".$iuran->id;
        $iuran->admin_user_id = \Auth::user()->id;
        $iuran->kwitansi = $kwitansi;
        $iuran->save();

        $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : Bp. ".$warga->nama." Blok ".$warga->blok_rumah .'-'. $warga->nomor." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
        $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
        $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";
        $this->emit('refresh-page');
        //wa(['p'=>$warga->no_telepon,'m'=>$msg]);
        //wa(['p'=>'081284884586','m'=>$msg]);
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
                    ->setCellValue('C3', 'Blok')
                    ->setCellValue('D3', 'Januari')
                    ->setCellValue('E3', 'Februari')
                    ->setCellValue('F3', 'Maret')
                    ->setCellValue('G3', 'April')
                    ->setCellValue('H3', 'Mei')
                    ->setCellValue('I3', 'Juni')
                    ->setCellValue('J3', 'Juli')
                    ->setCellValue('K3', 'Agustus')
                    ->setCellValue('L3', 'September')
                    ->setCellValue('M3', 'Oktober')
                    ->setCellValue('N3', 'November')
                    ->setCellValue('O3', 'Desember');
        $objPHPExcel->getActiveSheet()->getStyle('A3:O3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:O3')->getFill()
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

        $param = Warga::orderBy('nama');
        $find_tahun = date('Y');
        if(@$_GET['search']!="") $param = $param->where('nama','LIKE',"%".$_GET['search']."%");
        if(@$_GET['tahun']!="") $find_tahun = $_GET['tahun'];

        $param = $param->get();
        $num=4;
        foreach($param as $k => $i){
            
            $januari = $this->cek_iuran($i,1,$find_tahun);
            $februari = $this->cek_iuran($i,2,$find_tahun);
            $maret = $this->cek_iuran($i,3,$find_tahun);
            $april = $this->cek_iuran($i,4,$find_tahun);
            $mei = $this->cek_iuran($i,5,$find_tahun);
            $juni = $this->cek_iuran($i,6,$find_tahun);
            $juli = $this->cek_iuran($i,7,$find_tahun);
            $agustus = $this->cek_iuran($i,8,$find_tahun);
            $september = $this->cek_iuran($i,9,$find_tahun);
            $oktober = $this->cek_iuran($i,10,$find_tahun);
            $november = $this->cek_iuran($i,11,$find_tahun);
            $desember = $this->cek_iuran($i,11,$find_tahun);

            $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$num, $k+1)
                  ->setCellValue('B'.$num, $i->nama)
                  ->setCellValue('C'.$num, $i->blok_rumah .'-'. $i->nomor)
                  ->setCellValue('D'.$num, ($januari?date('d/m/Y',strtotime($januari->created_at)):'-') )
                  ->setCellValue('E'.$num, ($februari?date('d/m/Y',strtotime($februari->created_at)):'-') )
                  ->setCellValue('F'.$num, ($maret?date('d/m/Y',strtotime($maret->created_at)):'-') )
                  ->setCellValue('G'.$num, ($april?date('d/m/Y',strtotime($april->created_at)):'-') )
                  ->setCellValue('H'.$num, ($mei?date('d/m/Y',strtotime($mei->created_at)):'-') )
                  ->setCellValue('I'.$num, ($juni?date('d/m/Y',strtotime($juni->created_at)):'-') )
                  ->setCellValue('J'.$num, ($juli?date('d/m/Y',strtotime($juli->created_at)):'-') )
                  ->setCellValue('K'.$num, ($agustus?date('d/m/Y',strtotime($agustus->created_at)):'-') )
                  ->setCellValue('L'.$num, ($september?date('d/m/Y',strtotime($september->created_at)):'-') )
                  ->setCellValue('M'.$num, ($oktober?date('d/m/Y',strtotime($oktober->created_at)):'-') )
                  ->setCellValue('N'.$num, ($november?date('d/m/Y',strtotime($november->created_at)):'-') )
                  ->setCellValue('O'.$num, ($desember?date('d/m/Y',strtotime($desember->created_at)):'-') )
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
        return response()->streamDownload(function() use($writer){
            $writer->save('php://output');
        },'Iuran-' .date('d-M-Y') .'.xlsx');

        //return $writer->save('php://output');
    }

    public function cek_iuran($user,$month,$year)
    {
        $iuran = Iuran::where('warga_id',$user->id)->where('tahun',$year)->where('bulan',$month)->first();

        return $iuran;
    }
}
