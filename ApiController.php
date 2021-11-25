 public function searchArrived(Request $request)
   {
         $date = date('Y-m-d');
          $user_id  = $request->post('parent_id');
         $data = DB::table('i_have_arrived')
         ->where('date',$date)
         ->where('parent_id', $user_id)
         ->select('i_have_arrived.*')
         ->get();
        
        if(!empty($data && $data != ''))
         {
            
            return response()->json(['status' => '200',//sample entry
                                   'message' => 'item Found',
                                   'data'=>$data]
                                   );  
            }
        else{
            return response()->json(['status' => '404',//sample entry
                                    'message' => 'items not found']
                                   );  
            }
   }


    public function genarateQrCode(Request $request)
   {
      $qr_code_id = Str::random(6);
     $data1 = array('student_session_id' =>$request->post('student_session_id'),
          'parent_id'=>$request->post('parent_id'),
          'teacher_id'=>$request->post('teacher_id'),
          'student_id'=>$request->post('student_id'),
          'qr_code_id'=>$qr_code_id
        );    
      $data = DB::table('dispersal')->insert($data1);  
     
      $qr = QrCode::size(300)->generate($qr_code_id);
      $dataupload = file_put_contents('uploads/'. $qr_code_id . '.svg', $qr);

       if(!empty($dataupload && $dataupload != ''))
         {
          return response()->json(['status' => '200',//sample entry
   'message' => 'items found',
   'data'=>url('uploads/'. $qr_code_id . '.svg')]);  
        }
        else{
return response()->json(['status' => '404',//sample entry
   'message' => 'items not found']);  
        }
   }


public function InsertUpdateSubjectIcon(Request $request)
   {
    
        if (empty($request->post('id'))) {
        
               $record['subject_icon'] = $request->post('image');
               $record['color_code'] = $request->post('color_code');
                $record['subject_id'] = $request->post('subject_id');

                $result = DB::table('subject_icons')->insert($record);
                 if(isset($result) && $result != '')
            {
            return response()->json(['status' => '200',//sample entry
                                   'message' => 'item inserted',
                                   'data'=>$record]
                                   );  
            }
        else{
            return response()->json(['status' => '404',//sample entry
                                    'message' => 'items not inserted']
                                   );  
            }
              }
                else
                {
               $record['subject_icon'] = $request->post('image');
               $record['color_code'] = $request->post('color_code');
                $record['subject_id'] = $request->post('subject_id');
                
                $result = DB::table('subject_icons')->where('id',$request->post('id'))->update($record);
                 if(isset($result) && $result != '')
            {
            return response()->json(['status' => '200',//sample entry
                                   'message' => 'items updated',
                                   'data'=>$record]
                                   );  
            }
        else{
            return response()->json(['status' => '404',//sample entry
                                    'message' => 'items not updated']
                                   );  
            }
          }
       }  
