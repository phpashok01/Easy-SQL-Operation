<?php

/**
* Easy Database Opration. this  class is handle approx all the database operation with the table, i have Just created for fun :) 
* @author		Ashok kashyap 
* @authoremail        ajayashok.01@gmail.com,ashok@yesweexpert.com
* @authorwebsite      http://yesweexpert.com
* @facebook          https://www.facebook.com/er.ashokkashyap, https://www.facebook.com/yesweexpert 
* @version          1.1
*/

  ///  create all function  with  all operation  for database
  class EasySqlOpration{
  
  
  
  private $hostname;
  private $hostuser;
  private $hostpass;
  private $hostdb;
  private $dblink;
  private  $debug;

  

  public  $dbconnected;
  public  $success;
  public  $sql;
  public  $error;
  public  $allquery=array();
  public  $rows;
  public  $resutlData ;
  
  
  //// connect with  database
 public  function sql_connect($host,$user,$pass,$db,$flg=false){
	  
	  $this->hostname = $host;
	  $this->username = $user; 
	  $this->password = $pass;
	  $this->database = $db;
	  $this->dbconnected=false;
	  $this->debug=$flg;
	  
	  $this->dblink = @mysql_connect($this->hostname,$this->username,$this->password);
	  
	  if (! $this->dblink)
	  {
	  $this->success=-1;
	  $this->error="Query failed: " . mysql_error()." Error No:".mysql_errno();
	  
	  }
	  // or die("error:".mysql_error());
	  
	  $db = @mysql_select_db($this->database) ;
	  
	  if (! $db)
	  {
	  $this->success=-1;
	  $this->error="Query failed: " . mysql_error()." Error No:".mysql_errno();
	  
	  }
	  
	  $this->dbconnected=true;
	  return $this->dblink;

	}



  // run database query
  
 public function query($sql){
  
	  $this->reset(); 
	  $dbResult = mysql_query($sql,$this->dblink);
	  $this->sql=$sql;
	  $this->allquery[]=$this->sql;
	  $this->rows=@mysql_num_rows($dbResult);
	  
	  if (!$dbResult)
	  {
	  $this->success=1;
	  $this->error="Query failed: " . mysql_error()." Error No:".mysql_errno();
	  
	  }else
	  {
	  $this->success=0;
	  $this->resutlData=$dbResult;
	  }
	  
	  
	  return $this->resutlData ;
  
  }	
  
  



  	// fetch all records of the table

  
   public function   fetchall($table,$type='resultset')
  {

	 	$selectData     = "SELECT * FROM $table ";
	  
	  $this->resutlData        = $this->query($selectData);  
	
	
	switch($type)
	{
	case 'resultset':
	  return $this->resutlData  ;
	  break;
	  case 'table':
	  return $this->createTable($table);
	  break;
	  case 'object':
	  return $this->select($table);
	  break;
	  
	  case 'string':
	  return $this->resutlData  ;
	  break;

	default :
	  return $this->resutlData  ;
	 }
	  
	}
	
	
	
  /// process select/view all operation
  public function select($table,$condition=''){
	  
	  $selectData     = "SELECT * FROM $table $condition";
	  
	  $queData        = $this->query($selectData);
	  
	  while($fetch = mysql_fetch_object($queData)){
	  
	  $data[] = $fetch;
	  
	  }
	  
	  return $data;
  
  }
  
  
  
  /// process insert/create operation
 public function insert($userdata,$inserttable)
  {
	  $userFields     = implode(",",array_keys($userdata));
	  
	  $userValues     = implode("','",array_values($userdata));
	  
	  $insert         = "INSERT INTO $inserttable ($userFields) VALUES('$userValues')";
	  
	  
	  $insertQuery   =$this->query($insert);
	  
	  
	  return $insertQuery ;
  
  }
  
  /// process update operation
  
 public function update($userdata,$table,$id){
  
	  $update_detail = "UPDATE $table SET ";
	  
	  $flag = 0;
	  
	  foreach($userdata as $key=>$value){
	  
	  if($flag){
	  
	  $update_detail .= ",";
	  
	  }
	  
	  $update_detail .= $key."='".$value."'";
	  
	  $flag = 1;
	  
	  }
	  
	  $update_detail .=" WHERE id = '$id'";
	  
	  return $sql_update = $this->query($update_detail);
  
  
  
  } 
  
  
  /// process delete operation
 public function delete($table,$id){
  
	  $delete = "DELETE FROM $table WHERE id = $id";
	  
	  return $delQuery = $this->query($delete);
  
  
  
  }
  
  
  
  // get last insert id 	
 public function last_insert_id(){
  
 	 return mysql_insert_id();
  
  }	

  // set  debug pofile
 public function set_debug($flg=false)
 {
  
 	 $this->debug=$flg;
  
  }	
  

  
  /// reset error and success flag		
 public  function reset()
  {
	  $this->success=-1;
	  $this->error="";
	  $this->resutlData=0;
	  $tbhis->rows=0;
	  
  
  }	
  
 
   ///  set name
   
  		public function setNames() {
			mysql_query("SET NAMES 'utf8'"); 
			mysql_query('SET CHARACTER SET utf8'); 
		}
		
	
		
	function single($sql,$type=3)
	  {
		  
		 $res=$this->query($sql);
		 if ( $this->success==0)
		 {
			 if ($this->db_rows() >0)
			 {
			 $row=$this->fetch($res,$type);
			 
			 return $row;  
			 }
			 else
			 
			 return false;
		 }
		 
	}
  

		 /// fetch data of array		
		public function fetch($r,$type='3') 
		{
			switch($type)
			{
			case '1':
			
			return mysql_fetch_object($r);
			break;
			
			case '2':
			
			return mysql_fetch_row($r);
			break;
			case '3':
			
			return mysql_fetch_array($r);
			break;
			
			
			}
		}
		
		
		 /// make secure  user input
		public function secureInput($input) 
		{
			return mysql_real_escape_string(trim($input));
		}	
  
  
  
  
  //OPTIMIZING Table    
    function optimize_table($table)
    {
        $sql= "OPTIMIZE TABLE " . $table;
        $this->query($sql);
    }

//Analysing Table    
    function analyze_table($table)
    {
        $sql = "ANALYZE TABLE ". $table;
        $this->query($sql);
    }

//Show the "create table" command for a specific table.    
    function show_create_table($table)
    {
        $sql= "SHOW CREATE TABLE ".$table;
        $res = $this->query($sql);
        $structure = $this->fetch_array($res);
        return $structure['Create Table'];
    } 
  
  
  
	public function db_rows()
	{
				
		return $this->rows;	
	}  
  
    // close database connection
 public function sql_close()
  {
	  mysql_close($this->dblink);
	  $this->dblink=NULL;
	  $this->reset();
  }
  
public function debug_var($obj,$str="Debug")
{
		echo "<h2>$str</h2>";
		if (is_array($obj) or is_object($obj))
		{
			echo"<pre> ";
			print_r($obj);
			echo "</pre>";
		}
		else
		{
			echo $obj;
		}
}

  
 	public function  sql_profoiler()
 	{

		if ($this->debug)
		{
			$str="<div id='profile' class='debug'>";
			$str.="<h3>Here is all your page Querys</h3>";
			foreach($this->allquery as $sql)
			{
				$str.="<div id='line'>$sql</div>";
			}	
			echo $str."</div>"; 
		}
		
			  
	}
    



public function free_result($result)
{
    mysql_free_result($result);   
}

}

?>
