<?php 
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	class Report extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			is_logged_in();
			$this->load->model('Room_model','rmodel');
			$this->load->model('Report_model','r_model');
		}
		function index(){
			$data['judul']="Laporan";
			$data['ruangan'] = $this->rmodel->read()->result_array();
			$this->load->view('dashboard/report/index',$data);
		}
		function detail($room_id){
			$data['judul']="Laporan";
			$data['ruangan'] = $this->rmodel->read(['room_id'=>$room_id])->row_array();
			$data['user'] = $this->r_model->user()->result_array();
			$this->load->view('dashboard/report/detail',$data);	
		}
		function cetak(){
			$data['ruangan'] = $this->r_model->ruangan(['room_id'=>$this->input->post('room_id')])->row_array();
			$data['tugas'] = $this->r_model->tugas(['room_id'=>$this->input->post('room_id')])->result_array();
			$data['user'] = $this->r_model->user(['user_id'=>$this->input->post('user_id')])->row_array();
			$data['pimpinan'] = $this->r_model->user(['id_role'=>'4'])->row_array();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$style = array(
			    'alignment' => [
			    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			    ]
		    );
		    $styleArray = [
		    	'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '00000000'],
			        ],
			    ]
			];
		    $outline = [
		    	'borders' => [
			        'outline' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '00000000'],
			        ],
			    ]
			];
		    $bottom = [
		    	'borders' => [
			        'bottom' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '00000000'],
			        ],
			    ]
			];
			if ($this->input->post('tgl_awal')!=="" && $this->input->post('tgl_akhir')!=="") {
				$query = $this->r_model->laporan('DATE(date) BETWEEN "'.strftime('%Y-%m-%d', strtotime($this->input->post('tgl_awal'))).'" AND "'.strftime('%Y-%m-%d', strtotime($this->input->post('tgl_akhir'))).'" AND room_id="'.$this->input->post('room_id').'" AND user_id="'.$this->input->post('user_id').'"' )->result_array();
				$data['cetak'] = $query;
				$d1 = $this->input->post('tgl_awal');
			    $d2 = $this->input->post('tgl_akhir');
			    $awl = round(abs(strtotime($d1))/86400);
			    $akhir = round(abs(strtotime($d2))/86400);
			    if($awl>$akhir){
			        $this->session->set_flashdata(array(
			            'message' => 'Tanggal tidak valid',
			            'type' => 'danger'
			        ));
			        header('Location: ' . $_SERVER['HTTP_REFERER']);
			    }elseif (strftime('%m', strtotime($this->input->post('tgl_awal'))) < strftime('%m', strtotime($this->input->post('tgl_akhir')))) {
			        $this->session->set_flashdata(array(
			            'message' => 'Bulan tidak valid',
			            'type' => 'danger'
			        ));
			        header('Location: ' . $_SERVER['HTTP_REFERER']);
			    }
			    function dateDiff ($d1, $d2) {
				    return round(abs(strtotime($d1) - strtotime($d2))/86400);
				}
			    $selisih = dateDiff($d1,$d2);


				$sheet->setCellValue('A1','CEKLIST '.strtoupper($data['ruangan']['room_name']));
			    $column = 'A';
			    for ($a=0; $a <= date('t'); $a++) { 
			    	$column++;
			    	$sheet->getColumnDimension($column)->setAutoSize(true);
			    }
			    $column=$column.'1';
				$sheet->mergeCells("A1:$column");
				$sheet->getStyle('A1')->applyFromArray($style);
				$sheet->getStyle('A1')->getFont()->setSize(12);
				$sheet->getRowDimension('1')->setRowHeight(35);
				$sheet->getStyle('A1')->getFont()->setBold(true);

				// Petugas dan bulan
				$sheet->setCellValue('A2','Nama Petugas : '.$data['user']['username']);
				$sheet->mergeCells("A2:B2");
				$sheet->setCellValue('A3','Bulan : '.date('F'));
				$sheet->mergeCells("A3:B3");

				// Header
				$sheet->setCellValue('A5','No.');
				$sheet->setCellValue('A4','Laporan Tanggal : '.strftime('%d/%m/%Y', strtotime($this->input->post('tgl_awal'))).' - '.strftime('%d/%m/%Y', strtotime($this->input->post('tgl_akhir'))));
				// $sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
				$sheet->mergeCells("A4:J4");
				$sheet->setCellValue('B5','Uraian Tugas');

			    // Tugas
			    $current_col = 2;
			    $current_row = 6;
			    $no = 1;
			    foreach ($data['tugas'] as $dataTugas) {
			    	$sheet->setCellValueByColumnAndRow(1,$current_row,$no++);
			    	$sheet->setCellValueByColumnAndRow($current_col,$current_row,$dataTugas['task']);
					$sheet->getStyle($current_col,$current_row)->getFont()->setSize(12);
					$sheet->getStyle($current_col,$current_row)->applyFromArray($style);
			    	$current_row++;
				    // Tanggal
				    $columnTgl = 2;
				    $rowTgl = 5;
					for ($i=1; $i <= date('t'); $i++) {
						$columnTgl++;
						$sheet->setCellValueByColumnAndRow($columnTgl,$rowTgl,$i);
						$sheet->getStyle($columnTgl,$rowTgl)->applyFromArray($style);
						$sheet->getStyle($columnTgl,$rowTgl)->getFont()->setSize(12);
						// Cek tugas
						($i <= 9)?$tgl = '0'.$i:$tgl = $i;
						$colCek = 3;
						foreach ($data['cetak'] as $field) {
							if ($tgl === strftime('%d', strtotime($field['date'])) && $field['task_id']===$dataTugas['task_id']) {
								$sheet->setCellValueByColumnAndRow($colCek+$i-1,$current_row-1,'✓');
								$sheet->getStyle($colCek,$current_row)->getFont()->setSize(12);
							}
						}
					}

			    }

				    $one = 1;
					$sheet->setCellValueByColumnAndRow($one,$current_row,'Supervisi(paraf)');
					$awal =  $sheet->getCellByColumnAndRow($one,$current_row)->getCoordinate();
					$akhir = $sheet->getCellByColumnAndRow($one+1,$current_row)->getCoordinate();
					$sheet->mergeCells("$awal:$akhir");

					$colSpv = 3;
					for ($spv=1; $spv<= date('t'); $spv++) { 
						$sheet->setCellValueByColumnAndRow($colSpv,$current_row,'');
						$akhiran = $sheet->getCellByColumnAndRow($colSpv,$current_row)->getCoordinate();
						$colSpv++;
					}

					$akhiran_tugas = $sheet->getCellByColumnAndRow($columnTgl,$rowTgl+$no)->getCoordinate();
					
					$sheet->getStyle("A5:$akhiran_tugas")->applyFromArray($styleArray);

					$sheet->setCellValueByColumnAndRow($spv-10,$current_row+2,'Mengetahui');
					$sheet->setCellValueByColumnAndRow($spv-10,$current_row+3,'Kab Sub Bagian Umum dan Keuangan');
					$sheet->setCellValueByColumnAndRow($spv-10,$current_row+8,'TTD');
					$sheet->setCellValueByColumnAndRow($spv-10,$current_row+9,''.$data['pimpinan']['full_name'].'');
					$sheet->setCellValueByColumnAndRow($spv-10,$current_row+10,'NIP.'.$data['pimpinan']['nip'].'');

					$ttdKnowAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+2)->getCoordinate();
					$ttdKnowAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+2)->getCoordinate();
					$sheet->mergeCells("$ttdKnowAwal:$ttdKnowAkhir");
					$ttdKabAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+3)->getCoordinate();
					$ttdKabAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+3)->getCoordinate();
					$sheet->mergeCells("$ttdKabAwal:$ttdKabAkhir");
					$ttdAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+8)->getCoordinate();
					$ttdAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+8)->getCoordinate();
					$sheet->mergeCells("$ttdAwal:$ttdAkhir");
					$ttdNamaAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+9)->getCoordinate();
					$ttdNamaAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+9)->getCoordinate();
					$sheet->mergeCells("$ttdNamaAwal:$ttdNamaAkhir");
					$ttdNipAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+10)->getCoordinate();
					$ttdNipAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+10)->getCoordinate();
					$sheet->mergeCells("$ttdNipAwal:$ttdNipAkhir");
					$sheet->getStyle("A1:$ttdNipAkhir")->applyFromArray($outline);

			}else{
				$query = $this->r_model->laporan('MONTH(date)=MONTH(CURDATE()) AND YEAR(date)=YEAR(CURDATE()) AND room_id="'.$this->input->post('room_id').'" AND user_id="'.$this->input->post('user_id').'"')->result_array();
				$data['cetak'] = $query;


				$sheet->setCellValue('A1','CEKLIST '.strtoupper($data['ruangan']['room_name']));
			    $column = 'A';
			    for ($a=0; $a <= date('t') ; $a++) { 
			    	$column++;
			    	$sheet->getColumnDimension($column)->setAutoSize(true);
			    }
			    $column=$column.'1';
				$sheet->mergeCells("A1:$column");
				$sheet->getStyle('A1')->applyFromArray($style);
				$sheet->getStyle('A1')->getFont()->setSize(12);
				$sheet->getRowDimension('1')->setRowHeight(35);
				$sheet->getStyle('A1')->getFont()->setBold(true);

				// Petugas dan bulan
				$sheet->setCellValue('A2','Nama Petugas : '.$data['user']['username']);
				$sheet->mergeCells("A2:B2");
				$sheet->setCellValue('A3','Bulan : '.date('F'));
				$sheet->mergeCells("A3:B3");

				// Header
				$sheet->setCellValue('A5','No.');
				$sheet->setCellValue('B5','Uraian Tugas');

			    // Tugas
			    $current_col = 2;
			    $current_row = 6;
			    $no = 1;
			    foreach ($data['tugas'] as $dataTugas) {
			    	$sheet->setCellValueByColumnAndRow(1,$current_row,$no++);
			    	$sheet->setCellValueByColumnAndRow($current_col,$current_row,$dataTugas['task']);
					$sheet->getStyle($current_col,$current_row)->getFont()->setSize(12);
					$sheet->getStyle($current_col,$current_row)->applyFromArray($style);
			    	$current_row++;
				    // Tanggal
				    $columnTgl = 2;
				    $rowTgl = 5;
					for ($i=1; $i <= date('t'); $i++) {
						$columnTgl++;
						$sheet->setCellValueByColumnAndRow($columnTgl,$rowTgl,$i);
						$sheet->getStyle($columnTgl,$rowTgl)->applyFromArray($style);
						$sheet->getStyle($columnTgl,$rowTgl)->getFont()->setSize(12);
						// Cek tugas
						($i <= 9)?$tgl = '0'.$i:$tgl = $i;
						$colCek = 3;
						foreach ($data['cetak'] as $field) {
							if ($tgl === strftime('%d', strtotime($field['date'])) && $field['task_id']===$dataTugas['task_id']) {
								$sheet->setCellValueByColumnAndRow($colCek+$i-1,$current_row-1,'✓');
								$sheet->getStyle($colCek,$current_row)->getFont()->setSize(12);
							}
						}
					}

			    }
			    $one = 1;
				$sheet->setCellValueByColumnAndRow($one,$current_row,'Supervisi(paraf)');
				$awal =  $sheet->getCellByColumnAndRow($one,$current_row)->getCoordinate();
				$akhir = $sheet->getCellByColumnAndRow($one+1,$current_row)->getCoordinate();
				$sheet->mergeCells("$awal:$akhir");

				$colSpv = 3;
				for ($spv=1; $spv <= date('t') ; $spv++) { 
					$sheet->setCellValueByColumnAndRow($colSpv,$current_row,'');
					$akhiran = $sheet->getCellByColumnAndRow($colSpv,$current_row)->getCoordinate();
					$colSpv++;
				}

				$akhiran_tugas = $sheet->getCellByColumnAndRow($columnTgl,$rowTgl+$no)->getCoordinate();
				$sheet->getStyle("A5:$akhiran_tugas")->applyFromArray($styleArray);

				$sheet->setCellValueByColumnAndRow($spv-10,$current_row+2,'Mengetahui');
				$sheet->setCellValueByColumnAndRow($spv-10,$current_row+3,'Kab Sub Bagian Umum dan Keuangan');
				$sheet->setCellValueByColumnAndRow($spv-10,$current_row+8,'TTD');
				$sheet->setCellValueByColumnAndRow($spv-10,$current_row+9,''.$data['pimpinan']['full_name'].'');
				$sheet->setCellValueByColumnAndRow($spv-10,$current_row+10,'NIP.'.$data['pimpinan']['nip'].'');

				$ttdKnowAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+2)->getCoordinate();
				$ttdKnowAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+2)->getCoordinate();
				$sheet->mergeCells("$ttdKnowAwal:$ttdKnowAkhir");
				$ttdKabAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+3)->getCoordinate();
				$ttdKabAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+3)->getCoordinate();
				$sheet->mergeCells("$ttdKabAwal:$ttdKabAkhir");
				$ttdAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+8)->getCoordinate();
				$ttdAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+8)->getCoordinate();
				$sheet->mergeCells("$ttdAwal:$ttdAkhir");
				$ttdNamaAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+9)->getCoordinate();
				$ttdNamaAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+9)->getCoordinate();
				$sheet->mergeCells("$ttdNamaAwal:$ttdNamaAkhir");
				$ttdNipAwal = $sheet->getCellByColumnAndRow($spv-10,$current_row+10)->getCoordinate();
				$ttdNipAkhir = $sheet->getCellByColumnAndRow($spv+1,$current_row+10)->getCoordinate();
				$sheet->mergeCells("$ttdNipAwal:$ttdNipAkhir");
				$sheet->getStyle("A1:$ttdNipAkhir")->applyFromArray($outline);
			}

			$writer = new Xlsx($spreadsheet);
			$filename='Laporan-'.date('Y-m');
			ob_end_clean();
			header('Content-Type:application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx');
			header('Cache-Control:max-age=0');
			$writer->save('php://output');
		}
	}
 ?>