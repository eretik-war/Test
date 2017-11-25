<?php
session_start();

$connection = mysql_connect("myserver", "root", ""); 
$db = mysql_select_db ("test"); 
if (!$connection || !$db) exit(mysql_error());

if ($_REQUEST['mobilka'])
{
	if ($_REQUEST['request'] == 'login')
	{
		if ($_REQUEST['login']!= '' and $_REQUEST['pass']!= '')
		{
			$login = $_REQUEST['login']; 
			$password = $_REQUEST['pass'];
			$query = mysql_query("SELECT * FROM user_bd  WHERE log = $login AND pass = $password");
			
			if (mysql_num_rows($query)>0)
			{
				$user = mysql_fetch_assoc($query); 
				
				if ($user['uncumkey']=='+')
				{
					$id_user=$user['id_user'];
					$query1 = mysql_query("SELECT * FROM users  WHERE id = $id_user");
					
					if (mysql_num_rows($query1)>0)
					{
						$row = mysql_fetch_assoc($query1);
						
						$json_result['return'] = '1';
						$json_result['name'] = $row['name'];
						$json_result['family'] = $row['family'];
						$json_result['year'] = $row['year'];
						$json_result['Frends'] = $row['Frends'];
						$json_result['ava'] = $row['ava'];
						
					}else{$json_result['return']= 'ошибка на сервере (только для отладки)';}
				}else{$json_result['return']= 'без активации';}
			}else{$json_result['return']= 'записей нет';}
		}else{$json_result['return']= 'пустые поля';}
	}
	$json['res'] = $json_result;
	echo json_encode($json);
} 
?>