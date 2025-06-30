<?php
   $name = $_POST['name'];
   $email = $_POST['email'];
   $message = $_POST['message'];
   mysql_connect("127.0.0.1","root","");
   mysql_select_db("kalaa");
   $res=mysql_query("insert into contact values('$name','$email','$message')");

   if ($res)
   {echo "ajout avec succees";}
   else
   {
    $res =mysql_query("select * from contact where num='$name'");
    if(mysql_num_rows($res)!=0) 
    {echo"deja existe";}
   }
   
?>