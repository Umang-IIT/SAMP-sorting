<?php
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadsheet = $reader->load("Copy of Mentorship Programme 2021.xlsx");

    $mentee=$spreadsheet->getSheet(3)->toArray();
    $mentor = $spreadsheet->getSheet(0)->toArray();

    $spreadsheet = new Spreadsheet(); 
    $sorted_mentor_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Mentor');
    $spreadsheet->addSheet($sorted_mentor_sheet,1);
    $sorted_mentee_sheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Mentee1');
    $spreadsheet->addSheet($sorted_mentee_sheet1,2);
    $sorted_mentee_sheet2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Mentee2');
    $spreadsheet->addSheet($sorted_mentee_sheet2,3);
    $allotment_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Allotment');
    $spreadsheet->addSheet($allotment_sheet,4);
    

    $sorted_mentee_sheet = $spreadsheet->getSheet(0);
    $sorted_mentor_sheet = $spreadsheet->getSheet(1);
    $sorted_mentee_sheet1 = $spreadsheet->getSheet(2);
    $sorted_mentee_sheet2 = $spreadsheet->getSheet(3);
    $allotment_index = $spreadsheet->getSheet(4);

    // sorting mentee on based of 1st preference
    $index = 1;

    for($k=1;$k<=28;$k++){
        for($i=0;$i<count($mentee);$i++){
            $row  = $mentee[$i];
            if($mentee[$i][11] === $k){
                //echo $k;
                for($j=1;$j<=count($row);$j++){
                    $sorted_mentee_sheet->setCellValueByColumnAndRow($j,$index,$mentee[$i][$j-1]);
                }
                $index++;
            }
        }
    }

    // sorting mentee on based of 2nd preference
    $index = 1;

    for($k=1;$k<=28;$k++){
        for($i=0;$i<count($mentee);$i++){
            $row  = $mentee[$i];
            if($mentee[$i][12] === $k){
                for($j=1;$j<=count($row);$j++){
                    $sorted_mentee_sheet1->setCellValueByColumnAndRow($j,$index,$mentee[$i][$j-1]);
                }
                $index++;
            }
        }
    }

    // sorting mentee on based of 3rd preference
    $index = 1;

    for($k=1;$k<=28;$k++){
        for($i=0;$i<count($mentee);$i++){
            $row  = $mentee[$i];
            if($mentee[$i][13] === $k){
                for($j=1;$j<=count($row);$j++){
                    $sorted_mentee_sheet2->setCellValueByColumnAndRow($j,$index,$mentee[$i][$j-1]);
                }
                $index++;
            }
        }
    }
    
    // sorting mentor on based of 1st preference
    $index = 1;

    for($k=1;$k<=28;$k++){
        for($i=0;$i<count($mentor);$i++){
            $row  = $mentor[$i];
            if($mentor[$i][10] === $k){
                for($j=1;$j<=count($row);$j++){
                    $sorted_mentor_sheet->setCellValueByColumnAndRow($j,$index,$mentor[$i][$j-1]);
                }
                $index++;
            }
        }
    }

    // Allotment Algorithm

    $sorted_mentee_sheet_array = $sorted_mentee_sheet->toArray();
    $sorted_mentor_sheet_array = $sorted_mentor_sheet->toArray(); 
    $sorted_mentee_sheet1_array = $sorted_mentee_sheet1->toArray();
    $sorted_mentee_sheet2_array = $sorted_mentee_sheet2->toArray();

    $allotment_index = array();

    for($i=0;$i<count($sorted_mentee_sheet_array);$i++){
        $allotment_index[$i] = -1;
    }

    // alloting each mentor atleast one mentee
    for($i=0;$i<count($sorted_mentor_sheet_array);$i++){
        // alloting if have same preference and Department
        $temp = -1;
        for($j=0;$j<count($sorted_mentee_sheet_array);$j++){
            if($allotment_index[$sorted_mentee_sheet_array[$j][0]-1]==-1&&$sorted_mentee_sheet_array[$j][11]==$sorted_mentor_sheet_array[$i][10]&&$sorted_mentee_sheet_array[$j][6]==$sorted_mentor_sheet_array[$i][6]){
                $allotment_index[$sorted_mentee_sheet_array[$j][0]-1] = $i;
                $temp = $i;
                $sorted_mentor_sheet_array[$i][9]--;
                break;
            }
        }
        // alloting if have same 1st preference
        if($temp==-1){
            for($j=0;$j<count($sorted_mentee_sheet_array);$j++){
                if($allotment_index[$sorted_mentee_sheet_array[$j][0]-1]==-1&&$sorted_mentee_sheet_array[$j][11]==$sorted_mentor_sheet_array[$i][10]){
                    $allotment_index[$sorted_mentee_sheet_array[$j][0]-1] = $i;
                    $temp = $i;
                    $sorted_mentor_sheet_array[$i][9]--;
                    break;
                }
            }
        }
        // alloting if have same 2nd preference
        if($temp==-1){
            for($j=0;$j<count($sorted_mentee_sheet_array);$j++){
                if($allotment_index[$sorted_mentee_sheet_array[$j][0]-1]==-1&&$sorted_mentee_sheet_array[$j][12]==$sorted_mentor_sheet_array[$i][10]){
                    $allotment_index[$sorted_mentee_sheet_array[$j][0]-1] = $i;
                    $temp = $i;
                    $sorted_mentor_sheet_array[$i][9]--;
                    break;
                }
            }
        }
        // alloting if have same 3rd preference
        if($temp==-1){
            for($j=0;$j<count($sorted_mentee_sheet_array);$j++){
                if($allotment_index[$sorted_mentee_sheet_array[$j][0]-1]==-1&&$sorted_mentee_sheet_array[$j][13]==$sorted_mentor_sheet_array[$i][10]){
                    $allotment_index[$sorted_mentee_sheet_array[$j][0]-1] = $i;
                    $temp = $i;
                    $sorted_mentor_sheet_array[$i][9]--;
                    break;
                }
            }
        }
    }


    // alloting if have same 1st preference
    $p=0;
    $q=0;
    while($p<count($sorted_mentee_sheet_array)&&$q<count($sorted_mentor_sheet_array)){
        if($allotment_index[$sorted_mentee_sheet_array[$p][0]-1]==-1){
            if($sorted_mentor_sheet_array[$q][9]==0) $q++;
            else{
                if($sorted_mentee_sheet_array[$p][11]==$sorted_mentor_sheet_array[$q][10]){
                    $allotment_index[$sorted_mentee_sheet_array[$p][0]-1] = $q;
                    $sorted_mentor_sheet_array[$q][9]--;
                    $p++;
                }
                else if($sorted_mentee_sheet_array[$p][11]<$sorted_mentor_sheet_array[$q][10])  $p++;
                else $q++;

                
            }
        }
        else $p++;
    }
    
    // alloting if have same 2nd preference
    $p=0;
    $q=0;
    while($p<count($sorted_mentee_sheet1_array)&&$q<count($sorted_mentor_sheet_array)){
        if($allotment_index[$sorted_mentee_sheet1_array[$p][0]-1]==-1){
            if($sorted_mentor_sheet_array[$q][9]==0) $q++;
            else{
                if($sorted_mentee_sheet1_array[$p][12]==$sorted_mentor_sheet_array[$q][10]){
                    $allotment_index[$sorted_mentee_sheet1_array[$p][0]-1] = $q;
                    $sorted_mentor_sheet_array[$q][9]--;
                    $p++;
                }
                else if($sorted_mentee_sheet1_array[$p][11]<$sorted_mentor_sheet_array[$q][10])  $p++;
                else $q++;

                
            }
        }
        else $p++;
    }

    // alloting if have same 3rd preference
    $p=0;
    $q=0;
    while($p<count($sorted_mentee_sheet2_array)&&$q<count($sorted_mentor_sheet_array)){
        if($allotment_index[$sorted_mentee_sheet2_array[$p][0]-1]==-1){
            if($sorted_mentor_sheet_array[$q][9]==0) $q++;
            else{
                if($sorted_mentee_sheet2_array[$p][13]==$sorted_mentor_sheet_array[$q][10]){
                    $allotment_index[$sorted_mentee_sheet2_array[$p][0]-1] = $q;
                    $sorted_mentor_sheet_array[$q][9]--;
                    $p++;
                }
                else if($sorted_mentee_sheet2_array[$p][11]<$sorted_mentor_sheet_array[$q][10])  $p++;
                else $q++;

                
            }
        }
        else $p++;
    }


    
    // inserting in final sheet
    for($i=0;$i<count($allotment_index);$i++){
        $allotment_sheet->setCellValueByColumnAndRow(1,$i+1,$i + 1);
        $allotment_sheet->setCellValueByColumnAndRow(2,$i+1,$sorted_mentee_sheet_array[$i][3]);
        $allotment_sheet->setCellValueByColumnAndRow(3,$i+1,$sorted_mentee_sheet_array[$i][4]);
        $allotment_sheet->setCellValueByColumnAndRow(4,$i+1,$sorted_mentor_sheet_array[$allotment_index[$i]][3]);
        $allotment_sheet->setCellValueByColumnAndRow(5,$i+1,$sorted_mentor_sheet_array[$allotment_index[$i]][4]);
        $allotment_sheet->setCellValueByColumnAndRow(6,$i+1,$sorted_mentor_sheet_array[$allotment_index[$i]][14]);
        $allotment_sheet->setCellValueByColumnAndRow(7,$i+1,$sorted_mentor_sheet_array[$allotment_index[$i]][15]);
    }

    echo implode(" ",$allotment_index);

    echo " ".count($allotment_sheet->toArray());
    
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet); 
  
    // Save .xlsx file to the files directory 
    $writer->save('SAMP.xlsx'); 
