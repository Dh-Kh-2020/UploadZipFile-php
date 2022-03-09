<?php  
if(isset($_POST["btn_zip"]))  
{  
     $display = '';
     // $path = 'upload/'; 
     
     if($_FILES['zip_file']['name'] != '')  
     {  
          $file_name = $_FILES['zip_file']['name'];  
          $array = explode(".", $file_name);  
          $name = $array[0];  
          $ext = $array[1];  
          if($ext == 'zip')  
          {  
               $path = 'upload/';  
               $location = $path . $file_name;  
               if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
               {  
                    $zip = new ZipArchive;  
                    if($zip->open($location))  
                    {  
                         $zip->extractTo($path);  
                         $zip->close();  
                    }  
                    $files = scandir($path);      //   . $name
                    //$name is extract folder from zip file  
                    foreach($files as $file)  
                    {  
                         $tmp = explode('.', $file);
                         $file_ext = strtolower(end($tmp));
                         $allowed_ext = array('jpg', 'png','pdf','txt', 'docx','wmv', 'mp4', 'mp3');  
                         if(in_array($file_ext, $allowed_ext))    
                         {  
                              $new_name = rand().'.' . $file_ext;
                              
                              // switch($file_ex){
                              //      case 'jpg' || 'png' :
                              //           echo '<div calss="container border mt-5 mx-auto p-3 w-50">';

                              //           break;

                              //      case 'pdf'||'txt' || 'docx' :

                              //           break;

                              //      case 'wmv' || 'mp4':

                              //           break;
                              // }

                              copy($path.$name.'/'.$file, $path . $new_name);  
                              unlink($path.$name.'/'.$file);
                              echo('adding seccessfull');
                         }       
                    }  
                    unlink($location);  
                    rmdir($path . $name);    
               }
          } 
          else {
               echo '
                    <div class="border p-3 m-5 text-center text-dark">
                         <p> Only .zip files are allowed </p>
                    </div>
               ';
               // displayOnlyZip();
          }
     }  
}  

?>  

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
          crossorigin="anonymous">
     
     <title> Extract a Zip File</title>  
</head>  
<body>   
     <div class="container border mt-5 mx-auto p-3 w-50">  
          <h3 class="text-center">How to Extract a Zip File in Php</h3><br />  
          <form action="" method="post" enctype="multipart/form-data" class="d-grid gap-2 block">  
               <div class="mb-3"> 
                    <div class="pb-3"><label>Please Select Zipped File</label></div>  
                    <input type="file" name="zip_file" />
               </div> 
               <input type="submit" name="btn_zip" class="btn btn-info bg-gradient text-dark " value="Upload" />  
          </form>
     </div>
</body>  
</html>  

<?php
     // function displayOnlyZip(){
     //      echo '
     //                <div class="border p-3 m-5 text-center text-dark">
     //                     <p> Only .zip files are allowed </p>
     //                </div>
     //           ';
     // }
?>