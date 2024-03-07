<?php


require_once 'conf.php';

function processForm($data) {
    global $conn;
    $query = "Select concat(per_nname,' ',per_vname) as Person, exe.exe_id as ExemplarNr, buc_name as Buchtitel,ver_start as Startdatum,ver_retour as Retourdatum
    from buchtitel buch
    join exemplar exe on buch.buc_id = exe.buc_id
    join verleih ver on exe.exe_id = ver.exe_id
    join person per on ver.per_id = per.per_id
    where ver.ver_start >= ?";
    
    $startDatumVorhanden = isset($data['date-start']) && !empty($data['date-start']);
    $endDatumVorhanden = isset($data['date-end']) && !empty($data['date-end']);
   
    $startDatum = $data['date-start'];
    
    if($startDatumVorhanden && $endDatumVorhanden){
       $Zusatz = "and ver.ver_retour <= ?";
       $query = $query . $Zusatz;
       $startDatum = $data['date-start'];
       $endDatum = $data['date-end'];
       $stmt = $conn->prepare($query);
       $stmt->execute([$startDatum,$endDatum]);
    }
    else if($startDatumVorhanden && !$endDatumVorhanden){
        $startDatum = $data['date-start'];
        $stmt = $conn->prepare($query);
        $stmt->execute([$startDatum]);
    }
    else if(!$startDatumVorhanden && $endDatumVorhanden){
        $query = "Select concat(per_nname,' ',per_vname) as Person, exe_id as ExemplarNr, buc_name as Buchtitel,ver_start as Startdatum,ver_retour as Retourdatum
        from buchtitel buch
        join exemplar exe on buch.buc_id = exe.buc_id
        join verleih ver on exe.exe_id = ver.exe_id
        join person per on ver.per_id = per.per_id
        where ver.ver_retour <= ?";
        $endDatum = $data['date-end'];
        $stmt = $conn->prepare($query);
        $stmt->execute([$endDatum]);
    }

    return $stmt;
}