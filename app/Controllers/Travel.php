<?php
namespace App\Controllers;
 class Travel extends BaseController
 {
     public function index()
     {
         // connect to the model
         $places = new \App\Models\Places();
         // retrieve all the records
         $records = $places->findAll();
         
         //get a template parser
         $parser = \Config\Services::parser();
         //tell it about the substitions    
         
         $table = new \CodeIgniter\View\Table();

         $headings = $places->fields;
         $displayHeadings = array_slice($headings, 1, 2);
         $table->setHeading(array_map('ucfirst', $displayHeadings));
         
         foreach ($records as $record) {
             $nameLink = anchor("travel/showme/$record->id",$record->name);
             $table->addRow($nameLink,$record->description);
         }
         
         $template = [
             'table_open' => '<table cellpadding="10px">',
             'cell_start' => '<td style="border: 5px solid #FF0000;">',
             'row_alt_start' => '<tr style="background-color:#7E3D76">',
             ];
         $table->setTemplate($template);
         
         $fields = [
             'title' => 'Travel Destinations',
             'heading' => 'Travel Destinations',
             'footer' => 'Liu Chang'
             ];
          return $parser->setData($fields)
                         ->render('templates\top') .
                  $table->generate() .
                  $parser->setData($fields)
                         ->render('templates\bottom');

         return $table->generate(); 
     }
     
     public function showme($id)
     {
         // connect to the model
         $places = new \App\Models\Places();
         // retrieve all the records
         $record = $places->find($id);
         
         // get a template parser     
         $parser = \Config\Services::parser();     
         // tell it about the substitions     
         
         $table = new \CodeIgniter\View\Table();

         $headings = $places->fields;
