<?php
$headers = "Name,Last Name,Telephone,Mobile,Email,Description,Company type,Company category,Company name,Company website";
$contactsCSV = $headers."\n";

$temp = [];
foreach($contacts as $c){
    $temp['Name']       = $c['first_name'];
    $temp['Last Name']  = $c['last_name'];
    $temp['Telephone']  = $c['telephone'];
    $temp['Mobile']     = $c['mobile'];
    $temp['Email']      = $c['email'];
    $temp['Description'] = $c['description'];
    if(is_object($c->customer)){
        // dd($c['customer']);
        $temp['Company type']    = $c['customer']->type;
        $temp['Company category']= $c['customer']->category->name;
        $temp['Company name']    = $c['customer']->name;
        $temp['Company website'] = $c['customer']->website;

    }else{
        $temp['Company type'] = '';
        $temp['Company category']= '';
        $temp['Company name']    = '';
        $temp['Company website'] = '';
    }

    $contact = implode(',',$temp);
    $contactsCSV .= $contact."\n";
    $temp = [];
}
echo $contactsCSV;
