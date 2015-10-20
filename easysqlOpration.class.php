<?php
include 'easysqlOpration.class.php';

// create  object of  EasySqlOpration class
$dbOpration = new EasySqlOpration();


/// pass the database details for the  mysql connection
 // last parameter is for the debug database query and show into thte footer area   if true
$dbOpration->sql_connect("localhost","root","","easymysql",true);


/// check database is connected or not
if ($dbOpration->dbconnected==false)
{
	die ("connection error ");
	
}




/// table name
$tableName="userinfo";

//  set table data
$tableData['Name']='ashok kumar';
$tableData['Email']='ajayashok.01@gmail.com';
$tableData['Mobile']='9194669559398';


/// run insert  function with two parameter tabledata, tablename
$dbOpration->insert($tableData,$tableName);


// set update information for the  given table
$tableData['Name']='ashok kumar1';
$tableData['Email']='ajayashok.01@gmail.com1';
$tableData['Mobile']='91946695593981';

/// run update  function with 3 parameters tabledata, tablename , Primary key
$dbOpration->update($tableData,$tableName,2);

/// check mysql error if have by last function 
if($dbOpration->error!="" )
{
echo $dbOpration->error; 	
die($dbOpration->error);
}

///  get last insert ID by last  mysql 
$sub=$dbOpration->last_insert_id();

/// run custom sql query like this
$sql="insert INTO  userinfo (Name,Email,Mobile)  values('ajay','admin@admin.com','1234657890');";


/// run query  function with 1 parameter sql
$dbOpration->query($sql);


/// check mysql error if have by last function 

if($dbOpration->error!="" )
{
echo $dbOpration->error; 	
die($dbOpration->error);
}

////  get single  row  with custom query and with fetch type

//  1  Objeect
//  2  Row
//  3  Array

$row=$dbOpration->single("select * from userinfo where ID='2'",1);


// display single row data  with  given title
$dbOpration->debug_var($row,'Single Row');

///// delete table row with primary key

$dbOpration->delete('userinfo',5);


/// select all rows form given table
$rows=$dbOpration->select($tableName);

//debug your variable, string ,array,object 

//////  run debug_var  with 2 parameter variable name,  title name/caption 
$dbOpration->debug_var($rows,'All Records');

// get all records for the given table name as Object
$object=$result=$dbOpration->fetchall('userinfo','object');

$dbOpration->debug_var($object,'As Object');

// get all records for the given table name as Resultset
$result=$dbOpration->fetchall('userinfo');

//fetch record from  result set with given paramater like fetch array, object, row

//  1  Objeect
//  2  Row
//  3  Array

while ($row = $dbOpration->fetch($result,1))
{
	//echo '<hr/>';
	//$dbOpration->debug_var($row,'in loop');
	
	}




echo "<hr size='4'/>";
echo " <h1>Mysql Query Profiler</h1> ";
$dbOpration->sql_profoiler();
$dbOpration->sql_close();
?>
