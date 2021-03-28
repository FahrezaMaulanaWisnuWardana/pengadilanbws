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
			$this->load->model('User_model','u_model');
		}
		function index(){
			$data['judul']="Laporan";
			$data['ruangan'] = $this->rmodel->read()->result_array();
			$this->load->view('dashboard/report/index',$data);
		}
		function type($jenis){
			if ($jenis==="ruangan") {
				$data['judul']="Laporan Ruangan";
				$data['ruangan'] = $this->rmodel->read()->result_array();
				$this->load->view('dashboard/report/list-room-report',$data);
			}elseif ($jenis==="permintaan") {
				$data['judul']="Laporan Permintaan";
				$data['ruangan'] = $this->rmodel->read()->result_array();
				$this->load->view('dashboard/report/list-req-report',$data);
			}else{
				show_404();
			}
		}
		function detail($jenis,$id){
			if ($jenis==="ruangan") {
				$data['judul']="Laporan";
				$data['ruangan'] = $this->rmodel->read(['room_id'=>$id])->row_array();
				$data['user'] = $this->u_model->user_by_room(['user_room.room_id'=>$id])->result_array();
				$data['pimpinan'] = $this->r_model->user()->result_array();
				$this->load->view('dashboard/report/detail',$data);	
			}elseif($jenis==="permintaan"){
				$data['judul']="Laporan Permintaan";
				$data['ruangan'] = $this->rmodel->read(['room_id'=>$id])->row_array();
				$this->load->view('dashboard/report/detail-permintaan',$data);
			}else{
				show_404();
			}
		}
		function request(){

			$data['ruangan'] = $this->r_model->ruangan(['room_id'=>$this->input->post('room_id')])->row_array();
			$style = array(
			    'alignment' => [
			    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			    ]
		    );
		    $outline = [
		    	'borders' => [
			        'outline' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '00000000'],
			        ],
			    ]
			];
		    $styleArray = [
		    	'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '00000000'],
			        ],
			    ]
			];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1','Laporan Permintaan '.strtoupper($data['ruangan']['room_name']));
			$sheet->getRowDimension('1')->setRowHeight(35);
			$sheet->getStyle('A1')->applyFromArray($style);
			$sheet->getStyle('A1')->getFont()->setBold(true);

			$sheet->mergeCells("A1:H1");
			$cell = 'A';
			for ($i=0; $i <= 8 ; $i++) { 
				$cell++;
				$sheet->getColumnDimension($cell)->setAutoSize(true);
			}
			$sheet->setCellValue('A2','No');
			$sheet->getStyle('A2')->applyFromArray($style);
			$sheet->getStyle('A2')->applyFromArray($styleArray);
			$sheet->getStyle('A2')->getFont()->setBold(true);
			$sheet->setCellValue('B2','Judul Permintaan');
			$sheet->getStyle('B2')->applyFromArray($style);
			$sheet->getStyle('B2')->applyFromArray($styleArray);
			$sheet->getStyle('B2')->getFont()->setBold(true);
			$sheet->setCellValue('C2','Perwakilan');
			$sheet->getStyle('C2')->applyFromArray($style);
			$sheet->getStyle('C2')->applyFromArray($styleArray);
			$sheet->getStyle('C2')->getFont()->setBold(true);
			$sheet->setCellValue('D2','Petugas');
			$sheet->getStyle('D2')->applyFromArray($style);
			$sheet->getStyle('D2')->applyFromArray($styleArray);
			$sheet->getStyle('D2')->getFont()->setBold(true);
			$sheet->setCellValue('E2','Permintaan');
			$sheet->getStyle('E2')->applyFromArray($style);
			$sheet->getStyle('E2')->applyFromArray($styleArray);
			$sheet->getStyle('E2')->getFont()->setBold(true);
			$sheet->setCellValue('F2','Tanggal Permintaan');
			$sheet->getStyle('F2')->applyFromArray($style);
			$sheet->getStyle('F2')->applyFromArray($styleArray);
			$sheet->getStyle('F2')->getFont()->setBold(true);
			$sheet->setCellValue('G2','Tanggal Respon');
			$sheet->getStyle('G2')->applyFromArray($style);
			$sheet->getStyle('G2')->applyFromArray($styleArray);
			$sheet->getStyle('G2')->getFont()->setBold(true);
			$sheet->setCellValue('H2','Hasil');
			$sheet->getStyle('H2')->applyFromArray($style);
			$sheet->getStyle('H2')->applyFromArray($styleArray);
			$sheet->getStyle('H2')->getFont()->setBold(true);

			$data['lap'] = ($this->input->post('tgl_awal')!=="" && $this->input->post('tgl_akhir')!=="")?$this->r_model->laporan_permintaan('DATE(user_request.created_at) BETWEEN "'.strftime('%Y-%m-%d', strtotime($this->input->post('tgl_awal'))).'" AND "'.strftime('%Y-%m-%d', strtotime($this->input->post('tgl_akhir'))).'" AND user_request.room_id="'.$this->input->post('room_id').'"')->result_array() : $this->r_model->laporan_permintaan(['user_request.room_id'=>$this->input->post('room_id')])->result_array();
			$no = 0;
			$cell = 2;
			foreach ($data['lap'] as $req) {
				$no++;
				$cell++;
				$sheet->setCellValue('A'.$cell,$no);
				$sheet->getStyle('A'.$cell)->applyFromArray($style);
				$sheet->getStyle('A'.$cell)->applyFromArray($styleArray);
				$sheet->setCellValue('B'.$cell,$req['judul']);
				$sheet->getStyle('B'.$cell)->applyFromArray($style);
				$sheet->getStyle('B'.$cell)->applyFromArray($styleArray);
				$sheet->setCellValue('C'.$cell,$req['full_name']);
				$sheet->getStyle('C'.$cell)->applyFromArray($style);
				$sheet->getStyle('C'.$cell)->applyFromArray($styleArray);
				$sheet->setCellValue('D'.$cell,$req['name_req']);
				$sheet->getStyle('D'.$cell)->applyFromArray($style);
				$sheet->getStyle('D'.$cell)->applyFromArray($styleArray);
				$sheet->setCellValue('E'.$cell,$req['request']);
				$sheet->getStyle('E'.$cell)->applyFromArray($style);
				$sheet->getStyle('E'.$cell)->applyFromArray($styleArray);
				$sheet->setCellValue('F'.$cell,strftime('%d-%m-%Y', strtotime($req['created_at'])));
				$sheet->getStyle('F'.$cell)->applyFromArray($style);
				$sheet->getStyle('F'.$cell)->applyFromArray($styleArray);
				($req['tgl_respon']===NULL)?$tgl = '':$tgl=strftime('%d-%m-%Y', strtotime($req['tgl_respon']));
				$sheet->setCellValue('G'.$cell,$tgl);
				$sheet->getStyle('G'.$cell)->applyFromArray($style);
				$sheet->getStyle('G'.$cell)->applyFromArray($styleArray);
				if ($req['status']==='1') {
					$status='';
				}elseif($req['status']==='2'){
					$status='Diterima';
				}elseif($req['status']==='3'){
					$status='Stok Habis';
				}
				$sheet->setCellValue('H'.$cell,$status);
				$sheet->getStyle('H'.$cell)->applyFromArray($style);
				$sheet->getStyle('H'.$cell)->applyFromArray($styleArray);
			}

			$colSpv=1;
			for ($spv=1; $spv<=$no+4; $spv++) { 
				$colSpv++;
			}

			$sheet->setCellValueByColumnAndRow($spv-2,$cell+2,'Mengetahui');
			$sheet->setCellValueByColumnAndRow($spv-2,$cell+3,'Kab Sub Bagian Umum dan Keuangan');
			$sheet->setCellValueByColumnAndRow($spv-2,$cell+8,'TTD');
			$sheet->setCellValueByColumnAndRow($spv-2,$cell+9,''.$data['lap'][0]['name_lead'].'');
			$sheet->setCellValueByColumnAndRow($spv-2,$cell+10,'NIP.'.$data['lap'][0]['nip'].'');

			$ttdKnowAwal = $sheet->getCellByColumnAndRow($spv-2,$cell+2)->getCoordinate();
			$ttdKnowAkhir = $sheet->getCellByColumnAndRow($spv,$cell+2)->getCoordinate();
			$sheet->mergeCells("$ttdKnowAwal:$ttdKnowAkhir");
			$ttdKabAwal = $sheet->getCellByColumnAndRow($spv-2,$cell+3)->getCoordinate();
			$ttdKabAkhir = $sheet->getCellByColumnAndRow($spv,$cell+3)->getCoordinate();
			$sheet->mergeCells("$ttdKabAwal:$ttdKabAkhir");
			$ttdAwal = $sheet->getCellByColumnAndRow($spv-2,$cell+8)->getCoordinate();
			$ttdAkhir = $sheet->getCellByColumnAndRow($spv,$cell+8)->getCoordinate();
			$sheet->mergeCells("$ttdAwal:$ttdAkhir");
			$ttdNamaAwal = $sheet->getCellByColumnAndRow($spv-2,$cell+9)->getCoordinate();
			$ttdNamaAkhir = $sheet->getCellByColumnAndRow($spv,$cell+9)->getCoordinate();
			$sheet->mergeCells("$ttdNamaAwal:$ttdNamaAkhir");
			$ttdNipAwal = $sheet->getCellByColumnAndRow($spv-2,$cell+10)->getCoordinate();
			$ttdNipAkhir = $sheet->getCellByColumnAndRow($spv,$cell+10)->getCoordinate();
			$sheet->mergeCells("$ttdNipAwal:$ttdNipAkhir");
			$sheet->getStyle("A1:$ttdNipAkhir")->applyFromArray($style);
			$sheet->getStyle("A1:$ttdNipAkhir")->applyFromArray($outline);

			$writer = new Xlsx($spreadsheet);
			$filename='Laporan-'.date('Y-m');
			ob_end_clean();
			header('Content-Type:application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx');
			header('Cache-Control:max-age=0');
			$writer->save('php://output');
		}
		function cetak(){
			$data['ruangan'] = $this->r_model->ruangan(['room_id'=>$this->input->post('room_id')])->row_array();
			$data['tugas'] = $this->r_model->tugas(['room_id'=>$this->input->post('room_id')])->result_array();
			$data['user'] = $this->r_model->user(['user_id'=>$this->input->post('user_id')])->row_array();
			$data['pimpinan'] = $this->r_model->user(['id_role'=>'4','user_id'=>$this->input->post('pimpinan_id')])->row_array();
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
							if ($tgl == strftime('%d', strtotime($field['date'])) && $field['task_id']===$dataTugas['task_id']) {
								$sheet->setCellValueByColumnAndRow($colCek+$i-1,$current_row-1,'✓');
								if ($field['score']==='1') {
									$sheet->getStyle($colCek,$current_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
								}else if($field['score']==='2'){
									$sheet->getStyle($colCek,$current_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF3498DB');
									$sheet->getStyle($colCek,$current_row)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}else if($field['score']==='3'){
									$sheet->getStyle($colCek,$current_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1C40F');
									$sheet->getStyle($colCek,$current_row)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}else if($field['score']==='4'){
									$sheet->getStyle($colCek,$current_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF2ECC71');
									$sheet->getStyle($colCek,$current_row)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}
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
							if ($tgl == strftime('%d', strtotime($field['date']))) {
								$sheet->setCellValueByColumnAndRow($colCek+$i-1,$current_row-1,'✓');
								$coloring =  $sheet->getCellByColumnAndRow($colCek+$i-1,$current_row-1)->getCoordinate();
								if($field['score']==='2'){
									$sheet->getStyle($coloring)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF3498DB');
									$sheet->getStyle($coloring)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}else if($field['score']==='3'){
									$sheet->getStyle($coloring)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1C40F');
									$sheet->getStyle($coloring)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}else if($field['score']==='4'){
									$sheet->getStyle($coloring)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF2ECC71');
									$sheet->getStyle($coloring)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
								}
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