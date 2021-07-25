<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class ApplicationFormController extends Controller
{

    public function createPDF(Request $request)
    {
        $pdf = new Fpdi();

        $pdf->AddPage();
        $fileContent = file_get_contents(asset('storage/pdf_templates/FINAL.TDP-FORM.pdf'),'rb');
        $pdf->setSourceFile(StreamReader::createByString($fileContent));
        $tmpl = $pdf->importPage(1);
        $pdf->useTemplate($tmpl, 0, 0, 215.9, 355.6, true);
        $pdf->SetFont('Arial', '', 10);

        // lastname
        $pdf->SetXY(41, 57);
        (strlen($request->lname) < 15)? $pdf->MultiCell(40.5, 7, $request->lname, 1, 'C') : $pdf->MultiCell(40.5, 4, $request->lname, 1, 'C');
        // $pdf->MultiCell(40.5, 7, 'OOOOOOOOOOOOOO', 1, 'C');//max 14 character lastname
        //$pdf->MultiCell(40.5, 4, 'OOO OO OOOOOO OOOOO OOOOOOO', 1, 'C');//max 28 character lastname

        // firstname
        $pdf->SetXY(81.5, 57);
        (strlen($request->fname) < 17)? $pdf->MultiCell(48, 7, $request->fname, 1, 'C') : $pdf->MultiCell(48, 4, $request->fname, 1, 'C');
        // $pdf->MultiCell(48, 7, 'OOOOOOOOOOOOOOOO', 1, 'C');//max 16 character firstname
        //$pdf->MultiCell(48, 4, 'OOO OO OOOOOO OOOOO OOOOOOO', 1, 'C');//max 32 character firstname

        // middlename
        $pdf->SetXY(129.5, 57);
        (strlen($request->mname) < 15)? $pdf->MultiCell(41.5, 7, $request->mname, 1, 'C') : $pdf->MultiCell(41.5, 4, $request->mname, 1, 'C');        
        // $pdf->MultiCell(41.5, 7, 'OOOOOOOOOOOOOO', 1, 'C');//max 14 character middlename
        //$pdf->MultiCell(41.5, 4, 'OOO OO OOOOOO OOOOO OOOOOOO', 1, 'C');//max 28 character middlename

        // maidenname
        $pdf->SetXY(171, 57);
        if(!$request->mdname){
            $pdf->MultiCell(32, 7, 'NA', 1, 'C');
        } else {
            (strlen($request->mdname) < 17)? $pdf->MultiCell(32, 7, $request->mdname, 1, 'C') : $pdf->MultiCell(32, 4, $request->mdname, 1, 'C');
        }
        // $pdf->MultiCell(32 , 7, 'OOOOOOOOOO', 1, 'C');//max 10 character maidenname
        //$pdf->MultiCell(32, 4, 'OOOOOOOOOOOOOOOOOOOO', 1, 'C');//max 20 character maidenname

        // birthdate
        $pdf->SetXY(41, 76.5);
        $pdf->MultiCell(40.5, 4, $request->bdate, 1, 'C');

        // birthplace
        $pdf->SetXY(41, 83.5);
        $pdf->MultiCell(40.5, 4, $request->bplace, 1, 'L');

        // street/brgy
        $pdf->SetXY(81.5, 83);
        $pdf->MultiCell(29, 3, $request->strtbrgy, 1, 'L');

        // town/muinicipality/city
        $pdf->SetXY(110.5, 83.5);
        $pdf->MultiCell(32, 3, $request->towncm, 1, 'L');

        // province
        $pdf->SetXY(142.5, 83.5);
        $pdf->MultiCell(28.5, 3, $request->province, 1, 'L');

        // zip
        $pdf->SetXY(171, 87);
        $pdf->MultiCell(32, 4, $request->zip, 1, 'C');

        // last school
        $pdf->SetXY(129.5, 95.3);
        $pdf->MultiCell(74, 4, $request->last_school, 1, 'L');

        // school id
        $pdf->SetXY(129.5, 104);
        $pdf->MultiCell(74, 4, $request->sc_id, 1, 'L');

        // school address
        $pdf->SetXY(129.5, 111);
        $pdf->MultiCell(74, 4, $request->school_add, 1, 'L');

        //highest grade/year/level
        $pdf->SetXY(129.5, 126);
        $pdf->MultiCell(42, 4, $request->hyl, 1, 'L');

        //disability
        $pdf->SetXY(129.5 , 133);
        (!$request->disability)? $pdf->MultiCell(42, 4, 'NA', 1, 'C') : $pdf->MultiCell(42, 4, $request->disability, 1, 'L');

        //tribal
        $pdf->SetXY(171, 132);
        (!$request->tribe)? $pdf->MultiCell(32, 3, 'NA', 1, 'C') : $pdf->MultiCell(32, 3, $request->tribe, 1, 'C');

        //citizenship
        $pdf->SetXY(41, 120);
        $pdf->MultiCell(40.5, 4, $request->citizenship, 1, 'L');

        //mobile number
        $pdf->SetXY(41, 126);
        $pdf->MultiCell(40.5, 4, $request->mobile, 1, 'L');

        //email_address
        $pdf->SetXY(41, 133);
        $pdf->MultiCell(40.5, 4, $request->email, 1, 'L');

        //father's name
        $pdf->SetXY(81, 151.5);
        $pdf->Cell(69, 4, $request->fathers_name, 1, 'L');

        //father's address
        $pdf->SetXY(81, 157);
        $pdf->Cell(69, 4, $request->fathers_add, 1, 'L');

        //father's occupation
        $pdf->SetXY(81, 162.5);
        $pdf->Cell(69, 4, $request->fathers_occ, 1, 'L');

        //father's education
        $pdf->SetXY(81, 168);
        $pdf->Cell(69, 4, $request->fathers_educ, 1, 'L');
        
        //mother's name
        $pdf->SetXY(150, 151.5);
        $pdf->Cell(55, 4, $request->mothers_name, 1, 'L');

        //mother's address
        $pdf->SetXY(150, 157);
        $pdf->Cell(55, 4, $request->mothers_add, 1, 'L');

        //mother's occupation
        $pdf->SetXY(150, 162.5);
        $pdf->Cell(55, 4, $request->mothers_occ, 1, 'L');

        //mother's education
        $pdf->SetXY(150, 168);
        $pdf->Cell(55, 4, $request->mothers_educ, 1, 'L');

        //parent's income
        $pdf->SetXY(81, 173.5);
        $pdf->Cell(69, 4, $request->p_income, 1, 'L');

        //siblings
        $pdf->SetXY(190, 172.5);
        $pdf->Cell(10, 4, $request->siblings, 1, 'C');

        //school to enroll/ currently enrolled in
        $pdf->SetXY(65, 178.5);
        $pdf->Cell(133, 4, $request->school_name2, 1, 'L');

        //school address to enroll/ currently enrolled in
        $pdf->SetXY(35, 184);
        $pdf->Cell(163, 4, $request->school_add2, 1, 'L');

        //student course
        $pdf->SetXY(36, 195);
        $pdf->Cell(162, 4, $request->current_course2, 1, 'L');
        
        //date
        $pdf->SetXY(125.5, 220);
        $pdf->MultiCell(45, 4, date('F').' '.date('d').', '.date('Y'), 1, 'C');

        //PRINTED NAME
        $pdf->SetXY(38, 220);
        $pdf->MultiCell(70, 4, strtoupper($request->fname.' '.$request->mname.' '.$request->lname), 1, 'C');

        //-----------------------Font Size 14------------------------
        $pdf->SetFont('Arial', '', 14);
         //Sex
         ($request->sex == 'FEMALE')? $pdf->SetXY(57, 97.5) : $pdf->SetXY(44.5, 97.5); 
         $pdf->Cell(3, 2, '/', 1, 'L');

        //Civil Status
        switch($request->cStatus){
            case 1: $pdf->SetXY(42, 104); break;     //single SetXY(42, 104)
            case 2: $pdf->SetXY(42, 108.5); break;   //married SetXY(42, 108.5);  
            case 3: $pdf->SetXY(58, 104); break;     // widowed SetXY(58, 104); 
            case 4: $pdf->SetXY(58, 109.5); break;   //seperate SetXY(58, 109.5); 
            case 5: $pdf->SetXY(42, 114.5); break;   //others SetXY(42, 114.5) 
            default: $pdf->SetXY(42, 104);            
        }
        $pdf->Cell(3, 2, '/', 1, 'L');

        // school sector
        ($request->school_sec == 2)? $pdf->SetXY(143.5, 119.5) : $pdf->SetXY(131, 119.5);
        $pdf->Cell(5, 4, '/', 1, 'L');

        //Father living or deceased
        ($request->fstate == 'living')? $pdf->SetXY(91.5, 145.5) : $pdf->SetXY(101.5, 145.5);
        $pdf->Cell(5, 4, '/', 1, 'L');

        //Mother living or deceased
        ($request->mstate == 'living')? $pdf->SetXY(161.5, 145.5) : $pdf->SetXY(171.5, 145.5);
        $pdf->Cell(5, 4, '/', 1, 'L');

        //School to enroll Sector 
        ($request->school_sec2 == 2)? $pdf->SetXY(45.5, 190) : $pdf->SetXY(34, 190);
        $pdf->Cell(5, 4, '/', 1, 'L');

        //have other schoalrships
        ($request->agencies)? $pdf->SetXY(85, 205) : $pdf->SetXY(97 , 205); 
        $pdf->Cell(3, 2, '/', 1, 'L');

        //-------------------Fonts Size 7--------------------------
        $pdf->SetFont('Arial', '', 7);
        if($request->agencies){
            //Other Scholarships Type and Organization Name
            $pdf->SetXY(139 , 204.5);
            $pdf->MultiCell(16, 4, $request->osc_type[0], 1, 'C');

            $pdf->SetXY(155 , 204.5);
            $pdf->MultiCell(48, 4, $request->agencies[0], 1, 'C');

            

            if($request->agencies[1]){
                $pdf->SetXY(139 , 210);
                $pdf->MultiCell(16, 4, $request->osc_type[1], 1, 'C');

                $pdf->SetXY(155 , 210);
                $pdf->MultiCell(48, 4, $request->agencies[1], 1, 'C');
            } else {
                $pdf->SetXY(139 , 210);
                $pdf->MultiCell(16, 4, 'NA', 1, 'C');
                $pdf->SetXY(155 , 210);
                $pdf->MultiCell(48, 4, 'NA', 1, 'C');
            }            
        } else {
            //Other Scholarships Type and Organization Name
            $pdf->SetXY(139 , 204.5);
            $pdf->MultiCell(16, 4, 'NA', 1, 'C');

            $pdf->SetXY(139 , 210);
            $pdf->MultiCell(16, 4, 'NA', 1, 'C');

            $pdf->SetXY(155 , 204.5);
            $pdf->MultiCell(48, 4, 'NA', 1, 'C');

            $pdf->SetXY(155 , 210);
            $pdf->MultiCell(48, 4, 'NA', 1, 'C');
        }
            
            

        

        $pdf->Output();
        //return response($pdf->Output())->header('Content-Type', 'application/pdf');        
    }
}
