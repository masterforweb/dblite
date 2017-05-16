<?php

	/**
	* хранитель конфигураций
	*/
	function db_config($name = '', $connect = '', $user = 'root', $pwd = '') {
		
		static $config = array();

		
		if ($connect == ''){
			if (count($config) > 0) {
				if ($name == '') {
					return current($config);
				}
				elseif (isset($config[$name])){
					return $config[$name];
				}
			}

		}	
		else {
			
			if ($db == '')
				$db = $name;

			$config[$name] = ['user' => $user, 'pwd' => $pwd, 'connect' => $connect];
			
			return True;
		}

		return False;

	}	


	/**
	* хранитель коннектов
	*/
	function db_conn($name = '') {

		static $connects = array();


		/* кешируем коннект */
		if (isset($connects[$name])){
			return $connects[$name];
		}


		if (is_array($config = db_config($name))) {

			print_r($config);

			$mysql = new PDO($config['connect'], $config['user'], $config['pwd']);
			//$mysql =  new mysqli($config['host'], $config['user'], $config['pwd'], $config['db']);
			//$mysql->query('SET NAMES UTF8');

			return $mysql;

			//return $connects[$name] = $mysql;

		}	
		
		else
			return False;

	}	


	/**
	* исполнитель запросов
	*/
	function db_query($query, $conf = ''){

		$conn = db_conn($conf);

		$result = $conn->prepare($query);
		$result->execute();
		
    	if (strripos($query, 'INSERT INTO') === 0)
        	return $result->lastInsertId();
        else
        	return $result->fetchAll();;

	}	



	/**
	* возвращатель результатов
	*/
	function db_get($query, $conf = '') {

		$result = db_query($query, $conf);

		return $result;

	}




	function db_insert($table, $items = array(), $conf = '') {

		foreach($items as $key => $item){
        
        	$item = trim($item);

        	if ($item !== '') {
            	
            	if (isset($columns))
            			$columns .= ',';
               	$columns .= '`'.$key.'`';
          		
            	if (isset($values))
            		$values .= ',';
          		$values .= '"'.$item.'"';
        	
        	}  

      	}

      	$query = 'INSERT INTO `'.$table.'` ('.$columns.') VALUES('.$values.');';
		
		return db_query($query);
	}


		
